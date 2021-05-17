<?php

namespace App\Http\Controllers\Dashboard;

use App\Giftset;
use App\ProductVariant;
use Illuminate\Http\Request;

use App\CustomLibs\ManagesImages as CustomImageClass;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiGiftsetProductVariantController as GiftsetApi;
use ErrorException;
use Exception;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GiftsetController extends Controller
{
    use CustomImageClass;

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index() {
        try {
            $giftsets = Giftset::all();
        } catch( ModelNotFoundException | Throwable | Exception $ex) {
            return back()->with('error', 'There is a problem while trying to get giftset!');
        }
        return view('dashboard.giftset.index')->with('giftsets', $giftsets);
    }

    /**
     * Show the form for creating a new productvaraints.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        //get product variants
        try {
            $productVariants = ProductVariant::paginate(10);
        }catch(ModelNotFoundException | Throwable | Exception $e) {
            return back()->with('error', 'There is a problem while trying to get product variants!');
        }
        return view('dashboard.giftset.giftset_pr_add')
            ->with('productVariants', $productVariants)
            ->with('currentPage', $request['page'].'-paginationPage');
    }

    /**
     * Show the form for creating a new giftset detail informations.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createGiftset(Request $request) {
        $totalPaginationPage = json_decode($request['productVariants']);
        // validate on null submitted
        if($totalPaginationPage == null) { 
            return back()->with('error', 'trying to submit on null product variant selected!');
        }
        // get all product variant from giftsetapi
        $productVariantArr = GiftsetApi::getProductVariantArray($totalPaginationPage);
        return view('dashboard.giftset.add')->with('productVariantArr', $productVariantArr);
    }

    /**
     * Store a giftset created resource into database.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate giftset data 
        $validatedData = $request->validate([
            'giftset-name'          => 'required|max:255',
            'giftset-price'         => 'required|numeric',
            'giftset-description'   => 'max:500',
            'giftset-expireDate'    => 'required|date_format:"Y-m-d"',
        ]);
        $giftsetName        = $request['giftset-name'];
        $giftsetPrice       = $request['giftset-price'];
        $giftsetExpireDate  = $request['giftset-expireDate'];
        $giftsetDescription = $request['giftset-description'];
        $productVariantArr  = json_decode($request['productVaraintArr']);

        DB::beginTransaction();
        try{
            // create giftset
            $giftset = new Giftset([
                'giftset_name'          => $giftsetName,
                'giftset_price'         => $giftsetPrice,
                'expires_at'            => $giftsetExpireDate,
                'giftset_description'   => $giftsetDescription,
            ]);

            // save giftset into db
            $giftsetResult = $giftset->save();
            if(!$giftsetResult) {
                return redirect('dashboard/giftsets')
                    ->with('error', 'Something went wrong while trying to save the giftset!');
            }

            try {
                // create product variants of giftset
                $giftsetItem = array();
                foreach($productVariantArr as $productVariantId) {
                    array_push($giftsetItem, [
                        'giftset_id'         => $giftset->giftset_id,
                        'product_variant_id' => $productVariantId,                        
                    ]);
                }
                // save into giftset productvariant bridges table
                $bridgesTableResult = DB::table('productvar_giftset_bridges')->insert($giftsetItem);
                if(!$bridgesTableResult) {
                    return redirect('dashboard/giftsets')
                        ->with('error', 'Something went wrong while trying to save the product variant of giftset!');
                }
                
                // store giftset thumbnail
                $giftsetThumbnaiPath = CustomImageClass::storeGiftsetThumbnail($request, 'giftset-image', $giftsetName);
                if(empty($giftsetThumbnaiPath)) { // check empty image path
                    return redirect('dashboard/giftsets')
                        ->with('error', 'Unable to save giftset thumbnail into storage!');
                }

                // update thumbnail into giftset table
                $giftset->thumbnail = $giftsetThumbnaiPath;
                $giftset->save();

                // remove all session that use to store temporary giftset product variant
                GiftsetApi::clearSessionData();

            } catch (Exception | Throwable $ex) {
                return redirect('dashboard/giftsets')->with('error', 'Unable to create giftset!');
            }
        } catch (QueryException $e){
            DB::rollBack();
            $errorCode = $e->errorInfo[1];
            if($errorCode == 1062){ // duplicate $key ( giftset name )
                return redirect('dashboard/giftsets')
                    ->with('error', 'Giftset name already exists!');
            }
        }
        //save transaction
        DB::commit();
        return redirect('dashboard/giftsets')
            ->with('success', 'Giftset created successfully');
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        try { // get giftset
            $giftset = Giftset::findOrFail($id);
            $productVariants = $giftset->productVariants;
        }catch(ModelNotFoundException | Throwable | Exception $e) {
            return redirect('dashboard/giftsets')->with('error', 'There was a problem while trying to get giftset!');
        }
        return view('dashboard.giftset.detail')
            ->with('giftset', $giftset)
            ->with('productVariants', $productVariants);
    }

    /**
     * Show the form for editing the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        try { // get giftset
            $giftset = Giftset::find($id);
            
            // delete giftset thumbnail on !null
            if($giftset->thumbnail) {
                CustomImageClass::deleteGiftsetThumbnail($giftset->thumbnail);
            }

            // delete giftset from database
            $result = $giftset->delete();
            if (!$result) {
                throw new ErrorException('Something went wrong while trying to delete giftset!');
            }
        } catch (ModelNotFoundException | Throwable | Exception $ex) {
            return redirect('dashboard/giftsets')->with('error', 'Unable to find giftset!');
        }
        return redirect('dashboard/giftsets')->with('success', 'Giftset successfuly deleted');
    }
}
