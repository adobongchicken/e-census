<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function superAdminLoginView()
    {
        return view('super-admin.login');
    }
    public function baranggayAdminLoginView()
    {
        return view('baranggay-admin.login');
    }
    public function fieldWorkerLoginView()
    {
        return view('fieldworker.login');
    }
    public function verifySuperAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {

            if(Auth::user()->account_type === 'Super Admin') {
                $request->session()->regenerate();

                return redirect()->intended('/super-admin/dashboard');
            }
            Auth::logout();

            return redirect()->back()->withErrors('Login failed. Please check your email and password.');
        }

        return redirect()->back()->withErrors('Login failed. Please check your email and password.');
    }

    public function verifyBaranggayAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {

            if(Auth::user()->account_type === 'Baranggay Admin') {
                $request->session()->regenerate();

                return redirect()->intended('/baranggay-admin/residents-reports');
            }
            Auth::logout();

            return redirect()->back()->withErrors('Login failed. Please check your email and password.');
        }

        return redirect()->back()->withErrors('Login failed. Please check your email and password.');
    }
    public function verifyFieldWorker(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {

            if(Auth::user()->account_type === 'Field Worker') {
                $request->session()->regenerate();

                return redirect()->intended('/fieldworker/register-residents');
            }
            Auth::logout();

            return redirect()->back()->withErrors('Login failed. Please check your email and password.');
        }

        return redirect()->back()->withErrors('Login failed. Please check your email and password.');
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
