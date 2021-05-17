<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api')->group(function(){
    // product api
    Route::prefix('product')->group(function(){
        Route::get('attribute/{categoryId}', 'ApiProductController@getAttributes');
        Route::post('/stock', 'ApiProductVariantController@checkStock');
    });

    // productvariant api
    Route::delete('productvariant/{id}', 'ApiProductVariantController@destroy');

    // image file api
    Route::delete('image/{id}', 'ApiImageController@destroy');

    // sangkats and districts api
    Route::get('districts/sangkats/{id}', 'ApiDistrictController@sangkats');

    // giftset api
    Route::get('giftset/productvariant/{paginateId}/{id}/{status}/{paginationPageName}', 'ApiGiftsetProductVariantController@storeGiftsetPvSession');
    Route::get('giftset/productvariant/getDataSession/{paginationPageName}', 'ApiGiftsetProductVariantController@getTotalPaginationPage');
});
