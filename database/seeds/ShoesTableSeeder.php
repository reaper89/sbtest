<?php
/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 14:58
 */

use App\Shoe;
use Faker\Factory as Faker;
use \Illuminate\Database\Seeder;

class ShoesTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker::create();

        foreach(range(1,20) as $index){
            Shoe::create([
                'brand' => $faker->company,
                'model' => $faker->word,
                'size' => random_int(34,46),
                'price' => $faker->numberBetween(20, 200)
            ]);
        }
    }

}