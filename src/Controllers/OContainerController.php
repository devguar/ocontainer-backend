<?php

namespace Devguar\OContainer\Controllers;

use App\Http\Controllers\Controller as OriginalController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

abstract class OContainerController extends OriginalController
{
    public function messageSuccessURL($message, $url){
        $this->messageSuccess('<a href="'.$url.'" class="mask-tooltip" title="Visualizar">'.$message.'</a>');
    }

    public function messageSuccess($message){
        Session::flash('message-success', $message);
    }

    public function messageInfo($message){
        Session::flash('message-info', $message);
    }

    public function messageDanger($message){
        Session::flash('message-danger', $message);
    }

    public function user(){
        return Auth::user();
    }

    public static function pathMethod($method = 'index')
    {
        $controller = static::class;
        $controller = str_replace('App\Http\Controllers\\','',$controller);
        $controller = $controller.'@'.$method;
        return $controller;
    }

    public static function urlMethod($method = 'index',$object = null)
    {
        $path = static::pathMethod($method);
        $url = \URL::action($path, $object);
        return $url;
    }
}