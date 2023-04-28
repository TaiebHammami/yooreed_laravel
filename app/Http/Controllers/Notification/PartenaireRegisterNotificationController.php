<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Repositories\NotificationRepo;
use App\Traits\GlobalTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class PartenaireRegisterNotificationController extends Controller
{
    use GlobalTrait;

    private $notification;


    public function __construct(NotificationRepo $notification)
    {
        $this->notification = $notification;
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke($userId)
    {
        try {
            $data = $this->notification->getPartinaireNotificationLogged($userId);

            return $this->globalResponse(trans('messages.SUCCESS'), Response::HTTP_OK, $data);
        } catch (Exception $exception) {
            Log::error('partenaire Notification  : ' . $exception->getMessage());

            return $this->globalResponse(trans('messages.SERVER_ERROR'), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
