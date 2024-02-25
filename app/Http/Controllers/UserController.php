<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,Address};

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $users=User::with('addresses')->latest()->get();
            return view('admin.users.index',compact('users'));
        } catch (\Throwable $th) {
            return back()->with(['status'=>'error','message'=>$th->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('admin.users.create');
        } catch (\Throwable $th) {
            return back()->with(['status'=>'error','message'=>$th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
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
            return back()->with(['status'=>'success','message'=>'User created successfully']);
        } catch (\Throwable $th) {
            return back()->with(['status'=>'error','message'=>$th->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $user=User::where('id',$id)->with('addresses')->latest()->first();
            return view('admin.users.userDetail',compact('user'));
        } catch (\Throwable $th) {
            return back()->with(['status'=>'error','message'=>$th->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $user=User::where('id',$id)->with('addresses')->latest()->first();
            return view('admin.users.edit',compact('user'));
        } catch (\Throwable $th) {
            return back()->with(['status'=>'error','message'=>$th->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
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
            return back()->with(['status'=>'success','message'=>'User updated successfully']);
        } catch (\Throwable $th) {
            return back()->with(['status'=>'error','message'=>$th->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            User::where('id',$id)->delete();
            return back()->with(['status'=>'success','message'=>'Data deleted successfully']);
        } catch (\Throwable $th) {
            return back()->with(['status'=>'error','message'=>$th->getMessage()]);
        }
    }
}
