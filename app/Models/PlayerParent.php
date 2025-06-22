<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class PlayerParent extends Authenticatable implements MustVerifyEmail {
    use HasApiTokens, Notifiable;
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

    public function players() {
        return $this->hasMany( Player::class );
    }

    public function fullName(): Attribute
    {
        return Attribute::make( get: fn() => $this->getAttribute( 'last_name' ) . ' ' . $this->getAttribute( 'first_name' ) );
    }
}
