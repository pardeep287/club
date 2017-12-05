<?php

    /*
    |**************************************************
    | Web Routes
    |**************************************************
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    Route::get('/', 'HomeController@index');
    Route::get('/home', 'HomeController@index')
        ->name('home');

    Route::prefix('deals')->middleware(['auth'])->group(function () {
        Route::get('', 'Frontend\DealsController@index')
            ->name('deals.index');
        Route::get('/{id}', 'Frontend\DealsController@single')
            ->name('deals.single');
    });


    Route::get('/send', 'HomeController@testMail');

    Route::get('/phpinfo', function () {
        echo "secured";
//         phpinfo();
//        $adverts = App\Advertisment::where('active', '1')->orderBy('ord')->paginate(App\DefaultValue::getValue('advertsCount', 5)['clean']);

//        return $adverts;
    });

    Route::get('/downloader/{refCode?}/{username?}', 'DownloaderController@index')->name('downloader');

    Auth::routes();

    Route::prefix('admin')->middleware(['auth'])->group(function () {
        Route::get('/dashboard', 'HomeController@dashboard')
            ->name('dashboard');

        /**
         * Location Management
         */
        Route::prefix('location')->group(function () {

            Route::get('/state', 'LocationApiController@state')->name('state');
            Route::post('/state', 'LocationApiController@state_add')->name('add_new_state');

            Route::get('/city', 'LocationApiController@city')->name('city');
            Route::post('/city', 'LocationApiController@city_add')->name('add_new_city');

            Route::get('/subcity', 'LocationApiController@subcity')->name('subcity');
            Route::post('/subcity', 'LocationApiController@subcity_add')->name('add_new_subcity');


            Route::prefix('country')->group(function () {
                Route::prefix('{country}')->group(function () {
                    Route::prefix('state')->group(function () {
                        Route::delete('/{state}', 'LocationController@state_delete')->name('state_delete');
                        Route::get('/', 'LocationController@state_index')->name('state_selective');
                        Route::post('/', 'LocationController@state_add')->name('state_add');
                        Route::patch('/', 'LocationController@state_edit')->name('state_edit');

                        Route::prefix('{state}/city')->group(function () {
                            Route::delete('/{city}', 'LocationController@city_delete')->name('city_delete');
                            Route::get('/', 'LocationController@city_index')->name('city_selective');
                            Route::post('/', 'LocationController@city_add')->name('city_add');
                            Route::patch('/', 'LocationController@city_edit')->name('city_edit');

                            Route::prefix('{city}')->group(function () {
                                Route::get('/booklets', 'BookletController@city_booklets')->name('city_booklets');
                                Route::prefix('/subcity')->group(function () {
                                    Route::get('/', 'LocationController@subCity_index')->name('subcity_selective');
                                    Route::post('/', 'LocationController@subCity_add')->name('subcity_add');
                                    Route::patch('/', 'LocationController@subCity_edit')->name('subcity_edit');
                                });

                            });
                        });
                    });
                });

                Route::get('/', 'LocationController@country_index')
                    ->name('country');
                Route::post('/', 'LocationController@country_add')
                    ->name('country_add');
                Route::patch('/', 'LocationController@country_edit')
                    ->name('country_edit');
                Route::delete('/{country}', 'LocationController@country_delete')
                    ->name('country_delete');

            });
        });

        /**
         * Booklet Management
         */
        Route::prefix('/booklet')->group(function () {

            Route::get('/all', "BookletController@index")
                ->name('booklet');
            Route::get('/{booklet}/deal', "BookletController@show")
                ->name('booklet_deals');
            Route::post('/{booklet}/deal', "BookletController@associate")
                ->name('booklet_associate');


            /**
             * Booklet Code Management
             */
            Route::get('/{booklet}/code', "CodeController@index")
                ->name('code');
            Route::post('/{booklet}/code', "CodeController@create")
                ->name('code_create');

            Route::post('/{booklet}/code/expired', "CodeController@expiry")
                ->name("code.expired.handle");


            /**
             * Booklet Transaction Management
             */
            Route::get('/booklettransactions', 'CustomerCareController@booklet_request')
                ->name('booklettransactions');
            Route::post('/purchase', 'CustomerCareController@booklet_purchase')
                ->name('bookletpurchase');

            Route::get('/givebooklets', 'CustomerCareController@giveBooklets_form')
                ->middleware('auth', 'admin')
                ->name('givebooklets');
            Route::post('/givebooklets', 'CustomerCareController@giveBooklets')
                ->middleware('auth', 'admin')
                ->name('givebooklets_submit');

            /**
             * Basic Booklet Tasks
             */
            Route::post('/', "BookletController@add")
                ->name('booklet_add');
            Route::patch('/', "BookletController@edit")
                ->name('booklet_edit');
            Route::delete('/{booklet}', "BookletController@delete")
                ->name('booklet_delete');

        });


        /**
         * Category Management
         */
        Route::prefix('/category')->group(function () {
            Route::get('/', "CategoryController@index")
                ->name('category');
            Route::post('/', "CategoryController@add")
                ->name('category_add');
            Route::patch('/', "CategoryController@edit")
                ->name('category_edit');
        });

        /**
         * Sub Category Management
         */
        Route::prefix('/subcategory')->group(function () {
            Route::get('/', 'SubCategoryController@index')
                ->name('subcategory');
            Route::post('/', "SubCategoryController@add")
                ->name('subcategory_add');
            Route::patch('/', "SubCategoryController@edit")
                ->name('subcategory_edit');
        });


        /**
         * Store Management
         */
        Route::prefix('store')->group(function () {

            Route::get("/report", "StoreController@report")
                ->name('store.reports');
            Route::get('/{store}/deal', "DealController@for_store")
                ->name('store_deals');
            Route::get('/deals', 'DealController@query_store')
                ->name('query_store');

            Route::get('/', "StoreController@index")
                ->name('store');
            Route::post('/', "StoreController@add")
                ->name('store_add');
            Route::patch('/', "StoreController@edit")
                ->name('store_edit');
        });

        /**
         * Deal Management
         */
        Route::prefix('deal')->group(function () {
            Route::get('/view', "DealController@view")
                ->name('deal.view');

            Route::get('/report', "DealController@report")
                ->name('deal.reports');

            Route::get('/coupons', 'DealCouponController@index')
                ->name('deal_coupons');
            Route::post('/coupons', 'DealCouponController@add')
                ->name('deal_coupons_create');

            Route::match(['get', 'post'], '/redeem', "DealController@redeem")
                ->name('deal.redeem');

            /**
             * Basic Routes
             */
            Route::get('/create', 'DealController@create')
                ->name('deal_create');
            Route::get('/edit', 'DealController@edit_deal')
                ->name('deal_edit_page');

            Route::get('/', "DealController@index")
                ->name('deal');
            Route::post('/', "DealController@add")
                ->name('deal_add');
            Route::patch('/', "DealController@edit")
                ->name('deal_edit');

            /**
             * Expired
             */
            Route::post('/expired/handel', "DealExpiryController@handle")
                ->name("deal.expired.handle");
            Route::get('/expired', "DealExpiryController@index")
                ->name('deal.expired.get');

            Route::post('/endangered/handel', 'DealExpiryController@handleEndangered')
                ->name('deal.endangered.handle');

            Route::get('/endangered', 'DealExpiryController@endangered')
                ->name('deal.endangered');


        });

        /**
         * Bonus Coupon Management
         */

        Route::resource('bonusdeal', 'BonusDealController');
        Route::get('bonusdealcode/{id}', 'BonusDealCodeController@index');
        Route::resource('bonusdealcode', 'BonusDealCodeController');


        /**
         * User Management
         */
        Route::prefix('user')->group(function () {
            Route::get('/', "UserController@index")
                ->name('user');
            Route::post('/', "UserController@add")
                ->name('user_add');
            Route::patch('/', "UserController@edit")
                ->name('user_edit');

            Route::patch('/password', "UserController@password_change")
                ->name("password_change");

            Route::post('/password/reset', "UserController@password_reset")
                ->name("user.password.reset");
        });

        /**
         * Client Management
         */
        Route::prefix('client')->group(function () {
            Route::get('/{client}/', "ClientController@booklet")
                ->where('client', '[0-9]+')
                ->name('client_booklets');

            Route::get('/referrals', "ClientController@referrals")
                ->name('client_referrals');

            Route::get('/', "ClientController@index")
                ->name('client');
            Route::post('/', "ClientController@add")
                ->name("client_add");
            Route::patch('/', "ClientController@edit")
                ->name('client_edit');

        });

        /**
         * Customer Additional Routes
         */
        Route::get('/clients/history', 'ClientController@history')
            ->name('client.history');

        Route::prefix('/client')->group(function () {
            Route::match(['get', 'post'], '/deal', "ClientController@avail")
                ->name("client.avail.deal");
        });

        Route::post('/send/sms', "ClientController@sendSMS")
            ->name("client.send.sms");

        /**
         * Default Values for site admins
         */
        Route::prefix('default/values')->group(function () {
            Route::get('/', "HomeController@defaults")
                ->name('value');
            Route::post('/', "HomeController@defaults_add")
                ->name('value_add');
            Route::patch('/', "HomeController@defaults_edit")
                ->name('value_edit');
        });

        /**
         * Advertisements
         */
        Route::prefix('advertisments')->group(function () {
            Route::get('/', 'AdvertismentController@index')->name('advertisment');
            Route::post('/', 'AdvertismentController@add')->name('advertisment_add');
        });


        /**
         * Reporting
         */
        Route::middleware(['admin'])->prefix('/report')->group(function () {
            Route::match(['get', 'post'], '/booklet_reports', 'ReportController@bookletReports')->name('booklet_reports');
            Route::any('/ccTransactions', 'DataTablesServerController@getIndex')->name('ccTransactions');

        });

        /**
         * Report exports to excel data
         */
        Route::middleware(['admin'])->prefix('/download')->group(function () {
            Route::post('/ccData', 'DataExportController@ccData')->name('export.ccData');
            Route::post('/clientData', 'DataExportController@clientSQLData')->name('export.clientData');
            Route::post('/salesRegisterationsData', 'DataExportController@salesRegisterationsData')->name('export.salesRegisterationsData');
            Route::post('/storeOrderData', 'DataExportController@storeOrderData')->name('export.storeOrderData');
            Route::post('/storeDealData', 'DataExportController@storeDealData')->name('export.storeDealData');
            Route::post('/bookletActivationData', 'DataExportController@bookletActivationSQLData')->name('export.bookletActivationData');
            Route::post('/deviceRegData', 'DataExportController@deviceRegData')->name('export.deviceRegData');

            Route::get('/', 'DataExportController@index')->name('export.index');
        });

        /**
         * Server Side Data tables
         */
        Route::prefix('/datatables')->group(function () {
            Route::get('/ccData', 'DataTablesServerController@ccData')->name('datatables.ccData');
            Route::prefix('/clientData')->group(function () {
                Route::get('/{client}/bookletpurchaseData', 'DataTablesServerController@clientBookletPurchaseData')->name('datatables.client.bookletpurchases');
                Route::get('/{client}/referralData', 'DataTablesServerController@clientReferralData')->name('datatables.client.referralData');
                Route::get('/', 'DataTablesServerController@clientData')->name('datatables.clientData');
            });
            Route::get('/storeData', 'DataTablesServerController@storeData')->name('datatables.storeData');
            Route::get('/{booklet}/codeData', 'DataTablesServerController@bookletCodeData')->name('datatables.bookletCodeData');
            Route::get('/{deal}/couponData', 'DataTablesServerController@dealCouponData')->name('datatables.dealCouponData');
            Route::get('/bookletPurchaseData', 'DataTablesServerController@bookletPurchaseData')->name('datatables.bookletPurchaseData');
            Route::get('store/{store}/ReportData', 'DataTablesServerController@storeReportData')->name('datatables.storeReportData');
            Route::get('/deal/endangered', 'DataTablesServerController@dealEndangered')->name('datatables.deal.endangered');
            Route::get('/dealData', 'DataTablesServerController@dealData')->name('datatables.dealData');
            Route::get('deal/{deal}/ReportData', 'DataTablesServerController@dealReportData')->name('datatables.dealReportData');

            Route::get('/bonusDeal/{bonusDeal}/couponData', "DataTablesServerController@bonusDealCouponsData")->name('datatables.bonusDeal.lakshay');
        });

        Route::get('/', function () {
            return redirect()->route('dashboard');
        });
    });

    Route::prefix('ola')->group(function(){
        Route::get('/tokens', 'ApiOlaController@olaindex');
    });

