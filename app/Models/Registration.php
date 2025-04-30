<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'player_id',
        'season_id',
        'player_parent_id',
        'age_category_id',
        'status',
    ];
    

    // relation  avec season, un registration appartient à une saison 
    public function season()
    {
        return $this->belongsTo(Season::class);
    }


    //Relation avec player 
    // un registration est faite pour un joueur 

    public function player(){
        return $this->belongsTo(Player::class);
    }

    public function parent(){
        return $this->belongsTo(PlayerParent::class);
    }

    public function age_category(){
        return $this->belongsTo(AgeCategory::class);
    }
 
    // un registration appartient à une saison

}
