<?php

namespace App\Library;
use Illuminate\Support\Carbon;

class MyFunc
{
  public static function time_format($date)
  {
    $date = Carbon::createFromTimeString($date);
    $str_time = $date->format('H:i:s');
    return $str_time;
  }

  public static function date_format($date)
  {
    // $date = Carbon::createFromTimeString($date);
    $date = new Carbon($date);
    $str_date = $date->format('Y年n月j日');
    return $str_date;
  }
  
}