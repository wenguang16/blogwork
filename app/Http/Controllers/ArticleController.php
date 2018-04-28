<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function index(){
        $array = ['names' => ['programmer' => 'Joe']];

        array_set($array, 'names.editor', 'Taylor');
        var_dump($array);die;
        echo 'test';
    }
    public function test(){
        echo 'test';
    }
}


