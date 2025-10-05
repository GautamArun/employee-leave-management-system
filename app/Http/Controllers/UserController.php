<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function login(Request $request){
        echo "a message";
    }

    public function register(Request $request){
        dd("hello");
    }
}
