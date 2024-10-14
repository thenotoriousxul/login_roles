<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Intentar autenticar al usuario
        $request->authenticate();

        // Regenerar la sesión para evitar problemas de seguridad
        $request->session()->regenerate();

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar el rol del usuario y redirigir en consecuencia
        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard');
        } elseif ($user->hasRole('cliente')) {
            return redirect()->route('clientedashboard');
        }

        // Si el usuario no tiene ningún rol esperado, redirigir a una página de error o la página por defecto
        return redirect('/');
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
}
