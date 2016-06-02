<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'desc', 'content'];
    protected $fillable = ['title', 'desc', 'content', 'status', 'image'];
}
