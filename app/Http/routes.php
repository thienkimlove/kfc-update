<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('restricted', function(){
    return view('errors.restricted');
});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

#Admin Routes.

Route::group(['middleware' => 'web'], function () {
    Route::auth();

    Route::get('/admin', 'HomeController@index');
    Route::resource('admin/posts', 'PostsController');
    Route::resource('admin/categories', 'CategoriesController');
    Route::resource('admin/catalogs', 'CatalogsController');
    Route::resource('admin/products', 'ProductsController');
    Route::resource('admin/promotions', 'PromotionsController');
    Route::resource('admin/settings', 'SettingsController');
    Route::resource('admin/banners', 'BannersController');
    Route::resource('admin/restaurants', 'RestaurantsController');

    Route::post('admin/lang', function(\Illuminate\Http\Request $request){
        if ($request->input('lang')) {
            session()->put('language', $request->input('lang'));
        }
        return response()->json(['lang' => $request->input('lang')]);
    });
});

#Frontend Routes

Route::get('/', 'FrontendController@index');
Route::get('category/{value}', 'FrontendController@category');
Route::get('restaurant', 'FrontendController@restaurant');
Route::get('restaurant-list', 'FrontendController@restaurantList');
Route::get('promotion', 'FrontendController@promotion');


