<?php

namespace Database\Seeders;

use App\Models\League;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeagueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $league=new League();
        $league->name="الدوري السعودي";
        $league->start_at=Carbon::createFromFormat('d/m/Y',  '01/03/2022');
        $league->end_at=Carbon::createFromFormat('d/m/Y',  '30/10/2022');
        $league->save();
    }
}
