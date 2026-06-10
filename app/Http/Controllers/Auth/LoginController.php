<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    const MAX_ATTEMPTS  = 5;
    const LOCKOUT_MINS  = 15;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Store session timestamp so CheckSuspended can detect forced logouts
        $request->session()->put('logged_in_at', now()->timestamp);

        if ($user->hasRole('Master')) {
            return redirect()->route('master.dashboard');
        } elseif ($user->hasRole('AdmiX')) {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/home');
    }

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password'        => 'required|string',
        ]);

        // Check account lockout before attempting auth
        $user = User::where('email', $request->email)->first();
        if ($user && $user->isLocked()) {
            $minutes = $user->locked_until->diffInMinutes(now()) + 1;
            throw \Illuminate\Validation\ValidationException::withMessages([
                $this->username() => "Too many failed attempts. Try again in {$minutes} minute(s).",
            ]);
        }
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        LoginAttempt::create([
            'user_id'    => $user?->id,
            'email'      => $request->email,
            'ip_address' => $request->ip(),
            'succeeded'  => false,
        ]);

        if ($user) {
            $attempts = $user->login_attempts_count + 1;
            $update   = ['login_attempts_count' => $attempts];

            if ($attempts >= self::MAX_ATTEMPTS) {
                $update['locked_until']         = now()->addMinutes(self::LOCKOUT_MINS);
                $update['login_attempts_count'] = 0;
            }

            $user->update($update);
        }

        throw \Illuminate\Validation\ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        $user = auth()->user();

        // Reset lockout counters and log successful attempt
        $user->update(['login_attempts_count' => 0, 'locked_until' => null]);

        LoginAttempt::create([
            'user_id'    => $user->id,
            'email'      => $request->email,
            'ip_address' => $request->ip(),
            'succeeded'  => true,
        ]);

        return $this->authenticated($request, $user)
            ?: redirect()->intended($this->redirectPath());
    }
}
