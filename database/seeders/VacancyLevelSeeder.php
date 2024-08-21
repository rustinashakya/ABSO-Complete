<?php

namespace Database\Seeders;

use App\Models\VacancyLevel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VacancyLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VacancyLevel::create([
            'name' => 'Executive Position'
        ]);
    }
}
