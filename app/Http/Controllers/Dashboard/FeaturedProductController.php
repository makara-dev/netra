<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use Throwable;

use App\ProductVariant;
use App\FeaturedProduct;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FeaturedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $featuredProducts = FeaturedProduct::all();

        return view('dashboard/featuredProduct/index')
            ->with('featuredProducts', $featuredProducts);
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

        return view('dashboard/featuredProduct/list')->with('productVariants', $productVariants);
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
            $featureCount = FeaturedProduct::count();

            // get product thumbnail
            $productVariant->product->thumbnail == null ? 
                $featuredThumbnail = null : 
                $featuredThumbnail =  $productVariant->product->thumbnail;

            // validating number of featured thumbnail in db
            if($featureCount > 3) {
                FeaturedProduct::first()->delete();
            }

            $featuredProduct = new FeaturedProduct([
                'product_variant_id' => $id,
                'thumbnail'          => $featuredThumbnail,
            ]);
            // save to db
            $featuredProduct->save();

            return redirect('dashboard/featured')
                ->with('success', 'Featured product added successfully!');

        }catch(Exception | Throwable $e){
            return redirect()->to('dashboard/featured/add')
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
            // check featured product
            $productVariants = ProductVariant::all()->paginate(10);
            $featuredProduct = FeaturedProduct::findOrFail($id);

            return view('dashboard/featuredProduct/edit')
                ->with('productVariants', $productVariants)
                ->with('featuredProduct', $featuredProduct);

        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find featured product thumbnail!');
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
        try{ // get featured product
            $featuredProduct = FeaturedProduct::findOrFail($id);   
        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find featured product!');
        }
        
        DB::beginTransaction();
        try{
            $productVariant  = ProductVariant::findOrFail($prId); // get product variant
            
            // update featured product
            $featuredProduct->product_variant_id = $productVariant->product_variant_id;
            $featuredProduct->thumbnail = $productVariant->product->thumbnail;
            $featuredProduct->update();
            
        }catch(ModelNotFoundException $e){
            DB::rollBack();
            return back()->with('error', 'Enalbe to find product variant!');
        }

        DB::commit();
        return redirect('dashboard/featured')
            ->with('success', 'Featured product updated successfully!');
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
            $featuredProduct = FeaturedProduct::findOrFail($id);

            $featuredProduct->delete();

            return redirect('dashboard/featured')
                ->with('success', 'Featured Product deleted sucessfully!');

        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find featured product thumbnail!');
        }
    }
}
