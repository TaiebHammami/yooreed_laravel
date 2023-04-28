<?php

namespace App\Http\Controllers\Secteur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offre\OffreFindRequest;
use App\Repositories\OffreRepository;
use App\Repositories\SecteurRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SecteurGetController extends Controller
{
    /**
     * Handle the incoming request.
     */
    use GlobalTrait;

    private $secteurRepository;


    public function __construct(SecteurRepository $secteurRepository)
    {
        $this->secteurRepository = $secteurRepository;
    }

    /**
     * Handle the incoming request.
     */

    public function __invoke()
    {

        try {
            $data = $this->secteurRepository->getAllSecteur();
            return $this->globalResponse(trans('messages.GET_SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Get secteur Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
