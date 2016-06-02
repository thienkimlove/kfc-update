<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PromotionTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'desc', 'content'];
}
