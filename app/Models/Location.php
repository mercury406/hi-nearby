<?php

namespace App\Models;

use App\Models\MetaHiUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        "longitude",
        "latitude",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(MetaHiUser::class);
    }
}
