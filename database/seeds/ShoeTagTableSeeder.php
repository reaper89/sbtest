<?php

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 15:04
 */

use App\Shoe;
use App\Tag;
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;

class ShoeTagTableSeeder extends Seeder{
    public function run()
    {
        $faker = Faker::create();

        $shoeIds = Shoe::pluck('id')->toArray();
        $tagIds = Tag::pluck('id')->toArray();

        foreach(range(1,30) as $index){
            DB::table('shoe_tag')->insert([
                'shoe_id'   => $faker->randomElement($shoeIds),
                'tag_id'    => $faker->randomElement($tagIds),
            ]);
        }
    }
}