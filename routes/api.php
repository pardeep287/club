<?php

    use Illuminate\Http\Request;

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

//    Route::middleware('auth:api')->get('/user', function (Request $request) {
//        return $request->user();
//    });

    Route::post('/user/details', "UserController@mobile")
        ->name("user_details");

    Route::post('/user/transactions', "UserController@transactionsOnly")
        ->name("user_transactions_only");


    Route::prefix('uber')->group(function(){
        Route::get('', 'ApiUberController@getAccessToken')->name('user.getAccessToken');
    });


    Route::prefix('android')->group(function () {
        Route::get('/', function () {
            return 'welcome to Club JB Android API';
        });


        Route::post('/bonuscodevalidate', 'ApiBonusDealCodeController@validateCode');

        Route::prefix('/location')->group(function () {
            Route::get('/', 'ApiLocationController@location_details')->name('api_get_location');
            Route::get('/country', 'ApiLocationController@country_details')->name('api_get_country');
            Route::get('/state', 'ApiLocationController@state_details')->name('api_get_state');
            Route::get('/city', 'ApiLocationController@city_details_with_categories')->name('api_get_city');
            Route::get('/subcity', 'ApiLocationController@subcity_details')->name('api_get_subcity');
        });

        Route::get('/cities', 'ApiLocationController@cities');
        Route::get('city/{city}/', 'ApiLocationController@city');
        Route::get('/{city}/booklets', 'ApiLocationController@city');

        Route::get('/adverts', 'ApiController@adverts');

        Route::get('/home', 'ApiDealController@citySpecificDeals');
        Route::post('/home', 'ApiDealController@cityCustomerSpecificDeals');

        Route::post('/optimalHome', 'ApiTestRoutesController@cityDealsPDO');

        Route::get('/booklets', 'ApiTransactionController@cityBooklets');
        Route::get('/booklet', "ApiTransactionController@booklets");
        Route::get('/booklet/{booklet}', "ApiTransactionController@booklet");
        Route::post('/bookletselect', 'PaymentController@purchaseBooklet');
        Route::post('/booklet/mine', 'ApiTransactionController@bookletDeals');

        Route::get('/store', 'ApiController@store_details')->name('api_get_store');
        Route::post('/store', 'ApiDealController@storeCustomerSpecificDeals');
        Route::post('/topStores', 'ApiController@topPickedStores');
        Route::get('/store/{store}', "ApiController@storeDetails")->where('store', '[0-9]+');

        Route::post('/deal/view', 'ApiDealController@dealDetails');
        Route::post('/deal/redeem', 'OrderController@redeem_deal')->name('api.deal.redeem');

        Route::get('/bonusDeal', "Api\BonusDealController@bonusDeals")->name('api.bonus.deal.index');
        Route::post('/bonusDeal/redeem', "Api\BonusDealController@redeem")->name('api.bonus.deal.redeem');

        Route::get('/categories', 'ApiController@categories');
        Route::get('/category', 'ApiController@category_details')->name('api_get_category');
        Route::get('/subcategories', 'ApiController@subcategories')->name('api_get_subcategories');

        Route::post('/login', "ApiClientController@login");
        Route::post('/register/device', "ApiClientController@registerDevice");

        Route::post('/otp/request', 'ApiClientController@requestOTP');
        Route::post('/otp/validate', 'ApiClientController@validateOTP');

        Route::post('/get_client', "ApiClientController@getClient");
        Route::post('/associate', "ApiClientController@associate");
        Route::post('/update/profile', "ApiClientController@updateClient")->name('client_profile_update');
        Route::get('/history', "HtmlController@orders")->name('client_orders');

        Route::get('/about', 'ApiController@about');

        Route::get('/value/{value}', 'ApiController@getValue');


        Route::get('/jbcare', 'ApiController@jbCare');
        Route::get('/{city}/jbcare', 'ApiController@jbCareCity');

        Route::get('/update/app', 'ApiController@getUpdate');

        Route::prefix('data')->group(function () {
            Route::match(['get', 'post'], '/city_deals', 'Api\DealController@cityDeals');
        });



    });


    Route::prefix('v1')->group(function () {
        Route::post('/client', 'ApiClientController@getClient')->name('ajax_client_details');

        Route::post('/advertisments', 'AdvertismentController@edit')->name('advertisment_edit');

        Route::prefix('/payment')->group(function () {
            Route::get('/done', function () {
                return '';
            })->name('cc_done');
            Route::any('/getRSA', 'PaymentController@getRSA')->name('cc_get_rsa');
            Route::any('/response', 'PaymentController@ccavResponseHandler')->name('cc_response_redirect');
            Route::any('/cancel', 'PaymentController@ccavResponseHandler')->name('cc_cancel');
        });
    });


    Route::prefix('html')->group(function () {
        Route::post('/booklet', "HtmlController@booklet")->name('html_booklet_deals');
    });

    Route::prefix('ola')->group(function(){
        Route::get('/tokens', 'ApiOlaController@olaindex');
    });