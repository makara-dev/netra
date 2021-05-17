<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use Throwable;

use App\BestSeller;
use App\Http\Controllers\Controller;
use App\ProductVariant;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BestSellerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bestSellers = BestSeller::all();

        return view('dashboard/bestSeller/index')
            ->with('bestSellers', $bestSellers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $productVariants = ProductVariant::all()->paginate(10);

        }catch(Exception | Throwable $e){
            return abort('404', 'Product Variants Not Found!');
        }

        return view('dashboard/bestSeller/list')->with('productVariants', $productVariants);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        try{
            $productVariant = ProductVariant::findOrFail($id);
            $bestSellerCount = BestSeller::count();

            // get product thumbnail
            $productVariant->product->thumbnail == null ? 
                $bestSellerThumbnail = null : 
                $bestSellerThumbnail =  $productVariant->product->thumbnail;

            // validating number of recommend thumbnail in db
            if($bestSellerCount > 7) {
                BestSeller::first()->delete();
            }

            $bestSeller = new BestSeller([
                'product_variant_id' => $id,
                'thumbnail'          => $bestSellerThumbnail,
            ]);
            // save to db
            $bestSeller->save();

            return redirect('dashboard/bestseller')
                ->with('success', 'Best seller product added successfully!');

        }catch(Exception | Throwable $e){
            return redirect()->to('dashboard/bestseller/add')
                    ->with('error', 'Enalbe to find product variant');
        }
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
        try{
            // check  product
            $productVariants = ProductVariant::all()->paginate(10);
            $bestSeller = BestSeller::findOrFail($id);

            return view('dashboard/bestSeller/edit')
                ->with('productVariants', $productVariants)
                ->with('bestSeller', $bestSeller);

        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find best seller product thumbnail!');
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($prId, $id)
    {  
        try{ // get best seller product
            $bestSeller = BestSeller::findOrFail($id);   
        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find best seller product!');
        }
        
        DB::beginTransaction();
        try{
            $productVariant  = ProductVariant::findOrFail($prId); // get product variant
            
            // update best seller product
            $bestSeller->product_variant_id = $productVariant->product_variant_id;
            $bestSeller->thumbnail = $productVariant->product->thumbnail;
            $bestSeller->update();
            
        }catch(ModelNotFoundException $e){
            DB::rollBack();
            return back()->with('error', 'Enalbe to find product variant!');
        }

        DB::commit();
        return redirect('dashboard/bestseller')
            ->with('success', 'Best seller product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $bestSeller = BestSeller::findOrFail($id);

            $bestSeller->delete();

            return redirect('dashboard/bestseller')
                ->with('success', 'Best seller product deleted sucessfully!');

        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find best seller product thumbnail!');
        }
    }
}
