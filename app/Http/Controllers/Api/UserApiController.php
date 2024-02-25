<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{User,Address};
use Validator;

class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users=User::with('addresses')->latest()->get();
            return response()->json([
                'status' => true,
                'data'=>$users
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeUserInfo(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users',
                'phone' => 'required|string|min:10|max:20',
                'gender' => 'required|string|in:Male,Female,Other',
                'role' => 'required|string|in:Admin,User',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'addresses.*.address_line' => 'required|string',
                'addresses.*.country' => 'required|string',
                'addresses.*.city' => 'required|string',
                'addresses.*.state' => 'required|string',
                'addresses.*.zip_code' => 'required|string',
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);
            }
    
            $user = new User($request->except('addresses'));
            $user->save();
    
            // Process addresses
            foreach ($request->input('addresses') as $addressData) {
                $address = new Address($addressData);
                $user->addresses()->save($address);
            }
    
            if ($request->hasFile('profile_picture')) {
                $fileName = uniqid() . '_' . time() . '_.' . $request->profile_picture->extension();
                $imagePath = $request->profile_picture->storeAs('public/profile_pictures', $fileName);
    
                $user->profile_picture = "storage/profile_pictures/" . $fileName;
            }
            
            $user->save();
            return response()->json([
                'status' => true,
                'message'=>'User created successfully'
            ],201);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'id' => 'required'
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);
            }

            $user=User::where('id',$id)->with('addresses')->latest()->first();
            return response()->json([
                'status' => true,
                'data'=>$user
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUserInfo(Request $request, string $id)
    {
        try {
            $validate = Validator::make($request->all(),[
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|min:10|max:20',
                'gender' => 'required|string|in:Male,Female,Other',
                'role' => 'required|string|in:Admin,User',
                'addresses.*.address_line' => 'required|string',
                'addresses.*.country' => 'required|string',
                'addresses.*.city' => 'required|string',
                'addresses.*.state' => 'required|string',
                'addresses.*.zip_code' => 'required|string',
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);
            }
    
            $user = User::where('id',$id)->update($request->except('addresses','_token','_method','profile_picture'));
            // Process addresses
            Address::where('user_id',$id)->delete();
            foreach ($request->input('addresses')??[] as $addressData) {
                $address = new Address($addressData);
                $address->user_id=$id;
                $address->save();
            }
    
            if ($request->hasFile('profile_picture')) {
                $fileName = uniqid() . '_' . time() . '_.' . $request->profile_picture->extension();
                $imagePath = $request->profile_picture->storeAs('public/profile_pictures', $fileName);
    
                User::where('id',$id)->update(["profile_picture" => "storage/profile_pictures/" . $fileName]);
            }
            return response()->json([
                'status' => true,
                'message'=>'User updated successfully'
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'id' => 'required'
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error!',
                    'data' => $validate->errors(),
                ], 403);
            }

            User::where('id',$id)->delete();
            return response()->json([
                'status' => true,
                'message'=>'Data deleted successfully'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message'=>$th->getMessage()
            ],500);
        }
    }
}
