<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@hot.co',
            'password' => bcrypt('1234'),
            'email_verified_at' => Carbon::now(),
            'remember_token'    => Str::random(10),
        ]);

        $admin->assignRole('Admin');

        $support = User::create([
            'name' => 'support',
            'email' => 'support@hot.co',
            'password' => bcrypt('1234'),
            'email_verified_at' => Carbon::now(),
            'remember_token'    => Str::random(10),
        ]);

        $support->assignRole('Support');

        $user = User::create([
            'name' => 'user',
            'email' => 'user@hot.co',
            'password' => bcrypt('1234'),
            'email_verified_at' => Carbon::now(),
            'remember_token'    => Str::random(10),
        ]);

        $user->assignRole('User');
    }
}
