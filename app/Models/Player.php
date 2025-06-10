<?php

namespace App\Models;

use App\Services\AgeCategoryService;
use App\Services\SeasonService;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Player extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'gender',
        'jersey_size',
        'preferred_location',
        'player_parents_id',
        'age_categories_id',
    ];


    protected $casts = [
        'birth_date' => 'date',
    ];
    /**
     * Relation vers le parent du joueur.
     */
    public function parent()
    {
        return $this->belongsTo(PlayerParent::class, 'player_parents_id');
    }

    /**
     * Relation vers la catégorie d'âge calculée.
     */
    public function ageCategory()
    {
        return $this->belongsTo(AgeCategory::class, 'age_categories_id');
    }

    /**
     * Relation vers les inscriptions du joueur.
     */
    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    /**
     * Initialisation automatique de la catégorie d'âge lors de la création.
     */
    protected static function booted()
    {
        static::creating(function (Player $player) {
            // Appel direct au service
            $service = app(AgeCategoryService::class);
            $category = $service->getCategoryByBirthDay($player->birth_date);
            if ($category) {
                $player->age_categories_id = $category->id;
            }
        });

        static::created(function (Player $player) {
            $season = app(SeasonService::class)->current();
            if (!$season) {
                // pas de saison active : on sort
                return;
            }

            Registration::create([
                'player_id'         => $player->id,
                'player_parent_id'  => $player->player_parents_id,
                'season_id'         => $season->id,
                'age_category_id'   => $player->age_categories_id,
                'status'             => 'pending',      // correspond à ta colonne `status`
            ]);
        });
    }

    public function fullName(): Attribute
	{
		return Attribute::make(get: fn() => $this->getAttribute('last_name') . ' ' . $this->getAttribute('first_name'));
	}



}
