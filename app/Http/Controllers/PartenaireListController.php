<?php

namespace App\Http\Controllers;

use App\Repositories\FilterRepository;
use App\Repositories\SecteurRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PartenaireListController extends Controller
{
    use GlobalTrait;

    private $partenaire;


    public function __construct(SecteurRepository $partenaire)
    {
        $this->partenaire = $partenaire;
    }

    /**
     * Handle the incoming request.
     */

    public function __invoke(Request $request)
    {
        $params =$this->getParams($request);
        try {
            $data = $this->partenaire->getAllPartenaires($params);
            return $this->globalResponse(trans('messages.GET_SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Get partenaire Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    private function getParams($request)
    {
        return $request->query();
    }
}
