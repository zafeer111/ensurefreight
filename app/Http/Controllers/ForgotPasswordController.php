<?php

namespace App\Http\Controllers;

use App\Models\CustomerUser;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;


class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('forgot_password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token)
    {
        return view('reset_password', ['token' => $token]);
    }

    public function reset(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed',
        'token' => 'required|string',
    ]);
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        // Password reset successful, display status message
        return back()->with('status', 'Password successfully reset')->withInput($request->only('email'));
    } else {
        // Password reset not successful, display error message
        return back()->withErrors(['email' => __($status)]);
    }
}


}