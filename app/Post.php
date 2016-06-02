<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'desc', 'content'];

    protected $fillable = ['title', 'desc', 'content', 'status', 'image', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
