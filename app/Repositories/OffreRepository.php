<?php

namespace App\Repositories;

use App\Models\Offre;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OffreRepository
{
    /**
     * @param $offreData
     * @return mixed
     */
    public function createOffre($offreData)
    {
        $imagPath = $offreData['image']->store('public/offres');
        $imageUrl = Storage::url($imagPath);
        $user = User::findOrFail($offreData['user_id']);
        $secteurId = $user->secteur->id;
        return Offre::create(
            [
                'user_id' => $offreData['user_id'],
                'title' => $offreData['title'],
                'description' => $offreData['description'],
                'prix' => $offreData['prix'],
                'promo' => $offreData['promo'],
                'image' => env('APP_URL') . $imageUrl,
                'date_debut' => $offreData['date_debut'],
                'date_fin' => $offreData['date_fin'],
                'type_id' => $offreData['typeId'],
                'secteur_id' => $secteurId
            ]
        );
    }

    /**
     * @param $id
     * @return mixed
     */

    public function getOffersByTypeId($id, $userId)
    {
        $user = User::findOrFail($userId);
        $offers = DB::table('offres')
            ->where('status', '=', Offre::OFFRE_STATUS_LOADING)
            ->where('type_id', '=', $id)
            ->get();
        //   $highestPrice = DB::table('offres')
        //  ->where('status', '=', Offre::OFFRE_STATUS_LOADING)
        //   ->get();

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
                'liked' => $liked,

            ];
        });

        return $offres;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getPartenaireOffre($partenaireId)
    {
        $user = User::findOrFail($partenaireId);

        return $user->offres;
    }

    /**
     * @param $params
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getAllOffres($userId, $params, $search)
    {

        $user = User::findOrFail($userId);

        $offres = Offre::all()->toQuery();

        if ($params) {
            return $this->filterOffres($offres, $params, $user);
        }
        $searchOffres = Offre::where('title', "like", '%' . $search . '%');
        $allOffre = $searchOffres->get();

        $allOffres = $allOffre->map(function ($offer) use ($user) {

            $isFavorite = $user ? $user->favoriteOffers->contains($offer->id) : false;

            $liked = $user ? $user->likesOffers->contains($offer->id) : false;

            return [
                'id' => $offer->id,
                'title' => $offer->title,
                'user_id' => $offer->user_id,
                'description' => $offer->description,
                'date_debut' => $offer->date_debut,
                'date_fin' => $offer->date_fin,
                'like' => $offer->like,
                'prix' => $offer->prix,
                'promo' => $offer->promo,
                'image' => $offer->image,
                'type_id' => $offer->type_id,
                'is_favorite' => $isFavorite,
                'liked' => $liked,
            ];
        });
        return $allOffres;

    }

    /**
     * @param $offres
     * @param $params
     * @return mixed
     */
    protected function filterOffres($offres, $params, $user)
    {
        foreach ($params as $key => $value) {
            switch ($key) {
                case 'typeId':
                    $offres->filterByTypeId($value);
                    break;
                case 'priceRange':
                    $offres = $this->applyPriceRangeSort($offres, $value);
                    break;
                case 'secteurId':
                    $offres->BySecteurId($value);
                    break;
                default:
                    break;
            }
        }
        $allOffre = $offres->get();
        $allOffres = $allOffre->map(function ($offer) use ($user) {

            $isFavorite = $user ? $user->favoriteOffers->contains($offer->id) : false;

            $liked = $user ? $user->likesOffers->contains($offer->id) : false;

            return [
                'id' => $offer->id,
                'title' => $offer->title,
                'user_id' => $offer->user_id,
                'description' => $offer->description,
                'date_debut' => $offer->date_debut,
                'date_fin' => $offer->date_fin,
                'like' => $offer->like,
                'prix' => $offer->prix,
                'promo' => $offer->promo,
                'image' => $offer->image,
                'type_id' => $offer->type_id,
                'is_favorite' => $isFavorite,
                'liked' => $liked,
            ];
        });
        return $allOffres;
    }


    /**
     * @param $offres
     * @param $value
     * @return mixed
     */
    protected function applyPriceRangeSort($offres, $value)
    {
        list($minPrice, $maxPrice) = explode('-', $value);
        return $offres->priceRange($minPrice, $maxPrice);
    }


    public function deleteOffre($offreId)
    {
        $offre = Offre::findOrFail($offreId);
        $offre->delete();
        return true;
    }
}
