<?php

namespace App\CustomLibs;

use App\Image;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as ImageManger;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

trait ManagesImages
{
    /**
     * write(save) a single Image into desired Path
     */
    public function storeImage($ImageFile, string $desiredPath, string $imagePath = null, int $width = null, int $height = null)
    {
        if(!$imagePath){
            $imagePath = $ImageFile->getRealPath();
        }
        if(!$width){
            $width = config('image.width');
        }
        if(!$height){
            $height = config('image.height');
        }

        $img = ImageManger::make($imagePath);
        $img->resize(
            $width,
            $height,
            function ($constraint) {
                $constraint->aspectRatio();
            }
        );

        $img->stream();
        return Storage::disk('public')->put($desiredPath, $img);
    }

    /**
     * write(save) Product Images into storage
     * @return App\Image[]
     */
    public function storeProductImgs(array $images, $product)
    {
        $imageModels = [];
        foreach ($images as $image) {
            if($image->isValid()){
                //new img model
                $temp = new Image(['path' => '']);
                $imageModel = $product->images()->save($temp);
                
                //create img file
                $filename = $product->product_name . '_' . $product->product_id . '_' . $imageModel->image_id . time() . '.' . $image->getClientOriginalExtension();
                $imagePath = 'images/product/' . $filename;
                
                $this->storeImage($image, $imagePath);
                
                //update img model and push to array
                $imageModel->path = $imagePath;
                array_push($imageModels, $imageModel);
            }
        }
        return $imageModels;
    }

    /**
     * write(save) Product Thumbnail into storage
     * @param Illuminate\Http\UploadedFile $image
     * @return string $thumbnailPath
     */
    public function storeThumbnail($image, $filename)
    {
        //resize img for thumbnail
        $newPath = 'images/product/thumbnail/' . $filename;
        $width = config('image.thumbnail.width');
        $height = config('image.thumbnail.height');

        if($this->storeImage($image, $newPath, null, $width, $height)){
            return $newPath;
        }
        throw new ErrorException('Unable to save Thumbnail.');
    }

    /**
     * Delete Image file from storage
     */
    public function deleteImageFile(string $imagePath){
        $fullPath = storage_path() . '/app/public/' . $imagePath;
        if(is_file($fullPath)){
            return Storage::delete('public/' . $imagePath);
        }
        throw new FileNotFoundException(basename($imagePath));
    }

    /**
     * write(save) Product Thumbnail into storage
     * @param Illuminate\Http\UploadedFile $image
     * @return string $thumbnailPath
     */
    public static function storeGiftsetThumbnail($request, $imageFileName, $giftsetName)
    {
        if ($request->hasFile($imageFileName)) {
            $current_timestamp = Carbon::now()->timestamp;
            $image = $request->file($imageFileName);
            $fileName = $giftsetName . '-' . $current_timestamp . '.' . $image->getClientOriginalExtension();
            $img = ImageManger::make($image->getRealPath());
            $img->resize(
                990,
                480,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->stream();
            $imagePath = 'images/giftset/' . $fileName;
            Storage::disk('public')->put($imagePath, $img);
            return $imagePath;
        } else {
            return null;
        }
    }

    /**
     * write(save) Product Thumbnail into storage
     * @param Illuminate\Http\UploadedFile $image
     * @return string $thumbnailPath
     */
    public static function deleteGiftsetThumbnail(String $imagePath) {
        $img = storage_path() . '/app/public/' . $imagePath;
        if (file_exists($img)) {
            $result = Storage::delete("public/{$imagePath}");
            return ($result) ? true : false;
        } else {
            return false;
        }
    }
}
