<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class Authcontroller extends Controller
{
    

    public function register(Request $request) {
        try {
            $validateUser = Validator::make($request->all() , [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users|max:255',
                'password' => 'required|string|min:8|max:255',
            ]);


            if($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ],401);
            };



            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => hash::make($request->password)
            ]);


            return response()->json([
                
                'status' => true,
                'message' => 'User registered successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        }
        catch(\Exception $e) {
            return response()->json(['message' => 'Failed to register user'], 500);
        }
    }


    public function login(Request $request) {

        try {


            $validatorUser = Validator::make($request->all() , [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validatorUser->fails()) {
                return response()->json([
                    'status' => false , 
                    'message' => 'Validation error',
                    'errors' => $validatorUser->errors()
                ],401);
            }


            if(!Auth::attempt($request->only(['email' , 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & password Dont match',
                ],401);
            }


            $user = User::where('email' , $request->email)->first();
            $usercount = User::where('email' , $request->email)->count();

            if($usercount < 0) {
                    return response()->json([
                        'status' => false,
                        'message' => 'User doenst exist at all',
                    ],401);
            }

            else {

                return response()->json([
                    'status' => true,
                    'message' => "User Logged In Succefully",
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ],200);
            }
        }
        catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ],500);
        }


        


    }


}
