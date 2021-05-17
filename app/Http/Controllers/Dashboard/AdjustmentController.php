<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Adjustment;
use App\ProductVariant;
use App\Http\Requests\Dashboard\StoreAdjustmentRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Auth;

class AdjustmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all adjustment
        $adjustments = Adjustment::getAdjustments();
        if(!$adjustments->data){
            return back()->with('error', $adjustments->messange);
        }
        $adjustments = $adjustments->data;
        return view('dashboard.adjustment.index', compact('adjustments'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get all product variants
        $productVariants = ProductVariant::getProductVariants();
        if(!$productVariants->data){
            return back()->with('error', $productVariants->messange);
        }
        $productVariants = $productVariants->data;
        return view('dashboard.adjustment.add', compact('productVariants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdjustmentRequest $request)
    {
        // request data from form
        $datetime          = $request['datetime'];
        $reference_no      = $request['reference_no'];
        $warehouse         = $request['warehouse'];
        $document          = $request['document'];
        $quantitys         = $request['quantity'];
        $productVariants   = $request['productvariantid'];
        // dd($productVariants);
        $types             = $request['types'];
        $note              = $request['note'];
        
        // check validation
        // $checkValidateRequest = Adjustment::checkValidateRequest( $reference_no, $warehouse, $quantitys, $document, $types, $note);
        // if ($checkValidateRequest) {
        //     return back()->with('error', $checkValidateRequest->message);
        // }

        $user_name         = Auth::user()->name;
        $created_by        = Adjustment::getCreatedBy($user_name);
        $documentname      = Adjustment::uploadDocument($document);
            
        try {
            DB::beginTransaction();
            // create adjustment
            $adjustment = new Adjustment([
                'datetime'          => $datetime,
                'reference_no'      => $reference_no,
                'warehouse'         => $warehouse,
                'document'          => $documentname,
                'created_by'        => $created_by,
                'note'              => $note,
            ]);
            
            // save to db
            $adjustment->save();
            // save product variant, type, quantity in center table tween product variant and adjustment table
            foreach($productVariants as $key=> $productVariant){
                $adjustment->product_variants()->attach(
                    $productVariant,
                    [
                        'quantity' => $quantitys[$key],
                        'type'     => $types[$key],
                    ]
                );
            }
           // add type addition or subtrations of the product's quantity 
           foreach($productVariants as $key => $item){
                if($types[$key] === "Addition"){
                    $pro = ProductVariant::find($item);
                    $sumquatity = $pro->quantity + $quantitys[$key];
                    $pro->quantity = $sumquatity;
                    $pro->save();
                }elseif($types[$key] === "Subtractions"){
                    $pro = ProductVariant::find($item);
                    if($pro->quantity >= $quantitys[$key]){
                        $sumquatity = $pro->quantity - $quantitys[$key];
                    }else {
                        return back()->with('error', 'Warehouse quantity is less than damaged quantity');
                    }
                    $pro->quantity = $sumquatity;
                    $pro->save();
                }
            }

        } catch(QueryException $e) {
            DB::rollBack();
            return back()->with('error', '');
        }

        DB::commit();
        return redirect()->route('adjustment-list')
        ->with('success', 'Adjustment create successfully!');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //find adjudtment
        $adjustment = Adjustment::getAdjustment($id);
        if(!$adjustment->data){
            return back()->with('error', $adjustment->messange);
        }
        $adjustment = $adjustment->data;

        //getting privot adjustment
        $tempAdjustmentProductvariantPivot = DB::table('product_variant_adjustments')
        ->where('adjustment_id', $adjustment->id)
        ->get();
        foreach($adjustment->product_variants as $key => $product_variant){
            $product_variant->quantity = $tempAdjustmentProductvariantPivot[$key]->quantity;
            $product_variant->type = $tempAdjustmentProductvariantPivot[$key]->type;
        }
       $product_variants = $adjustment->product_variants;

        return view('dashboard.adjustment.detail', compact('adjustment', 'product_variants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find adjudtment
        $adjustment = Adjustment::getAdjustment($id);
        if(!$adjustment->data){
            return back()->with('error', $adjustment->messange);
        }
        $adjustment = $adjustment->data;

        // get all product variants
        $productVariants = ProductVariant::getProductVariants();
        if(!$productVariants->data){
            return back()->with('error', $productVariants->messange);
        }
        $productVariants = $productVariants->data;

        return view('dashboard.adjustment.edit', compact('adjustment', 'productVariants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAdjustmentRequest $request, $id)
    {
        // request data from form
        $datetime          = $request['datetime'];
        $reference_no      = $request['reference_no'];
        $warehouse         = $request['warehouse'];
        $document          = $request['document'];
        $quantitys         = $request['quantity'];
        $productVariants   = $request['productvariantid'];
        $types             = $request['types'];
        $note              = $request['note'];

         // check validation
        // $checkValidateRequest = Adjustment::checkValidateRequest( $reference_no, $warehouse, $quantitys, $document, $types, $note);
        // if ($checkValidateRequest) {
        //     return back()->with('error', $checkValidateRequest->message);
        // }
        $documentname      = Adjustment::uploadDocument($document);

        //find adjudtment
        $adjustment = Adjustment::getAdjustment($id);
        if(!$adjustment->data){
            return back()->with('error', $adjustment->messange);
        }
        $adjustment = $adjustment->data;
        
        try{
            DB::beginTransaction();
            
            // patch data
            $adjustment->datetime          = $datetime;
            $adjustment->reference_no      = $reference_no;
            $adjustment->warehouse         = $warehouse;
            $adjustment->document          = $documentname;
            $adjustment->note              = $note;
            
            // update adjustment record in db
            $adjustment->save();
            
            // detach data data from product_variant and adjustment table before attach new data
            foreach($adjustment->product_variants as $key => $product_variant){
                $adjustment->product_variants()->detach($product_variant->product_variant_id);
            }
            // update product variant, type, quantity in center table tween product variant and adjustment table
            foreach($productVariants as $key=> $productVariant){
                $adjustment->product_variants()->attach(
                    $productVariant,
                    [
                        'quantity' => $quantitys[$key],
                        'type'     => $types[$key],
                    ]
                );
            }
           // update type addition or subtrations of the product's quantity 
           foreach($productVariants as $key => $item){
                if($types[$key] === "Addition"){
                    $pro = ProductVariant::find($item);
                    $sumquatity = $pro->quantity + $quantitys[$key];
                    $pro->quantity = $sumquatity;
                    $pro->save();
                }elseif($types[$key] === "Subtractions"){
                    $pro = ProductVariant::find($item);
                    if($pro->quantity >= $quantitys[$key]){
                        $sumquatity = $pro->quantity - $quantitys[$key];
                    }else {
                        return back()->with('error', 'Warehouse quantity is less than damaged quantity');
                    }
                    $pro->quantity = $sumquatity;
                    $pro->save();
                }
            }

        } catch(QueryException $e) {
            DB::rollBack();
            return back()->with('error', 'Customer group name already exist!');
            
        }

        DB::commit();
        return redirect()->route('adjustment-list')
            ->with('success', 'Adjustment update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          //find adjudtment
          $adjustment = Adjustment::getAdjustment($id);
          if(!$adjustment->data){
              return back()->with('error', $adjustment->messange);
          }
          $adjustment = $adjustment->data;

          try {
            // delete adjustment in db
            $adjustment->delete();

            return redirect()->route('adjustment-list')
                ->with('success', 'Adjustment delete successfully!');
                
        } catch(ModelNotFoundException $e) {
            return redirect()->route('adjustment-list')
                ->with('error', 'Adjustment record not found!');
        }
    }
}
