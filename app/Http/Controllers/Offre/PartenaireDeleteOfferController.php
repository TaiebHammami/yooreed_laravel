<?php

namespace App\Http\Controllers\Offre;

use App\Http\Controllers\Controller;
use App\Repositories\OffreRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PartenaireDeleteOfferController extends Controller
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
    public function __invoke($offreId)
    {
        try {
            $data = $this->offreRepository->deleteOffre($offreId);

            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('delete offer Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
