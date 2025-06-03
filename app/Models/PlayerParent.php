<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class PlayerParent extends Authenticatable
{
    // Les champs assignables
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'address',
        'phone',
        'password',
        'role',
    ];

    // relation avec Player  un parent peut inscrir plusieur joueurs
    public function players()
    {
        return $this->hasMany(Player::class);
    }
}
