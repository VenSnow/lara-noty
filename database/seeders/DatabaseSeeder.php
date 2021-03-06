<?php

namespace Database\Seeders;

use App\Models\User;
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
         User::factory(1)->create([
             'name' => 'test',
             'password' => Hash::make('test')
         ]);
         $this->call(ClientSeeder::class);
         $this->call(HostSeeder::class);
         $this->call(ProjectSeeder::class);
    }
}
