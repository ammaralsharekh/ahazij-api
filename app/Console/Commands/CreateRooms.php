<?php

namespace App\Console\Commands;

use App\Models\Game;
use App\Models\Room;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateRooms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'room:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create room';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $games=Game::query()->where([
            ['date_time','>',now()->addDays(1)],
            ['date_time','<',now()->addDays(20)],
            ['is_room_created',false]]
        )->get();

        foreach ($games as $game)
        {
            $room=new Room();
            $room->game_id=$game->id;
            $room->start_at=$game->date_time->subDays(2);
            $room->end_at=$game->date_time->addDays(2);

            $game->is_room_created=true;
            DB::transaction(function() use ($room, $game){
                $room->save();
                $game->save();
            });
        }
        $this->table( ['id', 'date_time'],$games->toArray());
    }
}
