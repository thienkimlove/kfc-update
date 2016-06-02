<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['name'];
}
