<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SQLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php arisan seede
        DB::unprepared(file_get_contents('database/data/mokav2-220524.sql')); 
    }
}
