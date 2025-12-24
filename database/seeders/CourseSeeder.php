<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Mastering React & Modern Web Development',
                'category' => 'Software Engineering',
                'content' => 'Dive deep into React hooks, state management with Redux/Zustand, and building scalable front-end applications. This course covers everything from JSX basics to advanced performance optimization techniques.',
            ],
            [
                'title' => 'Structural Analysis for Civil Engineers',
                'category' => 'Civil Engineering',
                'content' => 'A comprehensive guide to analyzing beams, trusses, and frames. Learn to calculate internal forces, displacements, and stability in various structural systems using both manual and software-assisted methods.',
            ],
            [
                'title' => 'Deep Learning & Neural Networks',
                'category' => 'Data Science & AI',
                'content' => 'Explore the architecture of modern AI. Learn about CNNs, RNNs, Transformers, and how to train them using PyTorch and TensorFlow. Includes practical projects in image recognition and NLP.',
            ],
            [
                'title' => 'UI/UX Design Masterclass',
                'category' => 'Design',
                'content' => 'Craft beautiful and functional user interfaces. Learn about typography, color theory, wireframing, and interactive prototyping using Figma and Adobe XD. Focus on user-centric design principles.',
            ],
            [
                'title' => 'Financial Modeling & Analysis',
                'category' => 'Finance',
                'content' => 'Master the art of building financial models in Excel. This course covers DCF analysis, M&A modeling, and risk assessment for corporate finance professionals.',
            ],
            [
                'title' => 'Digital Marketing Strategy 2024',
                'category' => 'Marketing',
                'content' => 'Learn to grow brands in the digital age. Covers SEO, SEM, social media marketing, and data-driven decision making to maximize ROI in your marketing campaigns.',
            ],
            [
                'title' => 'Project Management Professional (PMP) Prep',
                'category' => 'Management',
                'content' => 'Prepare for the PMP certification. Learn about Agile, Waterfall, and hybrid methodologies. Covers stakeholders, risk management, and the 10 knowledge areas of project management.',
            ],
            [
                'title' => 'Cloud Architecture with AWS',
                'category' => 'Cloud Computing',
                'content' => 'Design scalable and resilient systems on AWS. Learn about EC2, S3, RDS, and serverless computing with Lambda. Perfect for aspiring Cloud Architects.',
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['title' => $course['title']], $course);
        }
    }
}
