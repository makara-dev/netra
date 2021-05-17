<?php

namespace App\Http\Controllers\Api;

use App\Image;
use ErrorException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\CustomLibs\ManagesImages;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;


class ApiImageController extends Controller
{
    use ManagesImages;

    /**
     * delete image from DB and storage
     */
    public function destroy($id){
         //get category
        try {
            $image = Image::findOrFail($id);
            $path = $image->path;
            $result = $image->delete();

            if($image->is_thumbnail){
                $image->product()->update(['thumbnail' => null]);
            }
            
            if (!$result || !$this->deleteImageFile($path)) {
                throw new ErrorException('Unable to delete image file');
            } 

            $response = [
                'status' => 'success',
                'message' => 'Image Deleted Successfully',
            ];
        } catch (ModelNotFoundException | FileNotFoundException | ErrorException $e) {
            $response = [
                'status' => 'error',
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($response);
    }
}
