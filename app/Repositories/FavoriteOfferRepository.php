<?php

namespace App\Repositories;

use App\Models\User;

class FavoriteOfferRepository
{
    /**
     * @param $userId
     * @return mixed
     */
    public function getFavoriteOfferByUser($userId)
    {
        $user = User::findOrFail($userId);

        return $user->favoriteOffers;
    }

    /**
     * @param $userId
     * @param $favId
     * @return mixed
     */
    public function deleteFavoriteOffer($userId, $favId)
    {

        $user = User::findOrFail($userId);
        return $user->favoriteOffers()->detach($favId);

    }

    /**
     * @param $userId
     * @param $offerId
     * @return mixed
     */
    public function addFavorite($userId, $offerId)
    {

        $user = User::findOrFail($userId);

        return $user->favoriteOffers()->attach($offerId);

    }

}
