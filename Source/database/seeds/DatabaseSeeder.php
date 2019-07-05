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
    	$this->call(CategoryTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(PhotoTableSeeder::class);
        $this->call(PlaceTableSeeder::class);
        $this->call(UserTableSeeder::class);
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
    		['name' => Str::random(4),
    		'created_at'=>date('Y-m-d H:i:s'),
    		'updated_at'=>date('Y-m-d H:i:s')],
            ['name' => Str::random(4),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')],
            ['name' => Str::random(4),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')],
            ['name' => Str::random(4),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')],
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
    		['name'=>'Đà Nẵng'],
            ['name'=>'Hà Nội'],
            ['name'=>'Huế'],
        ]
    );
    }
}
class PhotoTableSeeder extends Seeder
{
   public function run()
   {
    DB::table('photos')->insert([
     [
        'photo_path'=>'hinh1.jpg',
        'flag'=>'1',
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
    ],
    [
        'photo_path'=>'hinh2.jpg',
        'flag'=>'1',
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
    ], [
        'photo_path'=>'hinh3.jpg',
        'flag'=>'2',
        'created_at'=>date('Y-m-d H:i:s'),
        'updated_at'=>date('Y-m-d H:i:s'),
    ]
]
);
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
    		['category_id'=>'2',
            'name'=>'Hồ Tây',
            'photo_id'=>'2',
            'address'=>'Hà Nội',
            'lat'=>'40',
            'longt'=>'30',
            'districts_id'=>'4',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),],
            ['category_id'=>'1',
            'name'=>'Chùa Linh Ứng',
            'photo_id'=>'1',
            'address'=>'Đà Nẵng',
            'lat'=>'40',
            'longt'=>'30',
            'districts_id'=>'2',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),],
            ['category_id'=>'2',
            'name'=>'Bà Nà',
            'photo_id'=>'2',
            'address'=>'Đà Nẵng',
            'lat'=>'40',
            'longt'=>'30',
            'districts_id'=>'4',
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),]
    	]
    );
    }
}
class RatingTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        for ($i=101; $i <= 200; $i++) { 
            $month =mt_rand(1,12);
            $rating = mt_rand(1,5);
            DB::table('ratings')->insert([
               'id' => $i,
               'cmt' => str_random(20),
               'post_id' => $i,
               'user_id' => $i,
               'rating' => $rating,
               'created_at'=>date("2018-$month-d H:i:s"),
               'updated_at'=>date('Y-m-d H:i:s'),
   
           ]);
       }
    }
}
