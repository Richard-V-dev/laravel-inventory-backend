<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function list(){
        try{
            $users = User::with(['person','roles'])->get();
            return response()->json($users,200);
        } catch(\Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }
        
    }
    public function save(Request $request){
        $request->validate([
            "name" => "required",
            "email" => "email|required|unique:users",
            "password" => "required",
        ]);
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            return response()->json(['message'=>"User registered"],201);
        } catch(\Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }   
    }
    public function showOne($id){
        try{
            $user = User::find($id);
            return response()->json($user,200);
        } catch(\Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }    
    }
    public function edit(Request $request, $id){
        try{
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            if(!$request->password){
                $user->password = $request->password;
            }
            $user->update();
            return response()->json(['message'=>"User updated!"],201);
        } catch(\Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }    
    }
    public function delete($id){
        try{
            $user = User::find($id);
            $user->delete();
            return response()->json(['message'=>"User deleted!"],200);
        } catch(\Exception $e){
            return response()->json(["message"=>$e->getMessage()],500);
        }
    }
}
