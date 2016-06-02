<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Http\Requests\BannerRequest;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BannersController extends AdminController
{
    public function index()
    {
        $banners = Banner::latest()->paginate(env('ITEM_PER_PAGE'));
        return view('admin.banner.index', compact('banners'));
    }

    public function create()
    {        
        return view('admin.banner.form');
    }

    public function store(BannerRequest $request)
    {
        $data = $request->all();
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';
        $data['status'] = ($request->input('status') == 'on') ? true : false;
        Banner::create($data);

        flash('Create banner success!', 'success');
        return redirect('admin/banners');
    }


    /**
     * display form for edit category
     * @param $id
     * @return $this
     */
    public function edit($id)
    {       
        $banner = Banner::find($id);
        return view('admin.banner.form', compact('banner'));
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, BannerRequest $request)
    {
        $banner = Banner::find($id);

        $data = $request->all();

        $data['status'] = ($request->input('status') == 'on') ? true : false;
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';

        $banner->update($data);

        flash('Update banner success!', 'success');
        return redirect('admin/banners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $banner = Banner::find($id);
        if (file_exists(public_path('files/' . $banner->image))) {
            @unlink(public_path('files/' . $banner->image));
        }
        $banner->delete();
        flash('Success deleted banner!');
        return redirect('admin/banners');
    }

}
