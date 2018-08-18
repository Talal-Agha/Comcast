<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::unprepared(file_get_contents(database_path() . '/seeds/states.sql'));
        $this->command->info('States table seeded!');

        DB::unprepared(file_get_contents(database_path() . '/seeds/cities.sql'));
        $this->command->info('Cities table seeded!');
        $this->call(UsersTableSeeder::class);
        // $this->call(ProductTypesTableSeeder::class);
    }
}
