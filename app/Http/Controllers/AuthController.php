<?php

namespace App\Http\Controllers;

use GuzzleHttp\Middleware;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function logout(){

        session()->flush();
        return  redirect(route('newHome'));
    }

}
