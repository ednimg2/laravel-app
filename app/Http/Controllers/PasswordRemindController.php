<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class PasswordRemindController extends Controller
{
    // 1. Mums reikia sugeneruot token -> action
    // 2. Prasivaliduot ar turim ta vartotoja (email) -> jei turim pabandom isisuti "email" // filepustcontent
    // 3. nauja forma kuri turi tik slaptazodi
    // 4. pakeisti slaptazodi

    public function show()
    {
        return view('password.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email']
        ]);

        $user = User::where('email', '=', $request->input('email'))->first();

        if ($user) {
            //tadar siunciam
            $token = Password::createToken($user);

            //Susti mail
            file_put_contents(storage_path() . '/email.log', 'Email change link: ' .
                URL::route('password_reminder.change', ['token' => $token, 'email' => $user->email])
            );

            return Redirect::route('login')->with('success', 'Password link generated');
        }

        //neegzistuoja
        return back()->withErrors(['email' => 'Bad email provided']);
    }

    public function changePassword($email, $token, Request $request)
    {
        return view('password.change', ['token' => $token, 'email' => $email]);
    }

    public function submit($email, $token, Request $request)
    {
        $data = $request->validate([
            'password' => ['required', \Illuminate\Validation\Rules\Password::min(6)]
        ]);

        $user = User::where('email', '=', $email)->first();

        if (Password::tokenExists($user, $token)) {
            //keiciam
            $user->password = Hash::make($request->input('password'));
            $user->save();
            Password::deleteToken($user);

            return Redirect::route('login')->with('success', 'Password changed successfully');
        }

        return Redirect::route('login');
    }
}
