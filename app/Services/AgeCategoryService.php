<?php

namespace App\Services;

use App\Models\AgeCategory;
use Carbon\Carbon;

class AgeCategoryService
{
    public function getCategoryByAge($age): ?AgeCategory
    {

        return AgeCategory::where('min_age',  '<=', $age)
            ->where('max_age', '>=', $age)->first();
    }


    // opérateur null safe si la category est null on ne la retourne pas 
    public function getCategoryByBirthDay($birthDate): ?AgeCategory
    {

        $age = Carbon::parse($birthDate)->age;
        return $this->getCategoryByAge($age);
    }
}
