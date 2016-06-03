<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestaurantTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'desc', 'content'];
}
