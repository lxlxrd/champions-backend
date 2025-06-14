<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    //
    protected $fillable = [
        'name',
        'email',
        'password',
        'remember_token',
    ];


    public function getAuthPassword()
    {
        return $this->password;
    }
    public function getRememberToken()
    {
        return $this->remember_token;
    }
    public function setRememberToken($value)
    {
        $this->remember_token = $value;
        $this->save();
    }
    public function getRememberTokenName()
    {
        return 'remember_token';
    }
    public function getAuthIdentifierName()
    {
        return 'id';
    }
    public function getAuthIdentifier()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }
    public function getAuthIdentifierValue()
    {
        return $this->getAttribute($this->getAuthIdentifierName());
    }
    public function getAuthIdentifierColumn()
    {
        return $this->getAuthIdentifierName();
    }
    public function getAuthIdentifierKey()
    {
        return $this->getKey();
    }


    public function ageCategory()
    {
        return $this->hasMany(AgeCategory::class);
    }
    public function postSeasons()
    {
        return $this->hasMany(PostSeason::class);
    }

    public function approve(Registration $registration)
    {
        $registration->status = 'approved';
        // $registration->validated_by = $this->id;
        $registration->save();
    }

    /**
     * Annule la validation d'une inscription.
     */
    public function reject(Registration $registration)
    {
        $registration->status = 'rejected';
        // $registration->validated_by = null;
        $registration->save();
    }

    // public function fullName(): Attribute
	// {
	// 	return Attribute::make(get: fn() => $this->getAttribute('last_name') . ' ' . $this->getAttribute('first_name'));
	// }
}
