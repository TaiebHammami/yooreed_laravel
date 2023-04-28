<?php

namespace App\Http\Controllers\Offre;

use App\Http\Controllers\Controller;
use App\Repositories\OffreRepository;
use App\Traits\GlobalTrait;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OffreFindController extends Controller
{
    use GlobalTrait;

    private $offreRepository;


    public function __construct(OffreRepository $offreRepository)
    {
        $this->offreRepository = $offreRepository;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke($id, $userId)
    {
        try {
            $data = $this->offreRepository->getOffersByTypeId($id, $userId);

            return $this->globalResponse(trans('messages.CREATE_OFFRE'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('offre find by type  Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
