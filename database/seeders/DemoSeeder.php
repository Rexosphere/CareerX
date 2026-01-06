<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use App\Models\JobPosting;
use App\Models\StudentProfile;
use App\Models\Video;
use App\Models\ResearchProject;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = (int) config('demo.users', env('DEMO_USERS', 50));
        $companies = (int) config('demo.companies', env('DEMO_COMPANIES', 20));
        $videos = (int) config('demo.videos', env('DEMO_VIDEOS', 100));
        $projects = (int) config('demo.projects', env('DEMO_PROJECTS', 40));
        $profilesPercent = (int) config('demo.profiles_percent', env('DEMO_PROFILES_PERCENT', 50));

        $this->command->info("Seeding demo data: users={$users}, companies={$companies}, videos={$videos}, projects={$projects}");

        // Users
        $createdUsers = User::factory($users)->create();

        // Some users get student profiles
        $profileCount = (int) round($createdUsers->count() * ($profilesPercent / 100));
        $createdUsers->shuffle()->take($profileCount)->each(function ($user) {
            StudentProfile::factory()->create(['user_id' => $user->id]);
        });

        // Companies and their job postings
        $createdCompanies = Company::factory($companies)->create();

        foreach ($createdCompanies as $company) {
            // Ensure company is active for job postings
            if ($company->status !== 'active') {
                $company->update(['status' => 'active']);
            }

            $count = rand(2, 8);
            JobPosting::factory($count)->create([
                'company_id' => $company->id,
                'company_name' => $company->name,
                'company_logo' => $company->logo_path,
            ]);
        }

        // Videos
        Video::factory($videos)->create();

        // Research projects
        ResearchProject::factory($projects)->create();

        $this->command->info('Demo seeding complete.');
    }
}
