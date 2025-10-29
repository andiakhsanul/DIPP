<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {email} {name} {password} {--role=user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => Hash::make($this->argument('password')),
            'role' => $this->option('role'),
            'email_verified_at' => now(),
        ]);

        $this->info("User created successfully!");
        $this->info("Email: {$user->email}");
        $this->info("Name: {$user->name}");
        $this->info("Role: {$user->role}");

        return 0;
    }
}
