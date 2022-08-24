<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date_time' => 'datetime',
    ];
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
