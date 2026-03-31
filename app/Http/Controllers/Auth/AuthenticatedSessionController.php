<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', [
            'loginRoute' => route('login'),
            'heading' => 'Login',
            'subheading' => 'Sign in to continue to your account',
            'switchRoute' => route('admin.login'),
            'switchText' => 'Need the admin portal? Login here',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $this->ensurePortalAccess($request);

        $request->session()->regenerate();

        return redirect()->to($this->resolveRedirectPath($request));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Ensure the authenticated user is logging in through the correct portal.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function ensurePortalAccess(Request $request): void
    {
        $expectedRole = match (true) {
            $request->routeIs('admin.login.store') => 'admin',
            $request->routeIs('inspector.login.store') => 'inspector',
            default => null,
        };

        if ($expectedRole === null || $request->user()?->role === $expectedRole) {
            return;
        }

        Auth::guard('web')->logout();
        $request->session()->regenerateToken();

        throw ValidationException::withMessages([
            'email' => __('These credentials do not have access to this portal.'),
        ]);
    }

    /**
     * Determine the default destination after login.
     */
    protected function redirectPathFor(Request $request): string
    {
        return match ($request->user()?->role) {
            'admin' => Route::has('admin.dashboard.index')
                ? route('admin.dashboard.index')
                : route('admin.dashboard'),
            default => route('inspector.dashboard'),
        };
    }

    /**
     * Resolve a safe post-login redirect path.
     */
    protected function resolveRedirectPath(Request $request): string
    {
        $defaultPath = $this->redirectPathFor($request);
        $intendedUrl = $request->session()->pull('url.intended');

        if (! $intendedUrl) {
            return $defaultPath;
        }

        $intendedPath = parse_url($intendedUrl, PHP_URL_PATH) ?: '';

        return match ($request->user()?->role) {
            'admin' => str_starts_with($intendedPath, '/admin') ? $intendedUrl : $defaultPath,
            'inspector' => str_starts_with($intendedPath, '/inspector') ? $intendedUrl : $defaultPath,
            default => $defaultPath,
        };
    }
}
