<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalUsers = User::count();
        $newUsers = User::whereDate('created_at', today())->count();
        $newsCount = '0';

        return view('admin.home', compact('totalUsers', 'newUsers', 'newsCount'));
    }
    public function profile()
    {
        $user=auth()->user();
        return view('admin.users.userDetail',compact('user'));
    }
}
