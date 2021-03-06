<?php

namespace App\Http\Controllers;

use App;
use App\Http\Requests\RestaurantRequest;
use App\Restaurant;
use Illuminate\Http\Request;

class RestaurantsController extends AdminController
{
   
    public function index(Request $request)
    {

        $searchRestaurant = '';
      
        $restaurants = Restaurant::with('translations')->latest('updated_at');

        if ($request->input('q')) {
            $searchRestaurant = urldecode($request->input('q'));
            $restaurants = $restaurants->whereTranslationLike('title', '%'. $searchRestaurant. '%');
        }


        $restaurants = $restaurants->paginate(env('ITEM_PER_PAGE'));

        return view('admin.restaurant.index', compact('restaurants', 'searchRestaurant'));
    }

    public function create()
    {             
        return view('admin.restaurant.form');
    }

    /**
     * @param RestaurantRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(RestaurantRequest $request)
    {
        $data = $request->all();
        
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';

        $data['status'] = ($request->input('status') == 'on') ? true : false;

        $data['wifi'] = ($request->input('wifi') == 'on') ? true : false;
        $data['round_the_clock'] = ($request->input('round_the_clock') == 'on') ? true : false;
        $data['car_distribution'] = ($request->input('car_distribution') == 'on') ? true : false;
        $data['corporative'] = ($request->input('corporative') == 'on') ? true : false;
        $data['degustation'] = ($request->input('degustation') == 'on') ? true : false;
        $data['excursion'] = ($request->input('excursion') == 'on') ? true : false;
        $data['takeaway'] = ($request->input('takeaway') == 'on') ? true : false;
        $data['breakfast'] = ($request->input('breakfast') == 'on') ? true : false;
        $data['promo'] = ($request->input('promo') == 'on') ? true : false;

        $restaurant = Restaurant::create($data);

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $restaurant->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        list($restaurant->lat, $restaurant->lon) = App\Custom::getLonLatFromAddress($restaurant);

        $restaurant->save();
     
        flash('Create restaurant success!', 'success');
        return redirect('admin/restaurants');
    }

    public function edit($id)
    {
        $restaurant = Restaurant::with('translations')->find($id);      

        return view('admin.restaurant.form', compact('restaurant'));
    }

    public function update($id, RestaurantRequest $request)
    {
        $data = $request->all();
        
        $restaurant = Restaurant::find($id);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $restaurant->image = $this->saveImage($request->file('image'), $restaurant->image);
        }

        $restaurant->address = $data['address'];
        $restaurant->city = $data['city'];
        $restaurant->postal_code = $data['postal_code'];
        $restaurant->country = $data['country'];
        $restaurant->phone = $data['phone'];
        $restaurant->open = $data['open'];
        $restaurant->close = $data['close'];

        $restaurant->ext_phone = $data['ext_phone'];
        $restaurant->breakfast_time = $data['breakfast_time'];
        $restaurant->count_people_in_excursion = $data['count_people_in_excursion'];


        list($restaurant->lat, $restaurant->lon) = App\Custom::getLonLatFromAddress($restaurant);

        

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $restaurant->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        $restaurant->status = ($request->input('status') == 'on') ? true : false;

        $restaurant->wifi = ($request->input('wifi') == 'on') ? true : false;
        $restaurant->round_the_clock = ($request->input('round_the_clock') == 'on') ? true : false;
        $restaurant->car_distribution = ($request->input('car_distribution') == 'on') ? true : false;
        $restaurant->corporative = ($request->input('corporative') == 'on') ? true : false;
        $restaurant->degustation = ($request->input('degustation') == 'on') ? true : false;
        $restaurant->excursion = ($request->input('excursion') == 'on') ? true : false;
        $restaurant->takeaway = ($request->input('takeaway') == 'on') ? true : false;
        $restaurant->breakfast = ($request->input('breakfast') == 'on') ? true : false;
        $restaurant->promo = ($request->input('promo') == 'on') ? true : false;



        $restaurant->save();

        flash('Update restaurant success!', 'success');
        return redirect('admin/restaurants');
    }

    public function destroy($id)
    {
        $restaurant = Restaurant::find($id);
        if (file_exists(public_path('files/' . $restaurant->image))) {
            @unlink(public_path('files/' . $restaurant->image));
        }
        $restaurant->delete();
        flash('Success deleted restaurant!');
        return redirect('admin/restaurants');
    }

}
