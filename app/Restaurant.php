<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'desc', 'content'];
    protected $fillable = ['title', 'desc', 'content', 'image', 'status', 'address', 'city', 'postal_code', 'country', 'phone', 'open', 'close'];
   
}
