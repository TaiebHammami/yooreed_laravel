<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gouvernerat extends Model
{
    use HasFactory;

    protected $fillable = [
        'gouvernerat_id',
        'nom'
    ];

    protected function villes()
    {
        return $this->hasMany(Ville::class);
    }
}
