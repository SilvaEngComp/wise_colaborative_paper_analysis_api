<?php

namespace Database\Seeders;

use App\Models\ProtocolType;
use Illuminate\Database\Seeder;

class ProtocolTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProtocolType::create([
            "name"=>"Item do protocolo"
        ]);
        ProtocolType::create([
            "name"=>"Critério de seleção"
        ]);
        ProtocolType::create([
            "name"=>"Critério de exclusão"
        ]);
    }
}
