<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team=New Team();
        $team->name='الهلال';
        $team->save();

        $team=New Team();
        $team->name='النصر';
        $team->save();

        $team=New Team();
        $team->name='الإتحاد';
        $team->save();

        $team=New Team();
        $team->name='الشباب';
        $team->save();
    }
}
