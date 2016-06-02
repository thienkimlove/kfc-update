<?php

namespace App\Http\Controllers;

use App;
use App\Catalog;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductsController extends AdminController
{
    public $catalogs;

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->catalogs = array('' => 'Choose catalog');

        $catalogs = Catalog::with('translations')->get();
        
        foreach ($catalogs as $cate) {
            $this->catalogs[$cate->id] = $cate->name;
        }
    }


    public function index(Request $request)
    {

        $searchProduct= '';
        $catalogId = '';

        $products = Product::with('translations')->latest('updated_at');

        if ($request->input('q')) {
            $searchProduct = urldecode($request->input('q'));
            $products = $products->whereTranslationLike('title', '%'. $searchProduct. '%');
        }

        if ($request->input('cat')) {
            $catalogId = $request->input('cat');
            $products = $products->where('catalog_id', '=', $catalogId);
        }

        $products = $products->paginate(env('ITEM_PER_PAGE'));

        return view('admin.product.index', compact('products', 'searchProduct', 'catalogId'));
    }

    public function create()
    {       
        $catalogs = $this->catalogs;
        return view('admin.product.form', compact('catalogs'));
    }

    public function store(ProductRequest $request)
    {
        $data = $request->all();
        
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';

        $data['status'] = ($request->input('status') == 'on') ? true : false;

        $product = Product::create($data);

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $product->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        $product->save();
     
        flash('Create product success!', 'success');
        return redirect('admin/products');
    }

    public function edit($id)
    {
        $product = Product::with('translations')->find($id);
        $catalogs = $this->catalogs;

        return view('admin.product.form', compact('product', 'catalogs'));
    }

    public function update($id, ProductRequest $request)
    {
        $data = $request->all();
        $product = Product::find($id);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $product->image = $this->saveImage($request->file('image'), $product->image);
        }

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $product->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        $product->catalog_id = $data['catalog_id'];

        $product->status = ($request->input('status') == 'on') ? true : false;

        $product->save();

        flash('Update product success!', 'success');
        return redirect('admin/products');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        if (file_exists(public_path('files/' . $product->image))) {
            @unlink(public_path('files/' . $product->image));
        }
        $product->delete();
        flash('Success deleted product!');
        return redirect('admin/products');
    }

}
