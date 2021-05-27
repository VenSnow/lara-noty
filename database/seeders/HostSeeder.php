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
        Host::factory(25)->create();
        Client::all()->each(function (Client $client) {
            $random_hosts = Host::all()->random( rand(1, 10) )->pluck('id');
            $client->hosts()->attach($random_hosts);
        });
    }
}
