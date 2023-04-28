<?php

namespace App\Repositories;

use App\Models\Gouvernerat;

class FilterRepository
{
    public function getGouvernerat()
    {
        return Gouvernerat::all();
    }


    public function getVilles($gouverneratId)
    {
        $gouvernerat = Gouvernerat::findOrFail($gouverneratId);
         return  $gouvernerat->villes;
    }
}
