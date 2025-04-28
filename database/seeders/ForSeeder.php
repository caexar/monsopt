<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ForSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $support = User::create([
                'name' => 'support' . $i,
                'email' => 'support'. $i . '@hot.co',
                'password' => bcrypt('1234'),
                'email_verified_at' => Carbon::now(),
                'remember_token'    => Str::random(10),
            ]);

            $support->assignRole('Support');

            $user = User::create([
                'name' => 'user' . $i,
                'email' => 'user'. $i . '@hot.co',
                'password' => bcrypt('1234'),
                'email_verified_at' => Carbon::now(),
                'remember_token'    => Str::random(10),
            ]);

            $user->assignRole('User');
        }
    }
}
