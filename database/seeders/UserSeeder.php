<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name"=>"Eliabe Nascimento Silva",
            "email"=>"silvaengcomp@gmail.com",
            "active"=>true,
            "policy"=>true,


        ]);
    }
}
