<?php

use Illuminate\Database\Seeder;
use Laravel\Passport\ClientRepository;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $client = new ClientRepository();

        $client->createPasswordGrantClient(null, 'Default password grant client', 'http://localhost');
        $client->createPersonalAccessClient(null, 'Default personal access client', 'http://localhost');
    }
}
