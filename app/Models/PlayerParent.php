<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerParent extends Model
{
    // Les champs assignables 
    protected $fillable = [
        'first_name', 
        'last_name', 
        'email', 
        'address',
        'phone'
    ]; 

    // relation avec Player  un parent peut inscrir plusieur joueurs 
    public function players(){
        return $this->hasMany(Player::class);  
    }
}
