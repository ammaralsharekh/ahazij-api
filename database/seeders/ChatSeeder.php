<?php

namespace Database\Seeders;

use App\Models\Chat;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $faker = Factory::create();
        $room_id= $this->command->ask("Enter Room ID");
        $users=User::all();
        $loop= $this->command->ask("How many chat you want to be created?");
         for ($i=0; $i <$loop; $i++) {
             $chat=new Chat();
             $chat->room_id=$room_id;
             $chat->user_id=$users->random()->id;
             $chat->text=$faker->sentence();
             $chat->save();
         }
        $this->command->info($loop. ' char created');
    }
}
