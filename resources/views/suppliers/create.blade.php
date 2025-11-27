@extends('layouts.app')

@section('title', 'Tambah Supplier - Toko Ikan Hias')
@section('page-title', 'Tambah Supplier')

@section('content')
<div class="max-w-3xl mx-auto pb-24 lg:pb-6">
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">

    <!-- Header -->
    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
      <a href="{{ route('suppliers.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Supplier Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Daftarkan supplier baru ke sistem</p>
      </div>
    </div>

    <form action="{{ route('suppliers.store') }}" method="POST">
      @csrf

      <!-- Nama Supplier -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Nama Supplier <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name') }}" required
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: CV Ikan Jaya">
        @error('name')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Kontak -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Kontak</label>
        <input type="text" name="contact" value="{{ old('contact') }}"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: 0812-3456-7890 / nama@email.com">
        @error('contact')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="text-xs text-gray-500 mt-2">💡 Bisa nomor telepon, email, atau WhatsApp</p>
      </div>

      <!-- Alamat -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
        <textarea name="address" rows="4"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota">{{ old('address') }}</textarea>
        @error('address')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Survival Rate -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Survival Rate (%)</label>
        <div class="relative">
          <input type="number" name="survival_rate" value="{{ old('survival_rate', 0) }}" min="0" max="100" step="0.1"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="0">
          <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">%</span>
        </div>
        @error('survival_rate')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="text-xs text-gray-500 mt-2">💡 Persentase ikan yang bertahan hidup dari supplier ini (0-100)</p>
      </div>

      <!-- Info Box -->
      <div class="bg-blue-50 border-l-4 border-blue-500 rounded-xl p-4 mb-6">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div class="flex-1">
            <p class="text-sm font-semibold text-blue-800">Informasi</p>
            <p class="text-sm text-blue-700 mt-1">Data supplier ini akan muncul di form pembelian untuk memudah tracking pembelian ikan.</p>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex gap-3 pt-6 border-t border-gray-200">
        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-xl hover:bg-blue-700 transition font-semibold shadow-sm hover:shadow-md">
          💾 Simpan Supplier
        </button>
        <a href="{{ route('suppliers.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition font-semibold text-center">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>
@endsection