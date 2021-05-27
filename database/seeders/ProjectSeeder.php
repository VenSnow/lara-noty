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
        Client::all()->each(function (Client $client) {
            $random_host = collect($client->hosts->all())->random(1)->pluck('id');
            $client->projects()->saveMany(Project::factory()->times('10')->make(['host_id' => $random_host[0]]));
        });
    }
}
