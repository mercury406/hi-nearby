<?php

namespace App\Http\Services;

use App\Models\Greeting;
use App\Models\Location;

class GreetingService{

    /**
     * 
     * #@return Carbon
     * @return int 
     */

    public function getLastTime(Location $location, int $sender_user_id)
    {
        $greeting = Greeting::where(["sent" => $sender_user_id, "received" => $location->user->id])->first();
        
        if(is_null($greeting))
            return null;
        
        return $greeting->updated_at->diffInMinutes();
    }
    
}