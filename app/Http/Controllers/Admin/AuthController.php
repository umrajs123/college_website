<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $throttleKey = $this->throttleKey($request);

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            return $this->sendLockoutResponse($request, RateLimiter::availableIn($throttleKey));
        }

        $credentials = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::hit($throttleKey, 60);

            if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
                return $this->sendLockoutResponse($request, RateLimiter::availableIn($throttleKey));
            }

            return back()
                ->withErrors(['email' => 'The provided admin credentials do not match our records.'])
                ->onlyInput('email');
        }

        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function editPassword(): View
    {
        return view('admin.auth.security');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(10)->mixedCase()->numbers()],
        ]);

        $request->user()->update([
            'password' => $validated['password'],
        ]);

        $request->session()->regenerate();

        return back()->with('status', 'Admin password updated successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    private function throttleKey(Request $request): string
    {
        return 'admin-login:'.strtolower((string) $request->input('email')).'|'.$request->ip();
    }

    private function sendLockoutResponse(Request $request, int $seconds): RedirectResponse
    {
        return back()
            ->withErrors(['email' => 'Cooling down. Too many login attempts.'])
            ->with('lockout_seconds', max(1, $seconds))
            ->onlyInput('email');
    }
}
