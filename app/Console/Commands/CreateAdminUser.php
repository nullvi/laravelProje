<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {--name=Admin : The name of the admin user} {--email=admin@example.com : The email of the admin user} {--password=password : The password for the admin user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user if none exists';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Check if an admin user already exists
        $adminExists = User::where('role', 'admin')->exists();

        if ($adminExists) {
            $this->info('An admin user already exists!');

            if (!$this->confirm('Do you want to create another admin user?')) {
                return;
            }
        }

        // Get the command options or use defaults
        $name = $this->option('name');
        $email = $this->option('email');
        $password = $this->option('password');

        // Create the admin user
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
            'is_approved' => true,
        ]);

        $this->info("Admin user created successfully!");
        $this->table(
            ['Name', 'Email', 'Password'],
            [[$user->name, $user->email, $password]]
        );
    }
}
