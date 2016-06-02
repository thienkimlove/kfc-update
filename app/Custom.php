<?php


namespace App;


use Illuminate\Support\Str;

class Custom
{
   public static function slug($content)
   {      
       return Str::slug($content);
   }
}