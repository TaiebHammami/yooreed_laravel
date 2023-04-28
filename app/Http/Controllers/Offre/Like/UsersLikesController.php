<?php

namespace App\Http\Controllers\Offre\Like;

use App\Http\Controllers\Controller;
use App\Repositories\likesRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class UsersLikesController extends Controller
{
    use GlobalTrait;

    private $likesRepository;


    public function __construct(likesRepository $likesRepository)
    {
        $this->likesRepository = $likesRepository;
    }

    /**
     * Handle the incoming request.
     */


    public function __invoke($userId)
    {
        try {
            $data = $this->likesRepository->getLikes($userId);

            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('also likes on offer Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
