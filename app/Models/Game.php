<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    public function league()
    {
        return $this->belongsTo(League::class);
    }

    public function team_1()
    {
        return $this->belongsTo(Team::class,'team_id_1');
    }
    public function team_2()
    {
        return $this->belongsTo(Team::class,'team_id_2');
    }

}
