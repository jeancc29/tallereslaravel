<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Unit::create([
            "descripcion" => "Unidad",
            "abreviatura" => "U/D",
            "valor" => 1,
        ]);
        \App\Unit::create([
            "descripcion" => "Par",
            "abreviatura" => "PAR/S",
            "valor" => 2,
        ]);
        \App\Unit::create([
            "descripcion" => "Galon",
            "abreviatura" => "GLN/S",
            "valor" => 1,
        ]);
        \App\Unit::create([
            "descripcion" => "Gruesa",
            "abreviatura" => "Gruesa",
            "valor" => 144,
        ]);
    }
}
