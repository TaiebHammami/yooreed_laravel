<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type_id',
        'title',
        'description',
        'date_debut',
        'image',
        'prix',
        'promo',
        'date_fin',
        'like',
        'status'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'user_favorite_offers', 'offre_id', 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * @param Builder $query
     * @param $id
     * @return void
     */
    public function scopeFilterByTypeId(Builder $query, $id)
    {
        $query->where('type_id', "=", $id);
    }

    /**
     * @param Builder $query
     * @param $minPrice
     * @param $maxPrice
     * @return void
     */
    public function scopePriceRange(Builder $query, $minPrice, $maxPrice)
    {
        $query->whereBetween('prix', [$minPrice, $maxPrice]);
    }

    /**
     * @param Builder $query
     * @param $id
     * @return void
     */
    public function scopeBySecteurId(Builder $query, $secteurId)
    {
        $query->where('secteur_id', "=", $secteurId);
    }



    const OFFRE_NAME_MIN_LENGTH = 5;
    const OFFRE_DESC_MIN_LENGTH = 5;

    const OFFRE_STATUS_LOADING = 'loading';
    const OFFRE_STATUS_ACCEPTED = 'accepted';
    const OFFRE_STATUS_REFUSED = 'refused';

}
