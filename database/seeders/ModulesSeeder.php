<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModulesSeeder extends Seeder
{

    public function run() : void
    {
        DB::table('modules')->insert([
            ['name' => 'General', 'enabled' => true , 'last_migrated_at' => now()],
            ['name' => 'Motors', 'enabled' => true, 'last_migrated_at' => now()],
            ['name' => 'Jobs', 'enabled' => true, 'last_migrated_at' => now()],
        ]);
    }
    
}