<?php

namespace App\Repositories;

use App\Models\AdherentNotification;
use App\Models\FirebaseToken;
use App\Models\Offre;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;



class AdminRepository
{
    public function adminCreateOffre($offreData)
    {
        $imagPath = $offreData['image']->store('public/offres');
        $imageUrl = Storage::url($imagPath);


        $SERVER_API_KEY = 'AAAA2ywZ6Wk:APA91bEFxPRndu6Q5ycjcZnVPvsSDzeaHw_fmE0aMCcJx0v8wrA9oxZtENAE4fXTeBDFETvtD9ZiDkrL9MdWCCyP5JHG0pXQ7UIckcNR_vK0ZUqHnMX2EML5J2EtGi9WPu3OdLWHPIZt';
        $token_1 = "cxdXVoEWSs-f5J8LK_Ckq5:APA91bE5rhCADtjXfk2JzGXIUt_KXXt1xHXTbdjlXI1r7Orj8eZeF77RS8uYdOlIj098TDrxAnP4H8Papi5BZBdjHYHmxUQVY1dIkdZ8idpU0oimybWReU803kPFvbHGtmRiNl7th0uJ";
        $data = [

            "registration_ids" => [
                $token_1
            ],

            "notification" => [

                "title" => 'Welcome',

                "body" => 'Description',

                "sound" => "default" // required for sound on ios

            ],
        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        AdherentNotification::create(
            [
                'title' => $offreData['title'],
                'description' => $offreData['description'],
                'date' => Carbon::now()
            ]
        );

        return Offre::create(
            [
                'user_id' => $offreData['user_id'],
                'title' => $offreData['title'],
                'description' => $offreData['description'],
                'prix' => $offreData['prix'],
                'promo' => $offreData['promo'],
                'image' => env('APP_URL') . $imageUrl,
                'date_debut' => $offreData['date_debut'],
                'date_fin' => $offreData['date_fin'],
                'type_id' => $offreData['typeId'],
                'accepted' => true
            ]
        );

    }


    public function adminAcceptOffre($partenaireId, $offerId)
    {
        $token = FirebaseToken::where('user_id', $partenaireId)->first();
        $fcmToken = $token->fcm_token;
        $offer = Offre::findOrfail($offerId);
        $offer->status = Offre::OFFRE_STATUS_ACCEPTED;
        $offer->update();
        $SERVER_API_KEY = 'AAAA2ywZ6Wk:APA91bEFxPRndu6Q5ycjcZnVPvsSDzeaHw_fmE0aMCcJx0v8wrA9oxZtENAE4fXTeBDFETvtD9ZiDkrL9MdWCCyP5JHG0pXQ7UIckcNR_vK0ZUqHnMX2EML5J2EtGi9WPu3OdLWHPIZt';
        $token_1 = $fcmToken;
        $data = [

            "registration_ids" => [
                $token_1
            ],

            "notification" => [

                "title" => 'Yooreed',

                "body" => 'Acceptation offre',

                "sound" => "default" // required for sound on ios

            ],
        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
        if ($response) {
            \App\Models\Notification::create(
                [
                    'user_id' => $partenaireId,
                    'title' => $offer->title,
                    'status' => Offre::OFFRE_STATUS_ACCEPTED,
                    'image' => $offer->image,
                    'date' => Carbon::now()
                ]
            );
        } else {
            \App\Models\Notification::create(
                [
                    'user_id' => $partenaireId,
                    'title' => $offer->title,
                    'logged' => false,
                    'status' => Offre::OFFRE_STATUS_ACCEPTED,
                    'image' => $offer->image,
                    'date' => Carbon::now()
                ]
            );

        }


    }


    public function adminRefuseOffre($partenaireId, $offerId)
    {
        $token = FirebaseToken::where('user_id', $partenaireId)->first();
        $fcmToken = $token->fcm_token;
        $offer = Offre::findOrfail($offerId);
        $offer->status = Offre::OFFRE_STATUS_REFUSED;
        $offer->update();
        $SERVER_API_KEY = 'AAAA2ywZ6Wk:APA91bEFxPRndu6Q5ycjcZnVPvsSDzeaHw_fmE0aMCcJx0v8wrA9oxZtENAE4fXTeBDFETvtD9ZiDkrL9MdWCCyP5JHG0pXQ7UIckcNR_vK0ZUqHnMX2EML5J2EtGi9WPu3OdLWHPIZt';
        $token_1 = $fcmToken;
        $data = [

            "registration_ids" => [
                $token_1
            ],

            "notification" => [

                "title" => 'Yooreed',

                "body" => 'offre refusé',

                "sound" => "default" // required for sound on ios

            ],
        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        if ($response) {
            \App\Models\Notification::create(
                [
                    'user_id' => $partenaireId,
                    'title' => $offer->title,
                    'status' => Offre::OFFRE_STATUS_REFUSED,
                    'image' => $offer->image,
                    'date' => Carbon::now()
                ]
            );
        } else {
            \App\Models\Notification::create(
                [
                    'user_id' => $partenaireId,
                    'title' => $offer->title,
                    'logged' => false,
                    'status' => Offre::OFFRE_STATUS_REFUSED,
                    'image' => $offer->image,
                    'date' => Carbon::now()
                ]
            );

        }


    }

}
