<?php

namespace Database\Seeders;

use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game=new Game();
        $game->league_id=1;
        $game->team_id_1=1;
        $game->team_id_2=2;
        $game->date_time=Carbon::createFromFormat('d/m/Y',  '05/08/2022');;
        $game->save();

        $game=new Game();
        $game->league_id=1;
        $game->team_id_1=3;
        $game->team_id_2=4;
        $game->date_time=Carbon::createFromFormat('d/m/Y',  '15/08/2022');;
        $game->save();

        $game=new Game();
        $game->league_id=1;
        $game->team_id_1=2;
        $game->team_id_2=3;
        $game->date_time=Carbon::createFromFormat('d/m/Y',  '25/08/2022');;
        $game->save();

        $game=new Game();
        $game->league_id=1;
        $game->team_id_1=1;
        $game->team_id_2=4;
        $game->date_time=Carbon::createFromFormat('d/m/Y',  '05/09/2022');;
        $game->save();
    }
}

