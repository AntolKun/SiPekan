<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Toko Ikan Hias</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-500 to-blue-700 min-h-screen flex items-center justify-center p-4">

  <div class="w-full max-w-md">
    <!-- Logo & Title -->
    <div class="text-center mb-8">
      <div class="inline-block bg-white p-4 rounded-2xl shadow-lg mb-4">
        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
      </div>
      <h1 class="text-3xl font-bold text-white mb-2">Toko Ikan Hias</h1>
      <p class="text-blue-100">Silakan login untuk melanjutkan</p>
    </div>

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-2xl p-8">
      <!-- Flash Messages -->
      @if(session('success'))
      <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
        <p class="text-sm text-green-800">{{ session('success') }}</p>
      </div>
      @endif

      @if($errors->any())
      <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
        @foreach($errors->all() as $error)
        <p class="text-sm text-red-800">{{ $error }}</p>
        @endforeach
      </div>
      @endif

      <!-- Login Form -->
      <form method="POST" action="{{ route('login.submit') }}" class="space-y-6">
        @csrf

        <!-- Email -->
        <div>
          <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
            Email
          </label>
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            required
            autofocus
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
            placeholder="nama@email.com">
        </div>

        <!-- Password -->
        <div>
          <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
            Password
          </label>
          <input
            type="password"
            id="password"
            name="password"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
            placeholder="••••••••">
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
          <input
            type="checkbox"
            id="remember"
            name="remember"
            class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
          <label for="remember" class="ml-2 text-sm text-gray-700">
            Ingat saya
          </label>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          class="w-full bg-blue-600 text-white py-3 rounded-xl font-semibold hover:bg-blue-700 transition shadow-lg hover:shadow-xl">
          Login
        </button>
      </form>

      <!-- Demo Accounts Info
      <div class="mt-6 pt-6 border-t border-gray-200">
        <p class="text-xs text-gray-500 text-center mb-3 font-semibold">Akun Demo:</p>
        <div class="space-y-2 text-xs">
          <div class="bg-gray-50 p-3 rounded-lg">
            <p class="font-semibold text-gray-700">Superadmin</p>
            <p class="text-gray-600">superadmin@tokoikan.com / superadmin123</p>
          </div>
          <div class="bg-gray-50 p-3 rounded-lg">
            <p class="font-semibold text-gray-700">Admin</p>
            <p class="text-gray-600">admin@tokoikan.com / admin123</p>
          </div>
          <div class="bg-gray-50 p-3 rounded-lg">
            <p class="font-semibold text-gray-700">Kasir</p>
            <p class="text-gray-600">kasir@tokoikan.com / kasir123</p>
          </div>
        </div>
      </div> -->
    </div>

    <!-- Footer -->
    <p class="text-center text-blue-100 text-sm mt-6">
      © 2025 Toko Ikan Hias. All rights reserved.
    </p>
  </div>

</body>

</html>