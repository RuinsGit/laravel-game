<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['showLoginForm', 'login']);
    }

    // Admin dashboard
    public function dashboard()
    {
        $adminCount = Admin::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $usersCount = User::count();

        return view('panel.dashboard', compact('adminCount', 'productCount', 'orderCount','usersCount'));
    }

    // Admin login sayfası
    public function showLoginForm()
    {
        return view('admin.login');
    }

    // Admin login işlemi
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $admin = Admin::where('email', $request->email)->first();

        if ($admin && \Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    // Admin'leri listeleme
    public function admins()
    {
        $admins = Admin::all();
        return view('panel.admins', compact('admins'));
    }

    // Siparişleri listeleme
    public function orders()
    {
        $orders = Order::with(['user', 'product'])->get();
        return view('panel.orders', compact('orders'));
    }

    // Ürünleri listeleme
    public function products()
    {
        $products = Product::all();
        return view('panel.products', compact('products'));
    }

    // Ürün düzenleme sayfası
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('panel.editProduct', compact('product'));
    }

    // Ürün güncelleme işlemi
    public function updateProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::findOrFail($id);
        $product->update($validatedData);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully!');
    }

    // Yeni ürün ekleme
    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.products')->with('success', 'Product added successfully!');
    }

    // Kullanıcıları listeleme
    public function users()
    {
        $users = User::all();
        return view('panel.users', compact('users'));
    }

    // Kullanıcı silme işlemi
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }

    // Admin çıkış yapma
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

    // Ürün silme işlemi
    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully!');
    }

}
