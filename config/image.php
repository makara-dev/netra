<?php 
return [
    /*
    |--------------------------------------------------------------------------
    | Default Image Dimension
    |--------------------------------------------------------------------------
    |
    | This default Image Dimension (pixels) will be used when you save a product Image
    |
    */

    'width' => env('DEFAULT_IMG_WIDTH', 250),
    'height' => env('DEFAULT_IMG_HEIGHT', 400),

     /*
    |--------------------------------------------------------------------------
    | Default Thumbnail Dimension
    |--------------------------------------------------------------------------
    |
    | This default Thumbnail Dimension (pixels) will be used when you save a product Thumbnail
    |
    */

    'thumbnail' => [
        'width' => env('DEFAULT_THUMBNAIL_WIDTH', 250),
        'height' => env('DEFAULT_THUMBNAIL_HEIGHT', 400),
    ]
];