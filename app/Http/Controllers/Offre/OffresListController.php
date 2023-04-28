<?php

namespace App\Http\Controllers\Offre;

use App\Http\Controllers\Controller;
use App\Repositories\OffreRepository;
use App\Traits\GlobalTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OffresListController extends Controller
{
    use GlobalTrait;

    private $offreRepository;

    public function __construct(OffreRepository $offreRepository)
    {
        $this->offreRepository = $offreRepository;
    }

    public function __invoke($userId, Request $request, $search)
    {
        $params = $this->getParams($request);
        try {
            $data = $this->offreRepository->getAllOffres($userId, $params, $search);

            return $this->globalResponse(trans('messages.OFFRES_LIST'), Response::HTTP_OK, $data);

        } catch (Exception $exception) {
            Log::error('Ofres List Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function getParams($request)
    {
        return $request->query();
    }
}
