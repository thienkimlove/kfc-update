<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'desc', 'content'];
    protected $fillable = ['title', 'desc', 'content', 'image', 'status', 'catalog_id'];
    
    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }
}
