<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
  /**
   * Show login form
   */
  public function showLogin()
  {
    if (auth()->check()) {
      return redirect()->route('dashboard');
    }
    return view('auth.login');
  }

  /**
   * Handle login
   */
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    if (Auth::attempt($credentials, $request->filled('remember'))) {
      $request->session()->regenerate();

      return redirect()->intended(route('dashboard'))
        ->with('success', 'Selamat datang, ' . auth()->user()->name . '!');
    }

    return back()->withErrors([
      'email' => 'Email atau password salah.',
    ])->onlyInput('email');
  }

  /**
   * Handle logout
   */
  public function logout(Request $request)
  {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')
      ->with('success', 'Anda telah logout.');
  }

  /**
   * Show user management (superadmin only)
   */
  public function index()
  {
    $users = User::orderBy('created_at', 'desc')->get();
    return view('auth.users.index', compact('users'));
  }

  /**
   * Show create user form
   */
  public function create()
  {
    return view('auth.users.create');
  }

  /**
   * Store new user
   */
  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|min:6|confirmed',
      'role' => 'required|in:superadmin,admin,kasir',
    ]);

    $validated['password'] = Hash::make($validated['password']);

    User::create($validated);

    return redirect()->route('users.index')
      ->with('success', 'User berhasil ditambahkan!');
  }

  /**
   * Show edit user form
   */
  public function edit(User $user)
  {
    return view('auth.users.edit', compact('user'));
  }

  /**
   * Update user
   */
  public function update(Request $request, User $user)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|email|unique:users,email,' . $user->id,
      'role' => 'required|in:superadmin,admin,kasir',
    ]);

    if ($request->filled('password')) {
      $request->validate([
        'password' => 'min:6|confirmed',
      ]);
      $validated['password'] = Hash::make($request->password);
    }

    $user->update($validated);

    return redirect()->route('users.index')
      ->with('success', 'User berhasil diupdate!');
  }

  /**
   * Delete user
   */
  public function destroy(User $user)
  {
    // Prevent deleting own account
    if ($user->id === auth()->id()) {
      return back()->with('error', 'Tidak dapat menghapus akun sendiri!');
    }

    $user->delete();

    return redirect()->route('users.index')
      ->with('success', 'User berhasil dihapus!');
  }
}
