<?php

namespace App\Providers;

use App\Catalog;
use App\Category;
use Illuminate\Support\ServiceProvider;

class ViewComposerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        view()->composer('frontend.menu', function ($view) {
            $headerCatalogs = Catalog::with('translations')->get();
            $headerCategories = Category::with('translations')->whereNull('parent_id')->get();
            $view->with('headerCatalogs', $headerCatalogs);
            $view->with('headerCategories',  $headerCategories);
        });

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
