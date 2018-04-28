<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    //
    public function index(){
        $array = ['names' => ['programmer' => 'Joe1']];

        array_set($array, 'names.editor', 'Taylor1');
        var_dump($array);die;
        echo 'test123';
    }
    public function test(){
        echo 'test';
    }
}


