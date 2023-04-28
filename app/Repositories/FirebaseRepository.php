<?php

namespace App\Repositories;

use App\Models\FirebaseToken;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class FirebaseRepository
{
    public function createUserToken($userData)
    {
        $existe = FirebaseToken::where('user_id', $userData['userId'])->exists();
        $user = User::findOrFail($userData['userId']);


        if ($existe) {
            $user = FirebaseToken::where('user_id', $userData['userId'])->first();
            $user->fcm_token = $userData['fcmToken'];
            $user->update();

        } else {
            return FirebaseToken::create([
                'user_id' => $userData['userId'],
                'fcm_token' => $userData['fcmToken'],
                'role_id' => $user->role->id
            ]);
        }

    }
}
