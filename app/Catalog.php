<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Catalog extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['name', 'status'];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
