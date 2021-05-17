<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use App\User;
use Exception;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $productId    = (int)$request['product-id'];
        $user_id   = (int)$request['user-id'];
        $ratingScore  = (int)$request['rating-score'];
        $description  = $request['rating-review'];

        // validated data 
        if(!Product::find($productId)){             // product
            return back()->with('error', 'Product not found or invalid product!');
        }
        if(!User::find($user_id)){                   // user
            return back()->with('error', 'User not found!');
        }
        if($ratingScore < 0 || $ratingScore > 5) {  // rating score
            return back()->with('error', 'Invalid rating score!');
        }

        $review = new Review([
            'user_id'   => $user_id,
            'product_id'    => $productId,
            'description'   => $description,
            'rating'        => $ratingScore,
        ]);

        $review->save();
        return back()->with('success', 'Your review has been added!');
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
        //
    }
}
