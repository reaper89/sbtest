<?php

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 14:58
 */

use App\Tag;
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;

class TagsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $tags = ['Men', 'Women', 'Sneaker', 'Business', 'Casual', 'Sport'];

        foreach(range(1,6) as $index){
            Tag::create([
                'name' => $tags[$index-1],
            ]);
        }
    }
}