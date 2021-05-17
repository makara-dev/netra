<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnythingPanorama extends Model
{
    //
    public $table = "anything_panoramas";

    // 
    public $primaryKey = "anything_panorama_id";

    //
    public $fillable = [
        "mobile_thumbnail",
        "desktop_thumbnail",
    ];

    // relationship
}
