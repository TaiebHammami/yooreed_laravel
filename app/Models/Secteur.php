<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'nom'
    ];

    protected function partenaires()
    {
        return $this->hasMany(User::class);
    }
}
