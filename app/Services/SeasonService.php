<?php 
namespace App\Services;

use App\Models\Season;

class SeasonService
{
    public function current(): ?Season
    {
        return Season::where('active', true)->latest('year')->first();
    }
}
