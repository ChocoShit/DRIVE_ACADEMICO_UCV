<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function getLogin(): View
    {
        return view('Pages/Login');
    }

    public function postLogin(Request $request):RedirectResponse
    {
            $credentials = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);


        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['message' => 'Usuario o contraseña incorrectos.']);
    }

    public function postLogout(Request $request): RedirectResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        auth()->logout();

        return redirect()->route('login');
    }


}
