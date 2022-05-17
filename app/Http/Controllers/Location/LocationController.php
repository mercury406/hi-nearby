<?php

namespace App\Http\Controllers\Location;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Services\DistanceService;
use App\Http\Services\GreetingService;
use Illuminate\Support\Facades\Storage;

class LocationController extends Controller
{
    const MAX_DISTANCE = 25;

    public function __construct(GreetingService $greeting_service)
    {
        $this->greeting_service = $greeting_service;
    }

    public function store(Request $request)
    {
        
        if(!isset($request->latitude) || !isset($request->longitude))           
            return response()
                    ->json(["result" => "error"])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $loc = Location::where("user_id", $request->user()->id)->first();
        if($loc){
            $loc->latitude = $latitude;
            $loc->longitude = $longitude;
            $loc->save();
        } else {
            Location::create([
                "latitude" => $latitude,
                "longitude" => $longitude,
                "user_id" => $request->user()->id
            ]);
        }

        $locations = Location::where("user_id", "<>",  $request->user()->id)->with(["user.greetings"])->get();

        $locations = $locations->filter(function($location) {
            return $location->updated_at->diffInMinutes() < 15;
        });

        $distance_service = new DistanceService($longitude, $latitude);

        $users = [];

        foreach($locations as $location){
            $users[] = [
                "user" => [
                    "id" => $location->user->id,
                    "username" => $location->user->username,
                    "image" => "http://192.168.0.63/".$location->user->image_path
                ],
                "distance" => $distance_service->calculate($location->latitude, $location->longitude),
                "mins_since_last_greeting" => $this->greeting_service->getLastTime($location, $request->user()->id)
            ];
        }


        return response()
            ->json(["result" => "ok", "users" => $users])
            ->setStatusCode(Response::HTTP_CREATED);
    }
}