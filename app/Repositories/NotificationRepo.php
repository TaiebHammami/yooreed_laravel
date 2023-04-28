<?php

namespace App\Repositories;

use App\Models\AdherentNotification;
use App\Models\Notification;

class NotificationRepo
{
    public function getAdherentNoti()
    {
        return AdherentNotification::all();
    }


    public function getPartenaireNoti($userId)
    {
        $notifications = Notification::where('user_id', $userId);
        return $notifications->FilterDate($notifications)->get();
    }

    public function getPartinaireNotificationLogged($userId)
    {
        $notifications = Notification::where('user_id', $userId)
            ->where('logged', 1)->get();

        $noti = $notifications->map(function ($myNoti) {


         //   $myNoti->update(['logged' => 0]);
            return [
                'id' => $myNoti->id,
                'title' => $myNoti->title,
                'status' => $myNoti->status,
                'image' => $myNoti->image,
                'date' => $myNoti->date,

            ];
        });
        return $noti;
    }
}
