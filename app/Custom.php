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

    public static function getLonLatFromAddress($restaurant)
    {
        $res = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode(self::map($restaurant)) .'&sensor=false');
        $test = json_decode($res)->results[0]->geometry->location;

        return [$test->lat, $test->lng];
    }
}