<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username'      => 'required|unique:users',
                'email'     => 'required|email|unique:users',
                'password'  => 'required|min:4'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }


            $user = new User();
            $user->username = $request->username;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->save();

            if($user) {
                return response()->json(['response_code'=>200,'response_status'=>"OK",'data'=>[]], 200);
            }

            return response()->json(['response_code'=>409,'response_status'=>"CONFLICT",'data'=>[]], 409);
        } catch (\Throwable $th) {
            return response()->json(['response_code'=>500,'response_status'=>"INTERNAL SERVER ERROR",'data'=>$th->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username'  => 'required',
                'password'  => 'required|min:4'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $credentials = $request->only('username', 'password');

            if(!$token = auth()->guard('api')->attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email atau Password Anda salah'
                ], 401);
            }
            return response()->json(['response_code'=>200,'response_status'=>"OK",'data'=>[
                'user'    => auth()->guard('api')->user(),
                'token'   => $token
            ]], 200);
        } catch (\Throwable $th) {
            return response()->json(['response_code'=>500,'response_status'=>"INTERNAL SERVER ERROR",'data'=>$th->getMessage()], 500);
        }
    }
}
