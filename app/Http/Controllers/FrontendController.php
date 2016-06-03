<?php

namespace App\Http\Controllers;


use App\Banner;
use App\Category;
use App\Custom;
use App\Promotion;
use App\Restaurant;
use App\Setting;
use App\Http\Requests;
use Illuminate\Http\Request;


class FrontendController extends Controller
{
    public function __construct()
    {
        if (session()->has('language')) {
            app()->setLocale(session()->get('language'));
        }
    }

    protected function generateMeta($case = null, $meta = [], $mainContent = null)
    {
        $defaultLogo = url(env('LOGO_URL'));
        $settings = Setting::lists('value', 'name')->all();
        switch ($case) {
            default :
                return [
                    'meta_title' => $settings['META_INDEX_TITLE'],
                    'meta_desc' => $settings['META_INDEX_DESC'],
                    'meta_keywords' => $settings['META_INDEX_KEYWORDS'],
                    'meta_url' => url('/'),
                    'meta_image' => $defaultLogo
                ];
                break;

            case 'post' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => $settings['META_POST_KEYWORDS'],
                    'meta_url' => url('post', Custom::slug($mainContent->title)),
                    'meta_image' => url('img/cache/120x120/'.$mainContent->image) 
                ];
                break;

            case 'product' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => $settings['META_PRODUCT_KEYWORDS'],
                    'meta_url' => url('product', Custom::slug($mainContent->title)),
                    'meta_image' => url('img/cache/120x120/'.$mainContent->image)
                ];
                break;

            case 'promotion' :
                return [
                    'meta_title' => $settings['META_PROMOTION_TITLE'],
                    'meta_desc' => $settings['META_PROMOTION_DESC'],
                    'meta_keywords' => $settings['META_PROMOTION_KEYWORDS'],
                    'meta_url' => url('promotion'),
                    'meta_image' => $defaultLogo
                ];
                break;

            case 'restaurant' :
                return [
                    'meta_title' => $settings['META_RESTAURANT_TITLE'],
                    'meta_desc' => $settings['META_RESTAURANT_DESC'],
                    'meta_keywords' => $settings['META_RESTAURANT_KEYWORDS'],
                    'meta_url' => url('restaurant'),
                    'meta_image' => $defaultLogo
                ];
                break;
            
            case 'category' :
                return [
                    'meta_title' => $mainContent->name,
                    'meta_desc' => $settings['META_CATEGORY_DESC'],
                    'meta_keywords' => $settings['META_CATEGORY_KEYWORDS'],
                    'meta_url' => url('category', Custom::slug($mainContent->name. ' '.$mainContent->id)),
                    'meta_image' => $defaultLogo
                ];
                break;

            case 'catalog' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => $settings['META_CATALOG_KEYWORDS'],
                    'meta_url' => url('catalog', Custom::slug($mainContent->name)),
                    'meta_image' => $defaultLogo
                ];
                break;
        }

    }

    public function index()
    {
        $page = 'index';

        $topBanners = Banner::where('position', 'index_top')->get();
        $bottomBanners = Banner::where('position', 'index_bottom')->get();

        return view('frontend.index', compact('page', 'topBanners', 'bottomBanners'))->with($this->generateMeta());
    }
    
    public function restaurant(Request $request)
    {
        $page = 'restaurant';
        
        $location = '';
        
        if ($request->input('q')) {
            $location = $request->input('q');
        }
        return view('frontend.restaurant', compact('page', 'location'))->with($this->generateMeta('restaurant'));
    }

    public function restaurantList()
    {
        $page = 'restaurant_list';
        $restaurants = Restaurant::with('translations')->get();
        return view('frontend.restaurant_list', compact('restaurants', 'page'))->with($this->generateMeta('restaurant'));
    }

    public function promotion()
    {
        $page = 'promotion';
        $promotions = Promotion::with('translations')->get();
        return view('frontend.promotion', compact('promotions', 'page'))->with($this->generateMeta('promotion'));
    }

    public function category($value)
    {
        preg_match_all("/^(.*)-(\\d+)$/", $value, $matches);

        dd($matches);

        if (isset($matches[2][0])) {
            $page = 'category';
            $category = Category::with('translations')->find($matches[1]);

            if ($category->display_as_post) {
                $view = 'frontend.details';

            } else {
                $view = 'frontend.category';
            }

            return view($view, compact('category', 'page'))->with($this->generateMeta('category', $category));
        }
    }
}
