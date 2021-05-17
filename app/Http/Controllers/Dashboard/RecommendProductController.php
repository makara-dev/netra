<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use Throwable;

use App\ProductVariant;
use App\Http\Controllers\Controller;
use App\RecommendProduct;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecommendProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recommendProducts = RecommendProduct::all();

        return view('dashboard/recommendProduct/index')
            ->with('recommendProducts', $recommendProducts);
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

        return view('dashboard/recommendProduct/list')->with('productVariants', $productVariants);
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
            $featureCount = RecommendProduct::count();

            // get product thumbnail
            $productVariant->product->thumbnail == null ? 
                $recommendThumbnail = null : 
                $recommendThumbnail =  $productVariant->product->thumbnail;

            // validating number of recommend thumbnail in db
            if($featureCount > 7) {
                RecommendProduct::first()->delete();
            }

            $recommendProduct = new RecommendProduct([
                'product_variant_id' => $id,
                'thumbnail'          => $recommendThumbnail,
            ]);
            // save to db
            $recommendProduct->save();

            return redirect('dashboard/recommend')
                ->with('success', 'Recommend product added successfully!');

        }catch(Exception | Throwable $e){
            return redirect()->to('dashboard/recommend/add')
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
            $recommendProduct = RecommendProduct::findOrFail($id);

            return view('dashboard/recommendProduct/edit')
                ->with('productVariants', $productVariants)
                ->with('recommendProduct', $recommendProduct);

        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find recommend product thumbnail!');
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
        try{ // get recommend product
            $recommendProduct = RecommendProduct::findOrFail($id);   
        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find recommend product!');
        }
        
        DB::beginTransaction();
        try{
            $productVariant  = ProductVariant::findOrFail($prId); // get product variant
            
            // update recommend product
            $recommendProduct->product_variant_id = $productVariant->product_variant_id;
            $recommendProduct->thumbnail = $productVariant->product->thumbnail;
            $recommendProduct->update();
            
        }catch(ModelNotFoundException $e){
            DB::rollBack();
            return back()->with('error', 'Enalbe to find product variant!');
        }

        DB::commit();
        return redirect('dashboard/recommend')
            ->with('success', 'Recommend product updated successfully!');
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
            $recommendProduct = RecommendProduct::findOrFail($id);

            $recommendProduct->delete();

            return redirect('dashboard/recommend')
                ->with('success', 'Recommend Product deleted sucessfully!');

        }catch(Throwable | Exception $e){
            return back()->with('error', 'Enable to find recommend product thumbnail!');
        }
    }
}
