<?php namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests;

use App\Http\Requests\CategoryRequest;
use App\Post;


class CategoriesController extends AdminController
{
    public $parents;

    public function __construct()
    {
        parent::__construct();
        $this->parents = array('' => 'Choose parent category');

        $parents  =  Category::with('translations')->whereNull('parent_id')->get();

        foreach ($parents as $parent) {
            $this->parents[$parent->id] = $parent->name;
        }
    }

    public function index()
    {
        $categories = Category::with('translations')->paginate(env('ITEM_PER_PAGE'));
        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        $parents = $this->parents;
        return view('admin.category.form', compact('parents'));
    }

    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        $update = [];

        $update['parent_id'] = !empty($data['parent_id']) ?  $data['parent_id'] : null;
        $update['display_as_post'] = !empty($data['display_as_post']) ?  $data['display_as_post'] : null;


        $category = Category::create($update);

        foreach (config('const.lang') as $lang) {
            $category->translateOrNew($lang)->name = $data['name_'. $lang];
        }

        $category->save();

        flash('Create category success!', 'success');
        return redirect('admin/categories');
    }


    /**
     * display form for edit category
     * @param $id
     * @return $this
     */
    public function edit($id)
    {
        $parents = $this->parents;
        unset($parents[$id]);
        $category = Category::find($id);
        return view('admin.category.form', compact('parents', 'category'));
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, CategoryRequest $request)
    {
        $category = Category::find($id);
        $data = $request->all();

        foreach (config('const.lang') as $lang) {
            $category->translateOrNew($lang)->name = $data['name_'.$lang];
        }


        if (!empty($data['display_as_post'])) {
            $category->display_as_post = (int) $data['display_as_post'];
        }

        if (!empty($data['parent_id'])) {
            $category->parent_id = (int) $data['parent_id'];
        }

        $category->save();

        flash('Update category success!', 'success');
        return redirect('admin/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        Post::where('category_id', $category->id)->delete();
        $category->delete();

        flash('Success deleted category!');
        return redirect('admin/categories');
    }



}
