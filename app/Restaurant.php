<?php

namespace App;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use Translatable;

    public $translatedAttributes = ['title', 'desc', 'content'];
    protected $fillable = [
        'title',
        'desc',
        'content',
        'image',
        'status',
        'address',
        'city',
        'postal_code',
        'country',
        'phone',
        'open',
        'close',
        'ext_phone',
        'wifi',
        'round_the_clock',
        'car_distribution',
        'corporative',
        'degustation',
        'excursion',
        'takeaway',
        'breakfast',
        'breakfast_time',
        'count_people_in_excursion',
        'count_people_in_degustation',
        'lat',
        'lon',
        'promo'
    ];
   
}
