<?php

namespace App\Http\Controllers\Greeting;

use App\Models\Greeting;
use App\Models\MetaHiUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\NotificationService;

class GreetingController extends Controller
{

    public function store(Request $request)
    {

        $sender = MetaHiUser::findOrFail(auth()->user()->id);

        $notification_service = new NotificationService($sender);


        if(!isset($request->receiver))
            return response()
                    ->json(["result" => "error"])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
                    // ->setStatusCode(Response::HTTP_CREATED);

        $receiver = MetaHiUser::findOrFail($request->receiver);

        $greeting = Greeting::firstOrNew([
            "sent" => $sender->id,
            "received" => $receiver->id
        ]);

        $greeting->save();
        
        $notification_service->send($receiver);

        return response()
                ->json(["result" => "ok"])
                ->setStatusCode(Response::HTTP_CREATED);
    }
}
