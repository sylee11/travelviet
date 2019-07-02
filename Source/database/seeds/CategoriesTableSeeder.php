<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        for ($i=1; $i < 30; $i++) { 
            DB::table('categories')->insert([
               'id' => $i,
               'name' => str_random(20),
               'created_at'=>date('Y-m-d H:i:s'),
               'updated_at'=>date('Y-m-d H:i:s'),
   
           ]);
       }
    }
}
