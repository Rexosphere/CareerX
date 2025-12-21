<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            ['name' => 'view-jobs', 'display_name' => 'View Jobs', 'category' => 'jobs'],
            ['name' => 'create-jobs', 'display_name' => 'Create Jobs', 'category' => 'jobs'],
            ['name' => 'edit-jobs', 'display_name' => 'Edit Jobs', 'category' => 'jobs'],
            ['name' => 'delete-jobs', 'display_name' => 'Delete Jobs', 'category' => 'jobs'],
            ['name' => 'moderate-jobs', 'display_name' => 'Moderate Jobs', 'category' => 'jobs'],

            ['name' => 'view-profiles', 'display_name' => 'View Student Profiles', 'category' => 'profiles'],
            ['name' => 'edit-own-profile', 'display_name' => 'Edit Own Profile', 'category' => 'profiles'],

            ['name' => 'create-blogs', 'display_name' => 'Create Blogs', 'category' => 'blogs'],
            ['name' => 'moderate-blogs', 'display_name' => 'Moderate Blogs', 'category' => 'blogs'],

            ['name' => 'manage-users', 'display_name' => 'Manage Users', 'category' => 'admin'],
            ['name' => 'manage-roles', 'display_name' => 'Manage Roles', 'category' => 'admin'],
        ];

        foreach ($permissions as $perm) {
            \App\Models\Permission::firstOrCreate(['name' => $perm['name']], $perm);
        }

        // Create Roles
        $adminRole = \App\Models\Role::firstOrCreate(
            ['name' => 'admin'],
            ['display_name' => 'Administrator', 'description' => 'Full system access']
        );
        $adminRole->permissions()->sync(\App\Models\Permission::all());

        $employerRole = \App\Models\Role::firstOrCreate(
            ['name' => 'employer'],
            ['display_name' => 'Employer', 'description' => 'Can post jobs and view student profiles']
        );
        $employerRole->permissions()->sync(
            \App\Models\Permission::whereIn('name', ['view-jobs', 'create-jobs', 'edit-jobs', 'view-profiles'])->pluck('id')
        );

        $studentRole = \App\Models\Role::firstOrCreate(
            ['name' => 'student'],
            ['display_name' => 'Student', 'description' => 'Can apply for jobs and manage profile'
        ]);
        $studentRole->permissions()->sync(
            \App\Models\Permission::whereIn('name', ['view-jobs', 'edit-own-profile'])->pluck('id')
        );
    }
}
