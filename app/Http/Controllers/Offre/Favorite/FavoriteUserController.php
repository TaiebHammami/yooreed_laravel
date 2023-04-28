<?php

namespace App\Http\Controllers\Offre\Favorite;

use App\Http\Controllers\Controller;
use App\Repositories\FavoriteOfferRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class FavoriteUserController extends Controller
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


    public function __invoke($userId)
    {
        try {
            $data = $this->favoriteRepository->getFavoriteOfferByUser($userId);
            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Get Adherent favorite offers Exception : ' . $exception->getMessage());
            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
