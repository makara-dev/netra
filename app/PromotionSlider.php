<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionSlider extends Model
{
    //
    protected $table = "promotion_sliders";

    //
    protected $primaryKey = "promotion_slider_id";

    //
    protected $fillable = [
        'mobile_thumbnail',
        'desktop_thumbnail',
    ];

    // relationship
}
