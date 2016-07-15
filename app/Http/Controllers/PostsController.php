<?php

namespace App\Http\Controllers;

use App;
use App\Category;
use App\Http\Requests\PostRequest;
use App\Post;
use Illuminate\Http\Request;

class PostsController extends AdminController
{
    public $categories;

    /**
     * PostsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->categories = array('' => 'Choose category');

        $categories = Category::with('translations')->get();
        
        foreach ($categories as $cate) {
            if ($cate->subCategories->count() == 0) {
                $this->categories[$cate->id] = $cate->name;
            }
        }
    }


    public function index(Request $request)
    {

        $searchPost = '';
        $categoryId = '';

        $posts = Post::with('translations')->latest('updated_at');

        if ($request->input('q')) {
            $searchPost = urldecode($request->input('q'));
            $posts = $posts->whereTranslationLike('title', '%'. $searchPost. '%');
        }

        if ($request->input('cat')) {
            $categoryId = $request->input('cat');
            $category = Category::find($categoryId);
            $posts = ($category->subCategories->count() == 0) ? $posts->where('category_id', '=', $categoryId) : $posts->whereIn('category_id', $category->subCategories->lists('id')->all());
        }

        $posts = $posts->paginate(env('ITEM_PER_PAGE'));

        return view('admin.post.index', compact('posts', 'searchPost', 'categoryId'));
    }

    public function create()
    {       
        $categories = $this->categories;
        return view('admin.post.form', compact('categories'));
    }

    public function store(PostRequest $request)
    {
        $data = $request->all();
        
        $data['image'] =  ($request->file('image') && $request->file('image')->isValid()) ? $this->saveImage($request->file('image')) : '';

        $data['status'] = ($request->input('status') == 'on') ? true : false;

        $post = Post::create($data);

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $post->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        $post->save();
     
        flash('Create post success!', 'success');
        return redirect('admin/posts');
    }

    public function edit($id)
    {
        $post = Post::with('translations')->find($id);
        $categories = $this->categories;

        return view('admin.post.form', compact('post', 'categories'));
    }

    public function update($id, PostRequest $request)
    {
        $data = $request->all();
        $post = Post::find($id);

        if ($request->file('image') && $request->file('image')->isValid()) {
            $post->image = $this->saveImage($request->file('image'), $post->image);
        }
        
        $post->category_id = $data['category_id'];
        $post->video_url = $data['video_url'];

        foreach (config('const.lang') as $lang) {
            foreach (['title', 'desc', 'content'] as $field) {
                $post->translateOrNew($lang)->{$field} = $data[$field. '_' . $lang];
            }
        }

        $post->status = ($request->input('status') == 'on') ? true : false;

        $post->save();

        flash('Update post success!', 'success');
        return redirect('admin/posts');
    }

    public function destroy($id)
    {
       $post = Post::find($id);
        if (file_exists(public_path('files/' . $post->image))) {
            @unlink(public_path('files/' . $post->image));
        }
        $post->delete();
        flash('Success deleted post!');
        return redirect('admin/posts');
    }

}
