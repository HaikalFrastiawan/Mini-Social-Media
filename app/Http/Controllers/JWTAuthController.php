<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\CssSelector\Node\FunctionNode;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;



class JWTAuthController extends Controller
{
    //Hanlde user registration
    public function register(Request $request)
    {
        $Validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        
        if  ($Validator->fails()) {
            return response()->json($Validator->errors(), 400);
        }

        //jika validasi lolos, buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->get('password')),
        ]); 

        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user', 'token'), 201);
    }


    //Handle user login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Invalid Credentials'], 401);
        }
        return response()->json(compact('token'));  

        
        
    }
}
