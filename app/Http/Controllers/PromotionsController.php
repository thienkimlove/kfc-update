<?php

namespace App\Http\Controllers;

use App;;
use App\Http\Requests\PromotionRequest;
use App\Promotion;
use Illuminate\Http\Request;

class PromotionsController extends AdminController
{

    public function index(Request $request)
    {

        $searchPromotion = '';

        $promotions = Promotion::with('translations')->latest('updated_at');

        if ($request->input('q')) {
            $searchPromotion = urldecode($request->input('q'));
            $promotions = $promotions->whereTranslationLike('title', '%'. $searchPromotion. '%');
        }

        $promotions = $promotions->paginate(env('ITEM_PER_PAGE'));

        return view('admin.promotion.index', compact('promotions', 'searchPromotion'));
    }

    public function create()
    {               
        return view('admin.promotion.form');
    }

    public function store(PromotionRequest $request)
    {
        $data = $request->all();
        
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';

        $data['status'] = ($request->input('status') == 'on') ? true : false;

        $promotion = Promotion::create($data);

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $promotion->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        $promotion->save();
     
        flash('Create promotion success!', 'success');
        return redirect('admin/promotions');
    }

    public function edit($id)
    {
        $promotion = Promotion::with('translations')->find($id);       

        return view('admin.promotion.form', compact('promotion'));
    }

    public function update($id, PromotionRequest $request)
    {
        $data = $request->all();
        $promotion = Promotion::find($id);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $promotion->image = $this->saveImage($request->file('image'), $promotion->image);
        }

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $promotion->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        $promotion->status = ($request->input('status') == 'on') ? true : false;

        $promotion->save();

        flash('Update promotion success!', 'success');
        return redirect('admin/promotions');
    }

    public function destroy($id)
    {
        $promotion = Promotion::find($id);
        if (file_exists(public_path('files/' . $promotion->image))) {
            @unlink(public_path('files/' . $promotion->image));
        }
        $promotion->delete();
        flash('Success deleted promotion!');
        return redirect('admin/promotions');
    }

}
