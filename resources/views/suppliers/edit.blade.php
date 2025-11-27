@extends('layouts.app')

@section('title', 'Edit Supplier - Toko Ikan Hias')
@section('page-title', 'Edit Supplier')

@section('content')
<div class="max-w-3xl mx-auto pb-24 lg:pb-6">
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">

    <!-- Header -->
    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
      <a href="{{ route('suppliers.show', $supplier->id) }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Supplier</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi supplier: {{ $supplier->name }}</p>
      </div>
    </div>

    <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Nama Supplier -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Nama Supplier <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $supplier->name) }}" required
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: CV Ikan Jaya">
        @error('name')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Kontak -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Kontak</label>
        <input type="text" name="contact" value="{{ old('contact', $supplier->contact) }}"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: 0812-3456-7890 / nama@email.com">
        @error('contact')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Alamat -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Lengkap</label>
        <textarea name="address" rows="4"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota">{{ old('address', $supplier->address) }}</textarea>
        @error('address')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Survival Rate -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Survival Rate (%)</label>
        <div class="relative">
          <input type="number" name="survival_rate" value="{{ old('survival_rate', $supplier->survival_rate) }}" min="0" max="100" step="0.1"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="0">
          <span class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">%</span>
        </div>
        @error('survival_rate')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="text-xs text-gray-500 mt-2">💡 Persentase ikan yang bertahan hidup dari supplier ini</p>
      </div>

      <!-- Warning jika ada pembelian -->
      @if($supplier->purchases->count() > 0)
      <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-xl p-4 mb-6">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
          <div class="flex-1">
            <p class="text-sm font-semibold text-yellow-800">Perhatian!</p>
            <p class="text-sm text-yellow-700 mt-1">Supplier ini memiliki {{ $supplier->purchases->count() }} transaksi pembelian. Mengubah data tidak akan mempengaruhi riwayat pembelian.</p>
          </div>
        </div>
      </div>
      @endif

      <!-- Buttons -->
      <div class="flex gap-3 pt-6 border-t border-gray-200">
        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-xl hover:bg-blue-700 transition font-semibold shadow-sm hover:shadow-md">
          💾 Update Data
        </button>
        <a href="{{ route('suppliers.show', $supplier->id) }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition font-semibold text-center">
          Batal
        </a>
        @if($supplier->purchases->count() == 0)
        <button type="button" onclick="confirmDelete()" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-semibold">
          🗑️ Hapus
        </button>
        @endif
      </div>
    </form>

    @if($supplier->purchases->count() == 0)
    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" class="hidden">
      @csrf
      @method('DELETE')
    </form>
    @endif
  </div>
</div>

<script>
  function confirmDelete() {
    if (confirm('⚠️ Hapus supplier "{{ $supplier->name }}"?\n\nData yang sudah dihapus tidak dapat dikembalikan!')) {
      document.getElementById('deleteForm').submit();
    }
  }
</script>
@endsection