<?php

namespace App\Http\Services;

use App\Models\MetaHiUser;

class NotificationService
{

    const FCM_URL = "https://fcm.googleapis.com/fcm/send";
    private $fcm_key;
    private $sender;

    public function __construct(MetaHiUser $sender)
    {
        $this->sender = $sender;
        $this->fcm_key = env("GOOGLE_FCM_SERVER_TOKEN");
    }


    public function send(MetaHiUser $receiver)
    {
        $this->send_remote_request($receiver);
    }


    private function send_remote_request(MetaHiUser $receiver)
    {
        $path_to_firebase_cm = 'https://fcm.googleapis.com/fcm/send';
        $fields = [
            'to' => $receiver->fcm_token,
            'data' => [
                "username" => $this->sender->username,
                "image" => $this->sender->image
            ],
        ];

        $headers = [
            "Authorization:key=$this->fcm_key",
            "Content-Type:application/json"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $path_to_firebase_cm);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        curl_close($ch);
    }
}
