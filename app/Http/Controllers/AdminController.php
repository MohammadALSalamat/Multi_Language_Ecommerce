<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Models\Admins;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function Login()
    {
        return view('admin.auth.login');
    }

    public function Enter_Dashboard(LoginRequest $request)
    {
        // validation made in  request folder
        $data = $request->all();

        // check if the user clicked on remember_me button
        $remember_me = $request->has('remember_me') ? true : false;
        $check_user = Admins::where(['email' => $data['email'], 'password' => md5($data["password"])])->count();
        if ($check_user == 1) {
            return view('admin.dashboard');
        } else {
            return redirect()->route('admin_login')->with('error', ' هناك خطا بالبيانات');
        }
    }

    public function Show_Dashboard()
    {
        # show the dashboard
        return view('admin.dashboard');
    }
}
