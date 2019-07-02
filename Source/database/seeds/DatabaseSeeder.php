<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@gmail.com',
            'password' => bcrypt('000111'),
            'name' => 'admin',
            'created_at' => '2005-12-26 23:50:30',
            'updated_at' => '2005-12-26 23:50:30'
            
        ]);
    }
}
