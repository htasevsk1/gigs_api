<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Gig;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@gmail.com',
            'password' => Hash::make('P@ssw0rd')
        ]);

        Company::factory()->count(5)->create();

        Gig::factory()->count(5)->create();
    }
}
