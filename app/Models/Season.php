<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    protected $fillable = [
        'name',
        'year',
        'active',
        'start',
        'end',
    ];
    //


    // Relation avec registration 
    // Une saison contient plusieurs registration  

    public function registrations()
    {
        return $this->hasMany(Registration::class); 
    }

    // Relation avec post via la tabelle pivot post_season
    // Une saison contient plusieurs post, les colonne de la table pivot sont chargées avec la relation
    // post_season
    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            'post_seasons'     // nom correct de la table pivot
        )
            ->using(PostSeason::class)
            ->withPivot('admin_id', 'date');
    }


    public function postSeasons()
    {
        return $this->hasMany(PostSeason::class);
    }
}
