<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgeCategory extends Model
{
    //
    protected $fillable = [
        'name', 
        'min_age',
        'max_age'
    ]; 

    // relation avec Player une catégorie d'âge contient plusieurs joueurs  
    public function registrations(){
        return $this->hasMany(Registration::class);  
    }

    public function admin(){
        return $this->belongsTo(Admin::class);
    }
}
