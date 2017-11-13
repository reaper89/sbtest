<?php
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

/**
 * Created by PhpStorm.
 * User: KevinPC
 * Date: 12-11-2017
 * Time: 19:27
 */
class UserTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        User::create([
            'name' => 'Testing',
            'email' => 'test@test.com',
            'password' => Hash::make('sbtest'),
        ]);

        $user = User::find(1);
    }
}