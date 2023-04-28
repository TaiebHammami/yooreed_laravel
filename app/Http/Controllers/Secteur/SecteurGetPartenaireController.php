<?php

namespace App\Http\Controllers\Secteur;

use App\Http\Controllers\Controller;
use App\Http\Requests\Secteur\SecteurGetPartenaireRequest;
use App\Repositories\SecteurRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class SecteurGetPartenaireController extends Controller
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


    public function __invoke($id)
    {
        try {
            $data = $this->secteurRepository->getPartenaireBySecteur($id);
            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Get partenaire By secteur Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
