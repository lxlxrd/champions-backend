<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    //
    protected $fillable = [
        'title',
        'type',
        'content',
        'image_path'
    ];

    // elle n'a aucune relation

    public function seasons()
    {
        return $this->belongsToMany(
                    Season::class,
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
