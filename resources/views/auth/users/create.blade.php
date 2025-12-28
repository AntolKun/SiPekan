@extends('layouts.app')

@section('title', 'Tambah User')
@section('page-title', 'Tambah User')

@section('content')
<div class="max-w-2xl mx-auto">

  <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
    <div class="mb-6">
      <h2 class="text-xl font-bold text-gray-800">Tambah User Baru</h2>
      <p class="text-sm text-gray-600">Isi form untuk menambahkan user</p>
    </div>

    <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Name -->
      <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
          Nama Lengkap <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name') }}"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
          placeholder="Masukkan nama lengkap">
        @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
          Email <span class="text-red-500">*</span>
        </label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email') }}"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
          placeholder="nama@email.com">
        @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Role -->
      <div>
        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
          Role <span class="text-red-500">*</span>
        </label>
        <select
          id="role"
          name="role"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
          <option value="">Pilih Role</option>
          <option value="superadmin" {{ old('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
          <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
        </select>
        @error('role')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
        <p class="mt-2 text-xs text-gray-500">
          • Superadmin: Akses semua menu + kelola user<br>
          • Admin: Akses semua menu<br>
          • Kasir: Penjualan, stok, dan pelanggan
        </p>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
          Password <span class="text-red-500">*</span>
        </label>
        <input
          type="password"
          id="password"
          name="password"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
          placeholder="Minimal 6 karakter">
        @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password Confirmation -->
      <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
          Konfirmasi Password <span class="text-red-500">*</span>
        </label>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          placeholder="Ulangi password">
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
        <a href="{{ route('users.index') }}" class="px-6 py-2.5 text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
          Batal
        </a>
        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition shadow-lg">
          Simpan User
        </button>
      </div>
    </form>
  </div>

</div>
@endsection