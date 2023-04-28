<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class profession extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function specialite()
    {
        return $this->hasMany(specialite::class);
    }
}
