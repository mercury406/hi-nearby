<?php

namespace App\Http\Controllers\Register;

use App\Models\MetaHiUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    private const DIRECTORY = "public/profile_pictures";

    public function updateImage(Request $request) : JsonResponse
    {
        $uid = $request->header("X-Google-UID");
        $fcm = $request->header("X-Google-FCM");
        
        if(is_null($uid) || $uid == "not_given")
            return response()
                ->json(["result" => "error"])
                ->setStatusCode(Response::HTTP_UNAUTHORIZED);

        if(!$request->has("image"))
            return response()
                    ->json(["result" => "error"])
                    ->setStatusCode(Response::HTTP_BAD_REQUEST);
        
        $file = $request->file('image');
        $file_name = $file->hashName();
        
        try{
            $file->storeAs(self::DIRECTORY, $file_name);

            $user = $request->user();
            
            $image_to_delete = $user->image_path;
            // Storage::delete($image_to_delete);
            
            $user->image_path = "storage/profile_pictures/". $file_name;
            $user->fcm_token = $fcm;
            $user->save();
            
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()
                ->json(["result" => "error"])
                ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()
            ->json(["result" => "ok"])
            ->setStatusCode(Response::HTTP_NO_CONTENT);
    }
    
}
