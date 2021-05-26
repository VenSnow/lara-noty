<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Host;
use Illuminate\Database\Seeder;

class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Client::all()->each(function (Client $client) {
           $client->hosts()->saveMany(Host::factory()->times(2)->make());
        });
    }
}
