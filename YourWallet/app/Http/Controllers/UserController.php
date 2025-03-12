<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
// use Illuminate\Foundation\Auth\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use Illuminate\Foundation\Auth\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // try {

            $validation =   $request->validate([
                "name" => "required",
                "email" => "required",
                "password" => "required"
            ]);

            if (!$validation) {
                return response()->json(["message" => "Not woking"]);
            }

            // $data = $request->all();
            $validation['password'] = hash::make($validation['password']);

            // return $validation;


            $user = User::create($validation);
            $token =  $user->createToken('bank-app')->plainTextToken;

            $response = [
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 201);
        // } catch (Exception $e) {
        //     return ["error" => $e->getMessage()];
            
        // }
    }

    public function login (request $request){
        $request->validate ([
            'email' =>'required',
            'password'=>'required'
        ]);
        
        $user = User::where('email',$request->email)->first();

        if (!$user || !hash::check($request->password, $user->password)){
            return response([
                'message' => 'this user not match our records.'
            ],404);
        }
        $token = $user->createToken('my-app-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response,201);
    }
    public function logout()
    {
        auth()->user()->tokens()->delete();

        $response = [
            'message'=>'logged out',
        ];
        return response($response);
    }
}
