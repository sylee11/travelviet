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
            'status' => '1',
            'name' => 'admin',
            'birthday' => '1000-01-01 00:00:00',
            'address_user' => ' ',
            'phone_user' => '123',
            'avatar' => ' ', 
            'remember_token' => ' ',
            'role' => '1',
            'socials_id' => '1',
            'created_at' => '2005-12-26 23:50:30',
            'updated_at' => '2005-12-26 23:50:30'
            
        ]);
    }
}
