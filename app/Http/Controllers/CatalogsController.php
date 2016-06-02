<?php namespace App\Http\Controllers;

use App\Catalog;
use App\Http\Requests;

use App\Http\Requests\CatalogRequest;



class CatalogsController extends AdminController
{   
    public function __construct()
    {
        parent::__construct();       
    }

    public function index()
    {       
        $catalogs = Catalog::with('translations')->paginate(10);
        return view('admin.catalog.index', compact('catalogs'));
    }

    public function create()
    {        
        return view('admin.catalog.form');
    }

    public function store(CatalogRequest $request)
    {
        $data = $request->all();

        $update = [];
        $update['status'] = ($request->input('status') == 'on') ? true : false;
        $catalog = Catalog::create($update);

        foreach (config('const.lang') as $lang) {
            $catalog->translateOrNew($lang)->name = $data['name_'. $lang];
        }

        $catalog->save();

        flash('Create catalog success!', 'success');
        return redirect('admin/catalogs');
    }


    /**
     * display form for edit category
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $catalog = Catalog::find($id);
        return view('admin.catalog.form', compact('catalog'));
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, CatalogRequest $request)
    {
        $catalog = Catalog::find($id);
        
        $data = $request->all();
        
        foreach (config('const.lang') as $lang) {
            $catalog->translateOrNew($lang)->name = $data['name_'.$lang];
        }

        $catalog->status = ($request->input('status') == 'on') ? true : false;
        $catalog->save();

        flash('Update catalog success!', 'success');
        return redirect('admin/catalogs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $catalog = Catalog::find($id);
        $catalog->delete();

        flash('Success deleted catalog!');
        return redirect('admin/catalogs');
    }



}
