<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->validate([
            "email"=>"required|email",
            "password"=>"required"
        ]);
        if(!Auth::attempt($credentials)){
            return response()->json(["message"=>"Wrong credentials"]);
        }
        $token = $request->user()->createToken("Token Auth")->plainTextToken;
        return response()->json(["access_token"=>$token,"user"=>$request->user()]);
    }
    public function register(Request $request){
        $request->validate([
            "name"=>"required|string",
            "email"=>"required|email",
            "password"=>"required|same:cpassword"
        ]);
        $user= new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json(["message"=>"User successfully registered"]);
    }
    public function profile(Request $request){
        return response()->json($request->user());
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return response()->json(["message"=>"you've just loggeout"]);
    }
}
