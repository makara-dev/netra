<?php

namespace App\CustomImageSliderFunctions;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

trait CustomImageSliderFunctions 
{
    /**
     * Store promotion image in storage.
     * @param String $className
     * @param  \Illuminate\Http\Request  $request['image-path]
     * @param String $screenOption
     * 
     * @return string $imagePath
     * @return null error storing image
     */
    public static function storeImage($className, $request, $screenOption, $imagePathName)
    {
        if ($request->hasFile($className)) {
            $current_timestamp = Carbon::now()->timestamp;
            $image = $request->file($className);
            $fileName = $screenOption. '-'. $imagePathName .'-'. $current_timestamp . '.' . $image->getClientOriginalExtension();
            $img = Image::make($image->getRealPath());
            $img->resize(
                990,
                480,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->stream();
            $imagePath = 'images/'.$imagePathName.'/' . $fileName;
            Storage::disk('public')->put($imagePath, $img);
            return $imagePath;
        }
        return null;
    }

    /**
     * Delete promotion slider image from storage
     * @param String $imagePath
     * 
     * @return bool
     */
    public static function deleteImage($imagePath)
    {
        $img = storage_path() . '/app/public/' . $imagePath;
        if (file_exists($img)) {
            $result = Storage::delete("public/{$imagePath}");
            return ($result) ? true : false;
        } else {
            return false;
        }
    }
}