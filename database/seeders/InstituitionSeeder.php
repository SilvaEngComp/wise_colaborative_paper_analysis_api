<?php

namespace Database\Seeders;

use App\Models\Instituition;
use Illuminate\Database\Seeder;
use Str;
class InstituitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filename = storage_path('/app/public/instituitions/instituitions.csv');
        $file = fopen($filename, 'r');

        while (($inst = fgetcsv($file)) != null) {
            Instituition::create([
                "region" =>  utf8_encode($inst[0]),
                "state" =>  utf8_encode($inst[1]),
                "name" => utf8_encode($inst[2]),
                "abreviation" =>  utf8_encode($inst[3]),
            ]);
        }

        fclose($file);
    }
}
