<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    use HasFactory;

    protected $fillable = [
        'gouvernerat_id',
        'nom'
    ];

    protected function gouvernerat()
    {
        return $this->belongsTo(Gouvernerat::class);
    }
}
