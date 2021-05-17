<?php

namespace App\Http\Controllers\Dashboard;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get Lowest product variants in stock 
        $lowestProducts = App\ProductVariant::orderBy('quantity', 'asc')->take(6)->get();

        //get categories
        $categories = App\Category::all();

        //get product column name
        // $productVariantColumns = App\ProductVariant::getTableColumns();

        return view('dashboard.index')
            // ->with('productVariantColumns', $productVariantColumns)
            ->with('lowestProducts', $lowestProducts)
            ->with('categories', $categories);
    }

    /**
     * Display listing of product.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function product(Request $request)
    {

        $sort = $this->getSortType($request, 'product_id', 'asc');

        //get sorted product
        if($sort['sortBy'] === 'category_name'){
            $products =  App\Product::leftJoin('categories', 'categories.category_id', '=', 'products.category_id')
                ->orderBy($sort['sortBy'], $sort['sortOrder'])
                ->paginate(10);
        }else{
            $products = App\Product::orderBy($sort['sortBy'], $sort['sortOrder'])->paginate(10);
        }

        return view('dashboard.product.list')
            ->with('products', $products)
            ->with('categories', App\Category::all());
    }

    /**
     * return the sort type according to request
     * @param  Request $request
     * @return array
     */
    private function getSortType(Request $request, string $sortBy, string $sortOrder = 'asc')
    {
        $sort = [
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder
        ];

        foreach ($request->all() as $requestName => $requestVal) {
            if ($requestVal != null && $requestName !== 'page') {
                $sort['sortBy'] = str_replace('-sort', '', $requestName);;
                $sort['sortOrder'] = $requestVal;
            }
        }
        return $sort;
    }
}
