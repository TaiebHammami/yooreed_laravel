<?php

namespace App\Http\Controllers\Offre\Favorite;

use App\Http\Controllers\Controller;
use App\Repositories\FavoriteOfferRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FavoriteAddController extends Controller
{
    use GlobalTrait;

    private $favoriteRepository;


    public function __construct(FavoriteOfferRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * Handle the incoming request.
     */


    public function __invoke($userId,$offerId)
    {
        try {
            $data = $this->favoriteRepository->addFavorite($userId,$offerId);

            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Add new Adherent favorite offer Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
