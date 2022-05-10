<?php

namespace App\Models;

use App\Models\Greeting;
use App\Models\Location;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MetaHiUser extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        "uid",
        "fcm_token",
        "image_path",
        "username"
    ];

    public function location()
    {
        return $this->hasOne(Location::class, "user_id");
    }

    public function greetings()
    {
        return $this->hasMany(Greeting::class, "sent");
    }
}
