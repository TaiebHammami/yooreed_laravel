<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Repositories\Notification;
use App\Repositories\OffreRepository;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AdherentNotificationController extends Controller
{
    use GlobalTrait;

    private $notification;


    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke()
    {
        try {
            $data = $this->notification->getAdherentNoti();

            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('adherent Notification find by type  Exception : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
