<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /**
     * Login formunu göster
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login işlemini gerçekleştir
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre gereklidir.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Role-based redirection
            $user = Auth::user();

            if ($user->isAdmin()) {
                // Admin veya Super Admin ise admin paneline yönlendir
                return redirect()->route('admin.dashboard')->with('success', 'Admin paneline hoş geldiniz, ' . $user->name . '!');
            } else {
                // Normal kullanıcı ise ana sayfaya yönlendir
                return redirect()->intended(route('home'))->with('success', 'Hoş geldiniz, ' . $user->name . '!');
            }
        }

        return back()->withErrors([
            'email' => 'Bu bilgilerle eşleşen bir hesap bulunamadı.',
        ])->withInput();
    }

    /**
     * Logout işlemini gerçekleştir
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $wasAdmin = $user ? $user->isAdmin() : false;

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($wasAdmin) {
            return redirect()->route('home')->with('success', 'Admin panelinden başarıyla çıkış yaptınız!');
        } else {
            return redirect()->route('home')->with('success', 'Başarıyla çıkış yaptınız!');
        }
    }
}
