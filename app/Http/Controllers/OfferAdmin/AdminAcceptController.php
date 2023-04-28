<?php

namespace App\Http\Controllers\OfferAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offre\OffreCreateRequest;
use App\Repositories\AdminRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AdminAcceptController extends Controller
{
    use GlobalTrait;

    private $adminRepository;


    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    /**
     * Handle the incoming request.
     */

    public function __invoke($partenaireId, $offerId)
    {
        try {
             $this->adminRepository->adminAcceptOffre($partenaireId, $offerId);

            return $this->globalResponse(trans('messages.ACCEPT_OFFRE'), Response::HTTP_CREATED, '');
        } catch (Exception $exception) {
            Log::error('ACCEPT offre Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
