<?php

namespace App\Http\Controllers\Dashboard;

use App\PromotionSlider;
use App\Http\Controllers\Controller;
use App\CustomImageSliderFunctions\CustomImageSliderFunctions;

use Throwable;
use Exception;
use ErrorException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionSliderController extends Controller
{
    use CustomImageSliderFunctions;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotionSliders = PromotionSlider::all();
        $webPromotionSliders = $promotionSliders->pluck('desktop_thumbnial');
        $mobilePromotionSliders = $promotionSliders->pluck('mobile_thumbnial');

        return view('dashboard/promotionSlider/index')
            ->with('webPromotionSliders', $webPromotionSliders)
            ->with('mobilePromotionSliders', $mobilePromotionSliders)
            ->with('promotionSliders', $promotionSliders);
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
            $htmlSliderClass = 'web-slider-image';
        } else {
            $screenOption = 'mobile';
            $dbScreenOption = 'mobile_thumbnail';
            $htmlSliderClass = 'mobile-slider-image';
        }

        // start transaction
        DB::beginTransaction();

        //store promotion image
        $imgPath = CustomImageSliderFunctions::storeImage($htmlSliderClass, $request, $screenOption, 'promotion'); 

        if(!empty($imgPath)) { // check empty image path
            // store image path to db
            $promotionSlider = new PromotionSlider([
                $dbScreenOption => $imgPath,
            ]);

            try{ // save data into db
                $promotionSliderResult = $promotionSlider->save();
                if(!$promotionSliderResult) {
                    throw new \ErrorException('Unable to save promotion image slide!');
                }
            }catch(Exception | Throwable $e){
                DB::rollBack();
                return back()->with('error', 'Unable to save web promotion image slide! ' . $e->getMessage());
            }
        }else {
            return back()->with('error', 'Unable to save image into storage');
        }

        //save transaction
        DB::commit();
        return redirect('dashboard/promotionslider')->with('success', 'Promotion slider created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            $htmlSliderClass = 'update-web-slider-image';
        } else {
            $screenOption = 'mobile';
            $dbScreenOption = 'mobile_thumbnail';
            $htmlSliderClass = 'update-mobile-slider-image';
        }

        try{ // find promotion slider
            $promotionSlider = PromotionSlider::find($id);
        }catch(Throwable | Exception $e){
            return back()->with('error', 'Unable to find promotion slider!');
        }

        // start transaction
        DB::beginTransaction();
        
        // delete thumbnail if exist
        if($promotionSlider->$dbScreenOption != null) {
            $prevImgPath = $promotionSlider->$dbScreenOption;
            $deleteStorageImgResult = CustomImageSliderFunctions::deleteImage($prevImgPath);
            if(!$deleteStorageImgResult) {
                return back()->with('error', 'Unable to delete image from storage!');
            }
        }
        
        // store promotion image to storage
        $imgPath = CustomImageSliderFunctions::storeImage($htmlSliderClass, $request, $screenOption, 'promotion'); 
        if(!empty($imgPath)){
            // update promotion slider
            $promotionSlider->$dbScreenOption = $imgPath;

            // save update image path into db
            try{
                $promotionSliderResult = $promotionSlider->update();
                if(!$promotionSliderResult) {
                    throw new \ErrorException('Unable to update promotion image slide!');
                }
            }catch(Exception | Throwable $e){
                DB::rollBack();
                return redirect()->back()->with('error', 'Unable to update promotion image slider!'. $e->getMessage());
            }
        }else {
            return back()->with('error', 'Unable to save image into storage');
        }

        //save transaction
        DB::commit();
        return redirect('dashboard/promotionslider')->with('success', 'Promotion slider updated successfully');        
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
        
        try{ // get promotion slider
            $promotionSlider = PromotionSlider::find($id);
        }catch (Throwable | Exception $e){
            return back()->with('error', 'Unable to find thumbnail of selected promotion image!');
        }

        // begin transaction 
        DB::beginTransaction();
        try {
            // get current path in db
            $oldImagePath = $promotionSlider->$dbScreenOption;

            // set null path in db
            $promotionSlider->$dbScreenOption = null;

            // save to db
            $promotionSlider->save();

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
        return redirect('dashboard/promotionslider')->with('success', 'Web promotion slider image successfuly deleted');
    }
}