<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' =>1,
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('000111'),
        ]);
       /* for ($i=102; $i <= 202; $i++) { 
            $month =mt_rand(1,12);
            $rating = mt_rand(1,5);
            DB::table('users')->insert([
               'id' => $i,
               
               'created_at'=>date("2019-$month-d H:i:s"),
               'updated_at'=>date('Y-m-d H:i:s'),
   
           ]);
       }*/
    }
}
