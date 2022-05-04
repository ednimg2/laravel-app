<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function show(Request $request) {
        return view('auth.show');
    }

    public function auth(AuthRequest $request) {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->input('rememberMe'))) {
            $request->session()->regenerate();

            return redirect()->route('profile');
        }

        // 1. reikia prasivaliduot email. password
        // 2. tuomet reikia pasitikrint ar musu password tinkas
        // 3. pergeneruot sesija
        // 4. nukreipt į profilio puslapį.


        //plain_password => hash(plain_password)
        // hash(plain_password) === database(password)
//        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' => Hash::make('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
//        Hash::check()
        return back()->withErrors(['email' => 'EMAIL INVALID OR PASSWORD INVALID']);
    }
}
