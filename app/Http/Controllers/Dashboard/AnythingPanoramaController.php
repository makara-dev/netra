<?php

namespace App\Http\Controllers\Dashboard;

use App\AnythingPanorama;
use App\CustomImageSliderFunctions\CustomImageSliderFunctions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use ErrorException;
use Exception;
use Illuminate\Support\Facades\DB;
use Throwable;

class AnythingPanoramaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anythingPanorama = AnythingPanorama::first();

        return view('dashboard/anythingPanorama/index')
            ->with('anythingPanorama', $anythingPanorama);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate screen option
        if($request['screen-option'] != 'desktop' && $request['screen-option'] != 'mobile') {
            return back()->with('error', 'Invalid Screen Option!');
        }

        // get screen options
        if($request['screen-option'] == 'desktop') {
            $screenOption = 'desktop';
            $dbScreenOption = 'desktop_thumbnail';
            $htmlPanoramaClass = 'web-panorama-image';
        } else {
            $screenOption = 'mobile';
            $dbScreenOption = 'mobile_thumbnail';
            $htmlPanoramaClass = 'mobile-panorama-image';
        }

        // start transaction
        DB::beginTransaction();

        //store panorama image
        $imgPath = CustomImageSliderFunctions::storeImage($htmlPanoramaClass, $request, $screenOption, 'anything_panorama'); 

        if(!empty($imgPath)) { // check empty image path
            // store image path to db
            $anythingPanorama = new AnythingPanorama([
                $dbScreenOption => $imgPath,
            ]);

            try{ // save data into db
                $anythingPanoramaResult = $anythingPanorama->save();
                if(!$anythingPanoramaResult) {
                    throw new \ErrorException('Unable to save anything panorama image!');
                }
            }catch(Exception | Throwable $e){
                DB::rollBack();
                return back()->with('error', 'Unable to save anything panorama image! ' . $e->getMessage());
            }
        }else {
            return back()->with('error', 'Unable to save anything panorama into storage');
        }

        //save transaction
        DB::commit();
        return redirect('dashboard/panorama')->with('success', 'Anything Panorama created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // validate screen option
        if($request['screen-option'] != 'desktop' && $request['screen-option'] != 'mobile') {
            return back()->with('error', 'Invalid Screen Option!');
        }

        // get screen options
        if($request['screen-option'] == 'desktop') {
            $screenOption = 'desktop';
            $dbScreenOption = 'desktop_thumbnail';
            $htmlPanoramaClass = 'web-panorama-image';
        } else {
            $screenOption = 'mobile';
            $dbScreenOption = 'mobile_thumbnail';
            $htmlPanoramaClass = 'mobile-panorama-image';
        }

        try{ // find anything panorama
            $anythingPanorama = AnythingPanorama::find($id);
        }catch(Throwable | Exception $e){
            return back()->with('error', 'Unable to find anything panorama!');
        }

        // start transaction
        DB::beginTransaction();
        
        // delete thumbnail if exist
        if($anythingPanorama->$dbScreenOption != null) {
            $prevImgPath = $anythingPanorama->$dbScreenOption;
            $deleteStorageImgResult = CustomImageSliderFunctions::deleteImage($prevImgPath);
            if(!$deleteStorageImgResult) {
                return back()->with('error', 'Unable to delete image from storage!');
            }
        }

        // store anything panorama image to storage
        $imgPath = CustomImageSliderFunctions::storeImage($htmlPanoramaClass, $request, $screenOption, 'anything_panorama'); 
        
        if(!empty($imgPath)){
            // update promotion slider
            $anythingPanorama->$dbScreenOption = $imgPath;

            // save update image path into db
            try{
                $anythingPanoramaResult = $anythingPanorama->update();
                if(!$anythingPanoramaResult) {
                    throw new \ErrorException('Unable to update anything panorama image!');
                }
            }catch(Exception | Throwable $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Unable to update anything panorama!'. $e->getMessage());
            }
        }else {
            return back()->with('error', 'Unable to save image into storage');
        }

        //save transaction
        DB::commit();
        return redirect('dashboard/panorama')->with('success', 'Anything panorama updated successfully');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // validate screen option
        if($request['screen-option'] != 'desktop' && $request['screen-option'] != 'mobile') {
            return back()->with('error', 'Invalid Screen Option!');
        }

        // get screen options
        $request['screen-option'] == 'desktop' ? $dbScreenOption = 'desktop_thumbnail' : $dbScreenOption = 'mobile_thumbnail';
     
        try{ // get anything panorama slider
            $anythingPanorama = AnythingPanorama::find($id);
        }catch (Throwable | Exception $e){
            return back()->with('error', 'Unable to find thumbnail of selected panorama image!');
        }

        // begin transaction 
        DB::beginTransaction();
        try {
            // get current path in db
            $oldImagePath = $anythingPanorama->$dbScreenOption;

            // set null path in db
            $anythingPanorama->$dbScreenOption = null;

            // save to db
            $anythingPanorama->save();

            // delete image from storage
            $deleteStorageImgResult = CustomImageSliderFunctions::deleteImage($oldImagePath);
            if(!$deleteStorageImgResult) {
                return back()->with('error', 'Unable to delete image from storage!');
            }
        }catch(ErrorException $e){
            DB::rollBack();
            return back()->with('error', 'There is a problem while trying to delete web promotion image path from db!');
        }

        // begin commit
        DB::commit();
        return redirect('dashboard/panorama')->with('success', 'Anything Panorama image successfuly deleted');        
    }
}
