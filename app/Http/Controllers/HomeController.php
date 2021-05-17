<?php

namespace App\Http\Controllers;

use App\BestSeller;
use App\PromotionSlider;
use App\FeaturedProduct;
use App\RecommendProduct;
use App\AnythingPanorama;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
// use Illuminate\Support\Collection;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     // $this->middleware('auth');
    //     $this->middleware(['auth', 'verified']);
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(){
        $promotionSliders   = PromotionSlider::all();
        $featuredProducts   = FeaturedProduct::all();
        $recommendProducts  = RecommendProduct::all();
        $bestSellerProducts = BestSeller::all();
        $anythingPanorama   = AnythingPanorama::all();

        foreach( $featuredProducts as $featuredProduct) {
            foreach( $featuredProduct->productVariant->attributeValues->skip(1) as $key => $tmpAttrValue) {
                $attribute = "attribute_".$key;
                $featuredProduct->$attribute = $tmpAttrValue->attribute_value_id;
            };
        }

        foreach( $recommendProducts as $recommendProduct) {
            foreach( $recommendProduct->productVariant->attributeValues->skip(1) as $key => $tmpAttrValue) {
                $attribute = "attribute_".$key;
                $recommendProduct->$attribute = $tmpAttrValue->attribute_value_id;
            };
        }

        foreach( $bestSellerProducts as $bestSellerProduct) {
            foreach( $bestSellerProduct->productVariant->attributeValues->skip(1) as $key => $tmpAttrValue) {
                $attribute = "attribute_".$key;
                $bestSellerProduct->$attribute = $tmpAttrValue->attribute_value_id;
            };
        }
        
        return view('home')
            ->with('promotionSliders', $promotionSliders)
            ->with('featuredProducts', $featuredProducts)
            ->with('recommendProducts', $recommendProducts)
            ->with('bestSellerProducts', $bestSellerProducts)
            ->with('anythingPanorama', $anythingPanorama);
    }
    
    public function customerService($id){
        return view('info.customer-service')->with('id', $id);
    }

    public function companyProfile($id){
        return view('info.company-profile')->with('id', $id);
    }
}
