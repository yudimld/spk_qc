<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; // Pastikan kita memanggil model User

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
        // Melakukan autentikasi menggunakan username dan password
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password], $request->remember)) {
            $request->session()->regenerate();

            // Mendapatkan role pengguna
            $user = Auth::user();

            // Jika role adalah spv_qa, manager_qa, atau staff_edc, arahkan ke Master Data PAC
            if (in_array($user->role, ['spv_qa', 'manager_qa', 'staff_edc'])) {
                return redirect()->route('master_data_pac'); // Redirect ke Master Data PAC
            }
            
            return redirect()->intended(route('dashboard.index', absolute: false));
        }
    
        // Jika gagal login
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        // Mengalihkan ke halaman login setelah logout
        return redirect()->route('login');
    }
    
}
