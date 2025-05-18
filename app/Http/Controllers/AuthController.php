<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function postLogin(Request $request): RedirectResponse
    {
        try {
            $credentials = $request->only('phone', 'password');
            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                if ($user->role == User::ROLE_CUSTOMER) {
                    return redirect()->route('customer.showIndex')->with('success', 'Đăng nhập thành công');
                }
                return redirect()->route('admin.customer.showIndex')->with('success', 'Đăng nhập thành công');
            }
            return redirect()->back()->with('error', 'Đăng nhập thất bại');
        } catch (Exception $e) {
            return redirect()->route('auth.showLogin')->with('error', 'Đăng nhập thất bại');
        }
    }

    public function logout(): RedirectResponse
    {
        try {
            auth()->logout();
            return redirect()->route('auth.showLogin')->with('success', 'Đăng xuất thành công');
        }catch (Exception $e) {
            return redirect()->back()->with('error', 'Đăng xuất thất bại');
        }
    }
}
