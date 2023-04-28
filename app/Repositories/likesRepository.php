<?php

namespace App\Repositories;

use App\Models\Offre;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class likesRepository
{
    public function deleteLike($userId, $offreId)
    {
        $user = User::findOrFail($userId);
        $offer = Offre::findOrFail($offreId);
        $offer->update([
            'like' => $offer->like - 1
        ]);
        return $user->likesOffers()->detach($offreId);
    }

    /**
     * @param $userId
     * @param $offerId
     * @return mixed
     */
    public function addLike($userId, $offerId)
    {

        $user = User::findOrFail($userId);
        $offer = Offre::findOrFail($offerId);
        $offer->update([
            'like' => $offer->like + 1
        ]);

        return $user->likesOffers()->attach($offerId);
    }

    public function getLikes($userId)
    {
        $user = User::findOrFail($userId);
        $offers = DB::table('offres')
            ->select('*')
            ->orderBy('like', 'desc')
            ->get();

        $offres = $offers->map(function ($offer) use ($offers, $userId, $user) {

            $isFavorite = $user ? $user->favoriteOffers->contains($offer->id) : false;

            $liked = $user ? $user->likesOffers->contains($offer->id) : false;

            return [
                'id' => $offer->id,
                'title' => $offer->title,
                'user_id' => $userId,
                'description' => $offer->description,
                'date_debut' => $offer->date_debut,
                'date_fin' => $offer->date_fin,
                'like' => $offer->like,
                'prix' => $offer->prix,
                'promo' => $offer->promo,
                'image' => $offer->image,
                'type_id' => $offer->type_id,
                'is_favorite' => $isFavorite,
              //  'liked' => $liked
            ];
        });

        return $offres;
    }
}
