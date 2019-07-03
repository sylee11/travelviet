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
    	$this->call(PlaceTableSeeder::class);
    }
}

class CategoryTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('categories')->insert([
    		'name' => Str::random(4),
    		'created_at'=>date('Y-m-d H:i:s'),
    		'updated_at'=>date('Y-m-d H:i:s'),
    	]);
    }
}
class CityTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('cities')->insert([
    		'name'=>'Tp Hồ Chí Minh',
    	]);
    }
}
class PlaceTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('places')->insert([
    		'category_id'=>'2',
    		'name'=>'Hồ Tây',
    		'photo_id'=>'2',
    		'address'=>'Hà Nội',
    		'lat'=>'40',
    		'longt'=>'30',
    		'districts_id'=>'4',
    		'created_at'=>date('Y-m-d H:i:s'),
    		'updated_at'=>date('Y-m-d H:i:s'),
    	]
    );
    }
}
