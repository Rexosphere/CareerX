<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Console\Command;

class CreateAdminFromUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create-from-user {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin account from an existing user account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        // Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        // Check if an admin with this email already exists
        $existingAdmin = Admin::where('email', $email)->first();

        if ($existingAdmin) {
            $this->error("An admin account with email '{$email}' already exists.");
            return 1;
        }

        // Confirm action
        if (!$this->confirm("Create admin account for '{$user->name}' ({$user->email})?", true)) {
            $this->info('Operation cancelled.');
            return 0;
        }

        // Use the existing user's password (already hashed)
        $password = $user->password;

        // Create the admin account
        try {
            $admin = Admin::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $password,
            ]);

            $this->info('');
            $this->info('✓ Admin account created successfully!');
            $this->line("Name: {$admin->name}");
            $this->line("Email: {$admin->email}");
            $this->line("ID: {$admin->id}");
            $this->info('');
            $this->info('The admin can now login at /admin/login');

            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to create admin account: {$e->getMessage()}");
            return 1;
        }
    }
}
