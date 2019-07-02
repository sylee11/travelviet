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
            'name' => 'syle',
            'email' => 'anhsypro123@gmail.com',
            'password' => bcrypt('12341234'),
            'status' =>'0',
            'role' => '3',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ]);


        DB::table('posts')->insert([
            'user_id' => '1',
            'title' => 'abc',
            'phone' => '12341234',
            'place_id' =>'3',
            'is_approved' => '1',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),

        ]);
    }
}
