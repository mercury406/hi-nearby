<?php

namespace App\Http\Controllers\Register;

use App\Models\MetaHiUser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    private const DIRECTORY = "public/profile_pictures";

    public function registerByImage(Request $request) : JsonResponse
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

            $user = MetaHiUser::firstOrNew(
                ["uid" => $uid],
                ["image_path" => "storage/profile_pictures/". $file_name, "fcm_token" => $fcm]
            );
            $user->save();
            
            $apiToken = $user->createToken($uid)->plainTextToken;
        } catch (\Exception $e) {
            info($e->getMessage());
            return response()
                ->json(["result" => "error"])
                ->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()
            ->json(["result" => "ok", "token" => $apiToken])
            ->setStatusCode(Response::HTTP_CREATED);    
    }

    public function logout(Request $request) : JsonResponse
    {
        $user = $request->user();

        try{
            $result = Storage::delete($user->image_path);
            
        } catch(\Exception $e){
            info($e->getMessage());
        }

        $user->currentAccessToken()->delete();
        $user->delete();

        return response()
                ->json([])
                ->setStatusCode(Response::HTTP_NO_CONTENT);
    }
    
}
