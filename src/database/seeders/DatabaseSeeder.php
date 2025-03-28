<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure roles are created only once
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        // Create 5 test users
        for ($i = 1; $i <= 5; $i++) {
            $user = User::factory()->create([
                'name' => "Test User $i",
                'email' => "user$i@test.com",
                'password' => bcrypt('password'), // Default password for all users
            ]);

            // Assign the 'user' role to all test users
            $user->assignRole('user');
        }

        // Optionally, assign the 'admin' role to the first user
        $adminUser = User::where('email', 'user1@test.com')->first();
        if ($adminUser) {
            $adminUser->syncRoles(['admin']);
        }
    }
}
