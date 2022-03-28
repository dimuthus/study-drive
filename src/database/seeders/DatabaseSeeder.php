<?php

namespace Database\Seeders;

use App\Models\Course;
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
        //$this->call(BookSeeder::class);
        $this->call(StudentSeeder::class);
        $this->call(CourseSeeder::class);

    }
}
