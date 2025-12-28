@extends('layouts.app')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')
<div class="max-w-2xl mx-auto">

  <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
    <div class="mb-6">
      <h2 class="text-xl font-bold text-gray-800">Edit User</h2>
      <p class="text-sm text-gray-600">Update informasi user</p>
    </div>

    <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
      @csrf
      @method('PUT')

      <!-- Name -->
      <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
          Nama Lengkap <span class="text-red-500">*</span>
        </label>
        <input
          type="text"
          id="name"
          name="name"
          value="{{ old('name', $user->name) }}"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror">
        @error('name')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Email -->
      <div>
        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
          Email<span class="text-red-500">*</span>
        </label>
        <input
          type="email"
          id="email"
          name="email"
          value="{{ old('email', $user->email) }}"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror">
        @error('email')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div><!-- Role -->
      <div>
        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
          Role <span class="text-red-500">*</span>
        </label>
        <select
          id="role"
          name="role"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
          <option value="superadmin" {{ old('role', $user->role) === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
          <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
          <option value="kasir" {{ old('role', $user->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
        </select>
        @error('role')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Divider -->
      <div class="border-t border-gray-200 pt-6">
        <p class="text-sm font-semibold text-gray-700 mb-2">Ganti Password (opsional)</p>
        <p class="text-xs text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>
      </div>

      <!-- Password -->
      <div>
        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
          Password Baru
        </label>
        <input
          type="password"
          id="password"
          name="password"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
          placeholder="Minimal 6 karakter">
        @error('password')
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
      </div>

      <!-- Password Confirmation -->
      <div>
        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
          Konfirmasi Password Baru
        </label>
        <input
          type="password"
          id="password_confirmation"
          name="password_confirmation"
          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
          placeholder="Ulangi password baru">
      </div>

      <!-- Actions -->
      <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-200">
        <a href="{{ route('users.index') }}" class="px-6 py-2.5 text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
          Batal
        </a>
        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition shadow-lg">
          Update User
        </button>
      </div>
    </form>
  </div>
</div>
@endsection