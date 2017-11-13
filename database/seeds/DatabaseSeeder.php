<?php

use App\Shoe;
use App\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * @var array
     */
    private $tables = [
        'shoes',
        'tags',
        'shoe_tag',
        'users',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanupDatabase();

        $this->call(UserTableSeeder::class);
        $this->call(ShoesTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(ShoeTagTableSeeder::class);
    }

    /**
     *
     */
    public function cleanupDatabase()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        foreach($this->tables as $tableName){
            DB::table($tableName)->truncate();
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }
}
