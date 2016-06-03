<?php

namespace App;

use App;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Post;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'content'];
    protected $fillable = [
        'name',
        'content',
        'parent_id',
        'display_as_post'
    ];

    /**
     * parent of this category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Category', 'parent_id', 'id');
    }

    /**
     * sub of this category
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories()
    {
        return $this->hasMany('App\Category', 'parent_id', 'id');

    }

    public function posts()
    {
        return $this->hasMany(Post::class)->where('status', true)->orderBy('updated_at', 'desc');
    }

}
