<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'logged',
        'status',
        'title',
        'image',
        'date'

    ];

    public function scopeFilterDate(Builder $query)
    {
        $query->orderBy('date', direction: 'desc');
    }
}
