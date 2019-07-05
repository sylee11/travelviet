<?php

use Illuminate\Database\Seeder;

class RatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 100; $i++) { 
            $month =mt_rand(1,12);
            $rating = mt_rand(1,5);
            DB::table('ratings')->insert([
               'id' => $i,
               'cmt' => str_random(20),
               'post_id' => $i,
               'user_id' => $i,
               'rating' => $rating,
               'created_at'=>date("2019-$month-d H:i:s"),
               'updated_at'=>date('Y-m-d H:i:s'),
   
           ]);
       }
    }
}
