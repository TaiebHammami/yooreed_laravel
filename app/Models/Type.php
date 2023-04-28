<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    use HasFactory;

    protected $fillable = [
        'nom'
    ];
    protected function offres()
    {
        return $this->hasMany(Offre::class);
    }
}
