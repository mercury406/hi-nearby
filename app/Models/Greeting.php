<?php

namespace App\Models;

use App\Models\MetaHiUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Greeting extends Model
{
    use HasFactory; 

    protected $fillable = [
        "sent",
        "received"
    ];

    public function sender()
    {
        return $this->belongsTo(MetaHiUser::class);
    }
}
