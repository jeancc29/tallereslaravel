<?php

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
        $this->truncateTables([
            "units"
        ]);
        $this->call(UnitSeeder::class);
    }

    public function truncateTables(array $tables){
        

            DB::statement('SET FOREIGN_KEY_CHECKS = 0');
            foreach($tables as $t){
                DB::table($t)->truncate();
            }
        
    }
}
