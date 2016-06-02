<?php

namespace App\Http\Controllers;


use App\Banner;
use App\Setting;
use App\Http\Requests;


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
                    'meta_keywords' => !empty($meta['keywords']) ? $meta['keywords'] : $settings['META_POST_KEYWORDS'],
                    'meta_url' => url($mainContent->slug . '.html'),
                    'meta_image' => url('img/cache/120x120/'.$mainContent->image) 
                ];
                break;
            case 'category' :
                return [
                    'meta_title' => $meta['title'],
                    'meta_desc' => $meta['desc'],
                    'meta_keywords' => !empty($meta['keywords']) ? $meta['keywords'] : $settings['META_CATEGORY_KEYWORDS'],
                    'meta_url' => url($mainContent->slug),
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
}
