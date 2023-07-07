<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $users = User::orderBy('id', 'DESC')->get();
        return response()->json([
            'results'=>$users
        ],200);
    }
    public function show($id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message'=>"User Not Found."
            ],404);
        }
        return response()->json([
            'results'=>$user
        ],200);
    }
    public function store(UserStoreRequest $request){
        try {
            User::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,
            ]);
            return response()->json([
                'message'=>"User successfully created."
            ],200); 
        } catch (\Exception $e) {
            return response()->json([
                'message'=>"Something wrnt really wrong!"
            ],500);
        }
    }
    public function update(UserStoreRequest $request,$id){
        try {
            // find user
            $user = User::find($id);
            if(!$user){
                return response()->json([
                    'message'=>"User Not Found."
                ],404);
            }
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            // update user
            $user->save();
            return response()->json([
                'message'=>"User successfully updated."
            ],200); 
        } catch (\Exception $e) {
            return response()->json([
                'message'=>"Something wrnt really wrong!"
            ],500);
        }
    }

    public function delete($id){
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message'=>"User Not Found."
            ],404);
        }
        $user->delete();
        return response()->json([
            'message'=>"User successfully deleted."
        ],200);
    }

}
