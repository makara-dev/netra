<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ====================
//    HomePage Routes
// ====================

// Home route
Route::get('/', 'HomeController@index')->name('home');

// Eyecare route
Route::prefix('eyescare')->group(function(){
    Route::get('/', 'EyesCareController@index');

    // blog
    Route::get('/blog', 'EyesCareController@blog');
    Route::get('/blog/{id}', 'EyesCareController@blogdetail');
    
    // diy
    Route::get('/diy', 'EyesCareController@diy');
    Route::get('/diy/{id}', 'EyesCareController@diydetail');
    
    // youtube
    Route::get('/youtube', 'EyesCareController@youtube');
});

// Product route
Route::prefix('products')->group(function () {
    Route::get('new', 'ProductController@newArrival');
    Route::middleware('staff:dashboard/login')->group(function () {
        Route::get('create', 'ProductController@create');
        Route::post('create', 'ProductController@store');
        Route::get('{id}/edit', 'ProductController@edit');
        Route::patch('{id}/edit', 'ProductController@update');
        Route::delete('{id}', 'ProductController@destroy');
    });
    Route::get('{categoryId}', 'ProductController@index');
    Route::get('{id}/details/{attr1Id?}/{attr2Id?}', 'ProductController@show');
});

// Review route
Route::prefix('review')->group(function(){
    Route::post('/store', 'ReviewController@store');
});

// Giftset route
Route::prefix('giftset')->group(function(){
    Route::get('/', 'GiftsetHomeController@index');
});

// Cart route
Route::prefix('cart')->group(function () {
    Route::post('add', 'CartController@store')->middleware('check_quantity');
    Route::post('update', 'CartController@update')->middleware('check_quantity');
    Route::delete('delete/{rowId}', 'CartController@destroy');
});

// Checkout route
Route::prefix('checkout')->group(function () {
    Route::get('cart', 'CheckoutController@index');
    Route::get('invoice', 'CheckoutController@checkoutInvoice')->middleware('is_first_shown_invoice');
    Route::get('contact', 'CheckoutController@create')->middleware('check_cart');
    Route::post('contact', 'CheckoutController@checkout')->middleware('check_cart');
});

// Orders route
Route::post('orders/pdf', 'OrderController@pdf');

// Authentication route
Auth::routes();
Auth::routes(['verify' => true]);

// Authentication route
Route::namespace('Auth')->group(function () {
    Route::get('login/{provider}', 'SocialController@redirect');
    Route::get('callback/{provider}', 'SocialController@callback');
    Route::get('dashboard/login', 'LoginController@showDashboardLogin')->name('dashboard_login');
    Route::post('dashboard/login', 'LoginController@dashboardLogin');
});

// =====================
//   Dashboard Routes
// =====================

// Admin Dashboard route
Route::group(
    [
        'prefix' => 'dashboard',
        'middleware' => 'staff:dashboard/login' //protected from non-staff/non-admin
    ],
    function () {
        Route::namespace('Dashboard')->group(
            function () {
                //dashboard index
                Route::get('/', 'DashboardController@index')->name('dashboard');

                //staff
                Route::group([
                    'prefix' => 'staffs',
                    'middleware' => 'admin:dashboard/login' //protected from staff
                ], function () {
                    Route::get('/', 'StaffController@index');
                    Route::get('create', 'StaffController@create');
                    Route::get('{id}/edit', 'StaffController@edit');
                    Route::delete('{id}', 'StaffController@destroy');
                    Route::middleware('check_username')->group(function () {
                        Route::post('create', 'StaffController@store');
                        Route::patch('{id}/edit', 'StaffController@update')->name('update_staff');
                    });
                });

                // customer
                Route::group([
                    'prefix' => 'customers',
                    'middleware' => 'staff:dashboard/login' //protected from non-staff/non-admin
                ], function(){
                    Route::get('/', 'CustomerController@index');
                    Route::delete('{id}/delete', 'CustomerController@destroy');
                    Route::get('{id}/show', 'CustomerController@show');
                });

                //attributeValue
                Route::prefix('attribute-values')->group(function () {
                    Route::get('create', 'AttributeController@create');
                    Route::post('create', 'AttributeValueController@store');
                });

                //attribute
                Route::prefix('attributes')->group(function () {
                    Route::get('create', 'AttributeController@create');
                    Route::post('create', 'AttributeController@store');
                });

                //product 
                Route::get('products', 'DashboardController@product');

                //product variant
                Route::delete('productvariants/{id}', 'ProductVariantController@destroy');

                //district
                Route::resource('districts', 'DistrictController', ['except' => ['show'] ]);

                //sangkats
                Route::resource('sangkats', 'SangkatController', ['except' => ['show'] ]);

                // featured product
                Route::group([
                    'prefix' => 'featured',
                    'middleware' => 'admin:dashboard/login', // protected from staff
                ], function(){
                    Route::get('/', 'FeaturedProductController@index');
                    Route::get('add', 'FeaturedProductController@create');
                    Route::get('add/{id}', 'FeaturedProductController@store');
                    Route::get('{id}/edit', 'FeaturedProductController@edit');
                    Route::get('{prId}/update/{id}', 'FeaturedProductController@update');
                    Route::delete('{id}', 'FeaturedProductController@destroy');
                });

                // recommend product
                Route::group([
                    'prefix' => 'recommend',
                    'middleware' => 'admin:dashboard/login', // protected from staff
                ], function(){
                    Route::get('/', 'RecommendProductController@index');
                    Route::get('add', 'RecommendProductController@create');
                    Route::get('add/{id}', 'RecommendProductController@store');
                    Route::get('{id}/edit', 'RecommendProductController@edit');
                    Route::get('{prId}/update/{id}', 'RecommendProductController@update');
                    Route::delete('{id}', 'RecommendProductController@destroy');
                });

                // best seller product
                Route::group([
                    'prefix' => 'bestseller',
                    'middleware' => 'admin:dashboard/login', // protected from staff
                ], function(){
                    Route::get('/', 'BestSellerController@index');
                    Route::get('add', 'BestSellerController@create');
                    Route::get('add/{id}', 'BestSellerController@store');
                    Route::get('{id}/edit', 'BestSellerController@edit');
                    Route::get('{prId}/update/{id}', 'BestSellerController@update');
                    Route::delete('{id}', 'BestSellerController@destroy');
                });

                // promotion slide
                Route::group([
                    'prefix' => 'promotionslider',
                    'middleware' => 'admin:dashboard/login', // protected from staff
                ], function(){
                    Route::get('/', 'PromotionSliderController@index');
                    Route::post ('add', 'PromotionSliderController@store');
                    Route::post('update/{id}', 'PromotionSliderController@update');
                    Route::delete('{id}', 'PromotionSliderController@destroy');
                });

                // anything panorama
                Route::group([
                    'prefix' => 'panorama',
                    'middleware' => 'admin:dashboard/login', // protected from staff
                ], function(){
                    Route::get('/', 'AnythingPanoramaController@index');
                    Route::post ('add', 'AnythingPanoramaController@store');
                    Route::post('update/{id}', 'AnythingPanoramaController@update');
                    Route::delete('{id}', 'AnythingPanoramaController@destroy');
                });

                // giftset productvariants 
                /**
                 * Most page with the name of comboset call this controller because client requirement
                 * after everthing already done.
                 */
                Route::group([
                    'prefix' => 'giftsets',
                ], function() {
                    Route::get('/', 'GiftsetController@index');
                    Route::get('/create', 'GiftsetController@create');
                    Route::post('/createGiftset', 'GiftsetController@createGiftset');
                    Route::post('/add', 'GiftsetController@store');
                    Route::delete('{id}', 'GiftsetController@destroy');
                    Route::get('/detail/{id}', 'GiftsetController@show');
                });

                // promoset productvariants
                Route::group([
                    'prefix' => 'promosets',
                ], function() {
                    Route::get('/', 'PromosetController@index');
                    Route::get('/create', 'PromosetController@create');
                    Route::post('/createPromoset', 'PromosetController@createPromoset');
                    Route::post('/add', 'PromosetController@store');
                    Route::delete('{id}', 'PromosetController@destroy');
                    Route::get('/detail/{id}', 'PromosetController@show');
                });

                // quotation
                Route::group([
                    'prefix' => 'quotation',
                    'middleware' => 'admin:dashboard/login',
                ], function(){
                    Route::get('/', 'QuotationController@index')->name('quotation-list');
                    Route::get('/create', 'QuotationController@create')->name('quotation-add');
                    Route::post('/store', 'QuotationController@store')->name('quotation-store');
                    Route::get('/show/{id}', 'QuotationController@show')->name('quotation-show');
                    Route::get('/edit/{id}', 'QuotationController@edit')->name('quotation-edit');
                    Route::post('/update/{id}', 'QuotationController@update')->name('quotation-update');
                    Route::put('/destroy/{id}', 'QuotationController@destroy')->name('quotation-destroy');
                    Route::get('createToSale/{id}', 'QuotationController@createToSale')->name('createToSale');
                    Route::get('/autocomplete', 'QuotationController@autocomplete')->name('autocomplete');

                });

                // export ESV quotation 
                Route::get('/exportQuotation', 'CsvExportController@exportCsv');

                // download pdf quotation
                Route::get('/pdf_download', 'pdfDownloadQuotationController@pdfDownload')->name('quotation-download');

                // sales
                Route::group([
                    'prefix' => 'sales',
                    'middleware' => 'admin:dashboard/login',
                ], function () {
                    Route::get('/', 'SalesController@index')->name('sale-list');
                    Route::get('/create', 'SalesController@create')->name('sale-add');
                    Route::post('/create', 'SalesController@store');
                    Route::get('{id}/edit', 'SalesController@edit');
                    Route::patch('{id}/edit', 'SalesController@update')->name('sale-update');
                    Route::get('{id}/detail', 'SalesController@show')->name('sale-detail');
                    Route::delete('{id}', 'SalesController@destroy')->name('sale-delete');

                });

                // customer group
                Route::group([
                    'prefix' => 'customers-group',
                    'middleware' => 'admin:dashboard/login',
                ], function(){
                    Route::get('/', 'CustomerGroupController@index')->name('cusgroup-list');
                    Route::get('/create', 'CustomerGroupController@create')->name('cusgroup-add');
                    Route::post('/create', 'CustomerGroupController@store');
                    Route::get('{id}/edit', 'CustomerGroupController@edit');
                    Route::patch('{id}/edit', 'CustomerGroupController@update')->name('cusgroup-update');
                    Route::get('{id}/detail', 'CustomerGroupController@show')->name('cusgroup-detail');
                    Route::delete('{id}', 'CustomerGroupController@destroy')->name('cusgroup-delete');
                    
                });

                // Exchange Rates
                Route::group([
                    'prefix' => 'exchange-rate',
                    'middleware' => 'admin:dashboard/login',
                ], function(){
                    Route::get('/', 'ExchangeRateController@index')->name('exrate-list');
                    Route::get('/create', 'ExchangeRateController@create')->name('exrate-add');
                    Route::post('/store', 'ExchangeRateController@store');
                    Route::get('{id}/edit', 'ExchangeRateController@edit');
                    Route::patch('{id}/edit', 'ExchangeRateController@update')->name('exrate-update');
                    Route::get('{id}/detail', 'ExchangeRateController@show')->name('exrate-detail');
                    Route::delete('{id}', 'ExchangeRateController@destroy')->name('exrate-delete');
                    
                });

                // stock
                Route::group([
                    'prefix' => 'stock',
                    'middleware' => 'admin:dashboard/login',
                ], function(){
                    Route::get('/', 'StockController@index')->name('stock-list');
                    Route::get('{id}/detail', 'StockController@show')->name('stock-detail');
                    
                });

                // adjustment
                Route::group([
                    'prefix' => 'adjustment',
                    'middleware' => 'admin:dashboard/login',
                ], function(){
                    Route::get('/', 'AdjustmentController@index')->name('adjustment-list');
                    Route::get('/create', 'AdjustmentController@create')->name('adjustment-add');
                    Route::post('/store', 'AdjustmentController@store');
                    Route::get('{id}/edit', 'AdjustmentController@edit');
                    Route::patch('{id}/edit', 'AdjustmentController@update')->name('adjustment-update');
                    Route::get('{id}/detail', 'AdjustmentController@show')->name('adjustment-detail');
                    Route::delete('{id}', 'AdjustmentController@destroy')->name('adjustment-delete');
                      
                });

            }
        );
        //order
        Route::group([
            'prefix' => 'orders',
        ], function(){
            Route::get('/', 'OrderController@index')->name("order-list");
            Route::get('/create', 'OrderController@create');
            Route::post('/store', 'OrderController@store')->name("order-store");
            Route::get('{id}', 'OrderController@show');
            Route::get('{id}/edit', 'OrderController@edit');
            Route::patch('{id}/edit', 'OrderController@update');
            Route::delete('delete/{id}', 'OrderController@destroy');
        });
    }
);

// Customer service route
Route::get('customer-service/{section_id}', array('as' => 'infoSection', 'uses' => 'HomeController@customerService'))
    ->where('section_id', '(how-to-buy-info|delivery-and-shipping-info|faq-info|online-exchange-and-return-policy-info|size-guide-info)');

// Company profile route
Route::get('company-profile/{section_id}', array('as' => 'infoSection', 'uses' => 'HomeController@companyProfile'))
    ->where('section_id', '(brand-info|careers|privacy-policy|terms-and-conditions)');
