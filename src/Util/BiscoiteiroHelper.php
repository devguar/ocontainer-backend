<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 27/11/17
 * Time: 20:27
 */

namespace Devguar\OContainer\Util;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class BiscoiteiroHelper
{

    private static function makeCookeName($cookieItem){
        if (\Auth::user()){
            $cookieItem = str_replace('empresa_id',\Auth::user()->empresa_id,$cookieItem);
            $cookieItem = str_replace('user_id',\Auth::user()->id,$cookieItem);
        }

        return $cookieItem;
    }

    public static function setById($cookieItem, $id, $value, $minutes = 720){
        self::set($cookieItem.'_'.$id, $value, $minutes);
    }

    public static function set($cookieItem, $value, $minutes = 720){//12 horas de cache
        $cookieItem = self::makeCookeName($cookieItem);
        $expiresAt = Carbon::now()->addMinutes($minutes);
        Cache::put($cookieItem, $value, $expiresAt);
    }

    public static function hasById($cookieItem, $id){
        return self::has($cookieItem.'_'.$id);
    }

    public static function has($cookieItem)
    {
        $cookieItem = self::makeCookeName($cookieItem);

        if (Cache::has($cookieItem)) {
            return true;
        }

        return false;
    }

    public static function getById($cookieItem, $id){
        return self::get($cookieItem.'_'.$id);
    }

    public static function get($cookieItem){
        $cookieItem = self::makeCookeName($cookieItem);

        if (Cache::has($cookieItem)){
            $value = Cache::get($cookieItem);
            return $value;
        }

        return null;
    }

    public static function destroy($cookieItem){
        $cookieItem = self::makeCookeName($cookieItem);
        Cache::pull($cookieItem);
    }

    public static function destroyById($cookieItem, $id){
        self::destroy($cookieItem.'_'.$id);
    }

}