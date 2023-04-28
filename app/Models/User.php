<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profession_id',
        'ville_id',
        'gouvernerat_id',
        'specialite_id',
        'carte_id',
        'secteur_id',
        'role_id',
        'nom',
        'prenom',
        'nom_responsable',
        'email',
        'password',
        'image',
        'cin',
        'numero',
        'adresse',
        'is_first_time'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function scopeBySecteurId(Builder $query, $secteurId)
    {
        $query->where('secteur_id', "=", $secteurId);
    }

    /**
     * @param Builder $query
     * @param $villeId
     * @return void
     */
    public function scopeByVilleId(Builder $query, $villeId)
    {
        $query->where('ville_id', "=", $villeId);
    }
    public function scopeByGouverneratId(Builder $query, $gouverneratId)
    {
        $query->where('gouvernerat_id', "=", $gouverneratId);
    }




    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }

    public function profession()
    {
        return $this->belongsTo(profession::class);
    }

    public function specialite()
    {
        return $this->belongsTo(specialite::class);
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class);
    }

    public function carte()
    {
        return $this->belongsTo(Carte::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function partenaire()
    {
        return $this->belongsTo(Secteur::class);
    }

    protected function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function favoriteOffers()
    {
        return $this->belongsToMany(Offre::class, 'user_favorite_offers', 'user_id', 'offre_id');
    }

    public function likesOffers()
    {
        return $this->belongsToMany(Offre::class, 'users_likes_offers', 'user_id', 'offre_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    const NAME_MIN_LENGTH = 5;
    const ADDRESS_MIN_LENGTH = 10;
}
