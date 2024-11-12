<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Kayıt ekranını göster
    public function showRegisterForm()
    {
        return view('auth.register'); // Kayıt formunu göster
    }

    // Kayıt işlemini yap
    public function register(Request $request)
    {
        // Gelen veriyi doğruluyoruz
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Kullanıcıyı veritabanına kaydediyoruz
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // setPasswordAttribute metodu çalışacak
        ]);

        // Kullanıcıyı otomatik olarak giriş yapıyoruz
        Auth::login($user);

        // Kullanıcıyı ürünler sayfasına yönlendiriyoruz
        return redirect()->route('products')->with('success', 'Hoş geldiniz, ' . $user->name . '!');
    }

    // Giriş ekranını göster
    public function showLoginForm()
    {
        return view('auth.login'); // Giriş formunu göster
    }

    // Giriş işlemini yap
    public function login(Request $request)
    {
        // Giriş yapabilmek için e-posta ve şifreyi alıyoruz
        $credentials = $request->only('email', 'password');

        // Eğer şifre doğrulaması başarılıysa
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return redirect()->route('products')->with('success', 'Hoş geldiniz, ' . $user->name . '!');
        }

        // Şifre yanlışsa hata mesajı gösteriyoruz
        return redirect()->back()->withErrors([
            'email' => 'Geçersiz e-posta veya şifre.',
        ]);
    }

    // Çıkış yap
    public function logout()
    {
        Auth::logout(); // Kullanıcıyı çıkış yaptır
        return redirect()->route('login.form')->with('success', 'Başarıyla çıkış yaptınız.'); // Giriş sayfasına yönlendir
    }
}
