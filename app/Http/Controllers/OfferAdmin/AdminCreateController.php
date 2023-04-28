<?php

namespace App\Http\Controllers\OfferAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Offre\OffreCreateRequest;
use App\Repositories\AdminRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AdminCreateController extends Controller
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

    public function __invoke(OffreCreateRequest $request)
    {
        $offreData = $this->getAttributes($request);
        try {
            $data = $this->adminRepository->adminCreateOffre($offreData);

            return $this->globalResponse(trans('messages.CREATE_OFFRE'), Response::HTTP_CREATED, $data);
        } catch (Exception $exception) {
            Log::error('Create offre Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @param $request
     * @return array
     */
    private function getAttributes($request)
    {
        return [
            'user_id' => $request->input('user_id'),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'prix' => $request->input('prix'),
            'promo' => $request->input('promo'),
            'date_debut' => $request->input('date_debut'),
            'date_fin' => $request->input('date_fin'),
            'image' => $request->file('image'),
            'typeId' => $request->input('type_id'),
        ];
    }
}
