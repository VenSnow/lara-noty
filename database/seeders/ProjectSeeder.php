<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Host;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Host::all()->each(function (Host $host) {
           $host->projects()->saveMany(Project::factory()->times('3')->make(['client_id' => $host->client->id]));
        });
    }
}
