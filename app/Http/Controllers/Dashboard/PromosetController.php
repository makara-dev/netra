<?php

namespace App\Http\Controllers\Dashboard;

use App\Promoset;
use Carbon\Carbon;
use App\ProductVariant;
use App\Http\Controllers\Controller;
use App\CustomLibs\ManagesImages as CustomImageClass;
use Intervention\Image\ImageManagerStatic as ImageManger;
use App\Http\Controllers\Api\ApiGiftsetProductVariantController as GiftsetApi;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Throwable;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use PHPUnit\Util\Json;

class PromosetController extends Controller
{
    use CustomImageClass;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $promosets = Promoset::paginate(4);
            $totalPromoset = Promoset::count();
            // $promosets = Promoset::all();
        } catch( ModelNotFoundException | Throwable | Exception $ex) {
            return back()->with('error', 'There is a problem while trying to get giftset!');
        }
        return view('dashboard.promoset.index')
            ->with('totalPromoset', $totalPromoset)
            ->with('promosets', $promosets);
    }

    /**
     * Show the form for creating a new productvaraints.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //get product variants
        try {
            $productVariants = ProductVariant::paginate(10);
        }catch(ModelNotFoundException | Throwable | Exception $e) {
            return back()->with('error', 'There is a problem while trying to get product variants!');
        }
        return view('dashboard.promoset.promoset_pr_add')
            ->with('productVariants', $productVariants)
            ->with('currentPage', $request['page'].'-purchasePaginationPage');
    }

    /**
     * Show the form for creating a new promoset detail informations.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createPromoset(Request $request) {
        $totalPaginationPage = json_decode($request['productVariants']);

        // validate on null submitted
        if($totalPaginationPage != null) { 
            // get all purchase product variant from giftsetapi
            $purchsePvArr = GiftsetApi::getProductVariantArray($totalPaginationPage);

            // check empty returnning data (array)
            if(!empty($purchsePvArr)){
                //get product variants
                try {
                    $productVariants = ProductVariant::all();
                }catch(ModelNotFoundException | Throwable | Exception $e) {
                    return back()->with('error', 'There is a problem while trying to get product variants!');
                }

                return view('dashboard.promoset.add')
                    ->with('productVariants', $productVariants)
                    ->with('purchsePvArr', $purchsePvArr);

            } else {
                return back()->with('error', 'There is a problem while trying to get data from Giftset Api');
            }
        } else {
            return back()->with('error', 'trying to submit on null product variant selected!');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $setNameArr                 = $request['setNames'];
        $setPurchaseConditionArr    = $request['purchaseConditions'];
        $setFreeConditionArr        = $request['freeConditions'];
        $purchaseProductVariantsArr = json_decode($request['purchasePvArr']);
        $freeProductVariantArr      = $request['freePvIds'];
        $setDiscountOfferArr        = $request['setDiscountOffers'];
        $setThumbnailArr            = $request['setThumbnailFile'];
        $setDescriptionArr          = $request['setDescriptions'];

        DB::beginTransaction();
        try {                       
            // save promoset and related bridge table an item per time.
            $promosets = new Collection();
            foreach($setNameArr as $key => $setName) {   
                $promoset = new Promoset([
                    'promoset_name' => $setName,
                    'promoset_condition' => $setPurchaseConditionArr[$key],
                    'provider_condition' => $setFreeConditionArr[$key],
                    'discount_price_offer' => $setDiscountOfferArr[$key],
                    'promoset_description' => $setDescriptionArr[$key],
                ]);
                
                // store promoset thumbnail into storage
                $promoset->promoset_thumbnail = PromosetController::storePromosetThumbnail($request, 'setThumbnailFile', $setName, $key);
                if(empty($promoset->promoset_thumbnail)) { // check empty image path
                    return redirect('dashboard/promosets')
                        ->with('error', 'Unable to save giftset thumbnail into storage!');
                }
                $promosets->add($promoset);
            }

            foreach($promosets as $key => $promoset) {
                // save promoset into db
                $promosetResult = $promoset->save();
                if(!$promosetResult){
                    return redirect('dashboard/promosets')->with('error', 'Unable to save giftset into database!');                    
                }

                // create purchase productvariant promoset and free productvariant promoset
                try {
                    // attach(save) purchase productvariants promoset into bridge table
                    $promoset->productVariantsPurchase()->attach($purchaseProductVariantsArr);

                    // free promoset
                    $freePvItems = array();
                    // convert string into array
                    $freeProductVariantArrIds = array_map('intval', explode(',',$freeProductVariantArr[$key]));
                    foreach($freeProductVariantArrIds as $productVariantId){
                        array_push($freePvItems, [
                            'promoset_id'        => $promoset->promoset_id,
                            'product_variant_id' => $productVariantId ,    
                        ]);
                    }
                    // save into bridge table
                    $promoset->productVariantsFree()->attach($freeProductVariantArrIds);

                    // $freePvPromosetResult = DB::table("pvfree_promoset_bridges")->insert($freePvItems);

                } catch(Throwable | Exception $ex) {
                    DB::rollBack();
                    return redirect('dashboard/promosets')->with('error', 'Unable to create giftset!');
                }
            }
        } catch(Exception | Throwable $e) {
            DB::rollBack();
            return redirect('dashboard/promosets')->with('error', 'Unable to create and save giftset into database!');
        }

        // save records
        DB::commit();
        // clear session 
        GiftsetApi::clearSessionData();
        return redirect('dashboard/promosets')->with('success', 'Giftset Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get promoset
        try {
            $promoset    = Promoset::find($id);
            $purchasePvs = $promoset->productVariantsPurchase;
            $freePvs     = $promoset->productVariantsFree;

        } catch(ModelNotFoundException | Throwable $ex) {
            return redirect('dashboard/promosets')->with('error', 'Giftset not found!');
        }
        return view('dashboard/promoset/detail')
            ->with('purchasePvs', $purchasePvs)
            ->with('freePvs', $freePvs)
            ->with('promoset', $promoset);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try { // get promoset
            $promoset = Promoset::find($id);

            // delete giftset thumbnail on !null
            if($promoset->promoset_thumbnail) {
                CustomImageClass::deleteGiftsetThumbnail($promoset->promoset_thumbnail);
            }

            // delete giftset
            $result = $promoset->delete();
            if (!$result) {
                throw new ErrorException('Something went wrong while trying to delete giftset!');
            }
        }catch (ModelNotFoundException | Exception | Throwable $ex) {
            return redirect('dashboard/promosets')->with('error', 'Giftset set not found!');
        }

        return redirect('dashboard/promosets')->with('success', 'Giftset successfuly deleted');
    }

    /**
     * write(save) Promoset Thumbnail into storage
     * @param Illuminate\Http\UploadedFile $image
     * @return string $thumbnailPath
     */
    static function storePromosetThumbnail($request, $imageFileName, $promosetName, $index)
    {
        if ($request->hasFile($imageFileName)) {
            $current_timestamp = Carbon::now()->timestamp;
            $image = $request->file($imageFileName)[$index];
            $fileName = $promosetName . '-' . $current_timestamp . '.' . $image->getClientOriginalExtension();
            $img = ImageManger::make($image->getRealPath());
            $img->resize(
                990,
                480,
                function ($constraint) {
                    $constraint->aspectRatio();
                }
            );
            $img->stream();
            $imagePath = 'images/giftset2/' . $fileName;
            Storage::disk('public')->put($imagePath, $img);
            return $imagePath;
        } else {
            return null;
        }
    }
}
