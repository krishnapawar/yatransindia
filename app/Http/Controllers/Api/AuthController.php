<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email:rfc,dns|max:250|unique:users,email',
                'password' => 'required|string|min:8|confirmed'
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);
            }
    
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
    
            $data['token'] = $user->createToken($request->email)->plainTextToken;
            $data['user'] = $user;
    
            return response()->json([
                'status' => true,
                'message' => 'User is created successfully.',
                'data' => $data,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    }
    public function login(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required|string|email',
                'password' => 'required|string'
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);  
            }
    
            $user = User::where('email', $request->email)->first();
    
            if(!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid credentials'
                    ], 401);
            }
    
            $data['token'] = $user->createToken($request->email)->plainTextToken;
            $data['user'] = $user;
    
            return response()->json([
                'status' => true,
                'message' => 'User is logged in successfully.',
                'data' => $data,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    } 

    public function logout(Request $request)
    {
        try {
            auth()->user()->tokens()->delete();
            return response()->json([
                'status' => true,
                'message' => 'User is logged out successfully'
                ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    } 
}
