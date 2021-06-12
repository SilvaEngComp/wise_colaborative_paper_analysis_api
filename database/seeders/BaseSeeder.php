<?php

namespace Database\Seeders;

use App\Models\Base;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Base::create([
            "name"=>"IEEE",
        ]);

        Base::create([
            "name"=>"Springer Link",
        ]);

        Base::create([
            "name"=>"Scopus",
        ]);
    }
}
