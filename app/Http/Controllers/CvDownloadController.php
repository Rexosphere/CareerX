<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class CvDownloadController extends Controller
{
    /**
     * Download CV from student profile
     * Only accessible by:
     * - The student themselves
     * - Companies that have received an application from this student
     */
    public function downloadFromProfile(int $studentId): Response
    {
        $student = User::with('studentProfile')->findOrFail($studentId);
        $profile = $student->studentProfile;

        if (!$profile || !$profile->cv_path) {
            abort(404, 'CV not found');
        }

        // Authorization check
        $user = auth('web')->user();
        
        // Allow if user is viewing their own profile
        if ($user && $user->id === $studentId) {
            return $this->serveCv($profile->cv_path, $student->name);
        }

        // Allow if user is a company that has received an application from this student
        if (auth('company')->check()) {
            $companyId = auth('company')->id();
            
            // Check if this company has any job postings that received an application from this student
            $hasApplication = Application::whereHas('jobPosting', function ($query) use ($companyId) {
                $query->where('company_id', $companyId);
            })
            ->where('student_id', $studentId)
            ->exists();

            if ($hasApplication) {
                return $this->serveCv($profile->cv_path, $student->name);
            }
        }

        // Deny access
        abort(403, 'You do not have permission to access this CV');
    }

    /**
     * Download CV from application
     * Only accessible by the company that owns the job posting
     */
    public function downloadFromApplication(int $applicationId): Response
    {
        $application = Application::with(['student', 'jobPosting'])->findOrFail($applicationId);

        if (!$application->cv_path) {
            abort(404, 'CV not found');
        }

        // Authorization check - only the company that owns the job posting can access
        if (!auth('company')->check()) {
            abort(403, 'You must be logged in as a company to access this CV');
        }

        $companyId = auth('company')->id();
        
        if ($application->jobPosting->company_id != $companyId) {
            abort(403, 'You do not have permission to access this CV');
        }

        return $this->serveCv($application->cv_path, $application->student->name);
    }

    /**
     * Helper method to serve CV file
     */
    private function serveCv(string $path, string $studentName): Response
    {
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'CV file not found on server');
        }

        $file = Storage::disk('public')->get($path);
        $mimeType = Storage::disk('public')->mimeType($path);
        
        // Sanitize filename
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $studentName) . '_CV.pdf';

        return response($file, 200)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
    }

    /**
     * Download all CVs for a job posting as a zip file
     * Only accessible by the company that owns the job posting
     */
    public function downloadBulkCvs(int $jobId): Response
    {
        $job = \App\Models\JobPosting::with(['applications.student'])->findOrFail($jobId);

        // Authorization check - only the company that owns the job posting can access
        if (!auth('company')->check()) {
            abort(403, 'You must be logged in as a company to access this feature');
        }

        $companyId = auth('company')->id();
        
        if ($job->company_id != $companyId) {
            abort(403, 'You do not have permission to download these CVs');
        }

        // Get all applications with CVs
        $applications = $job->applications()->whereNotNull('cv_path')->get();

        if ($applications->isEmpty()) {
            abort(404, 'No CVs found for this job posting');
        }

        // Create a temporary zip file
        $zipFileName = 'CVs_' . preg_replace('/[^A-Za-z0-9_\-]/', '_', $job->title) . '_' . now()->format('Y-m-d') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            abort(500, 'Could not create zip file');
        }

        // Add each CV to the zip
        foreach ($applications as $application) {
            $cvPath = Storage::disk('public')->path($application->cv_path);
            
            if (file_exists($cvPath)) {
                $studentName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $application->student->name);
                $extension = pathinfo($cvPath, PATHINFO_EXTENSION);
                $zipEntryName = $studentName . '_CV.' . $extension;
                
                // Handle duplicate names by appending numbers
                $counter = 1;
                $originalName = $zipEntryName;
                while ($zip->locateName($zipEntryName) !== false) {
                    $zipEntryName = $studentName . '_CV_' . $counter . '.' . $extension;
                    $counter++;
                }
                
                $zip->addFile($cvPath, $zipEntryName);
            }
        }

        $zip->close();

        // Send the zip file and delete it afterwards
        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }
}
