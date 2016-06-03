<?php


namespace App;


use Illuminate\Support\Str;

class Custom
{
   public static function slug($content)
   {      
       return Str::slug($content);
   }
    
   public static function map($restaurant)
   {
       return $restaurant->address.','.$restaurant->city.','.$restaurant->postal_code.','.$restaurant->country;
   }
}