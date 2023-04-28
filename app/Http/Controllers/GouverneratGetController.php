<?php

namespace App\Http\Controllers;

use App\Repositories\FilterRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class GouverneratGetController extends Controller
{
    use GlobalTrait;

    private $filterRepository;


    public function __construct(FilterRepository $filterRepository)
    {
        $this->filterRepository = $filterRepository;
    }

    /**
     * Handle the incoming request.
     */

    public function __invoke()
    {

        try {
            $data = $this->filterRepository->getGouvernerat();
            return $this->globalResponse(trans('messages.GET_SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('Get gouvernerat Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
