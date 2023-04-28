<?php

namespace App\Http\Controllers\Offre;

use App\Http\Controllers\Controller;
use App\Repositories\OffreRepository;
use App\Traits\GlobalTrait;
use Exception;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class OffreByPartenaireController extends Controller
{
    use GlobalTrait;

    private $offreRepository;


    public function __construct(OffreRepository $offreRepository)
    {
        $this->offreRepository = $offreRepository;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke($partenaireId)
    {
        try {
            $data = $this->offreRepository->getPartenaireOffre($partenaireId);

            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Get Partenaire offers Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
