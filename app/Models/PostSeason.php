<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PostSeason extends Pivot
{
    //
    protected $fillable = [
        'season_id',
        'post_id',
        'admin_id',
        'date',
    ];
    public function season()
    {
        return $this->belongsTo(Season::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
