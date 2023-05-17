<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name'=> 'required|min:2|max:100',
            'email'=> 'required|email|unique:users',
            'password'=> 'required|min:6|max:100',
            'confirm password'=> 'required|same:password',
        ]);



        return response()->json([
            'message'=> 'Registration'
        ]);

     
    }
}
