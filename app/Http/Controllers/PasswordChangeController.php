<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordChangeController extends Controller
{
    public function show()
    {
        return view('auth.password-change');
    }

    public function change(Request $request)
    {
        $formData = $request->validate(
            [
                'password' => ['required', 'current_password'],
                'new_password' => ['required', Password::min(8)->letters()]
            ]
        );

        /** @var User $user */
        $user = $request->user();
        $user->password = Hash::make($formData['new_password']);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password changed successfully!');
    }
}
