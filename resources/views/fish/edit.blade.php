@extends('layouts.app')

@section('title', 'Edit Ikan - Toko Ikan Hias')
@section('page-title', 'Edit Ikan')

@section('content')
<div class="max-w-3xl mx-auto pb-24 lg:pb-6">
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">

    <!-- Header -->
    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
      <a href="{{ route('fish.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Data Ikan</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui informasi ikan: {{ $fish->name }}</p>
      </div>
    </div>

    <form action="{{ route('fish.update', $fish->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <!-- Nama Ikan -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Nama Ikan <span class="text-red-500">*</span>
        </label>
        <input type="text" name="name" value="{{ old('name', $fish->name) }}" required
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: Cupang Halfmoon">
        @error('name')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Jenis & Ukuran -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis/Type</label>
          <input type="text" name="type" value="{{ old('type', $fish->type) }}"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="Contoh: Betta">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Ukuran</label>
          <select name="size" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
            <option value="">Pilih Ukuran</option>
            <option value="Kecil" {{ old('size', $fish->size) == 'Kecil' ? 'selected' : '' }}>Kecil</option>
            <option value="Sedang" {{ old('size', $fish->size) == 'Sedang' ? 'selected' : '' }}>Sedang</option>
            <option value="Besar" {{ old('size', $fish->size) == 'Besar' ? 'selected' : '' }}>Besar</option>
          </select>
        </div>
      </div>

      <!-- Warna -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Warna</label>
        <input type="text" name="color" value="{{ old('color', $fish->color) }}"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: Merah, Biru Metalik">
      </div>

      <!-- Stok -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Stok Saat Ini <span class="text-red-500">*</span>
        </label>
        <input type="number" name="stock" value="{{ old('stock', $fish->stock) }}" required min="0"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="0">
        <p class="text-xs text-gray-500 mt-2">⚠️ Ubah stok secara manual. Untuk pembelian/penjualan gunakan menu yang sesuai.</p>
      </div>

      <!-- Harga Beli & Jual -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Harga Beli (per ekor) <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
            <input type="number" name="purchase_price" value="{{ old('purchase_price', $fish->purchase_price) }}" required min="0"
              class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
              placeholder="0">
          </div>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Harga Jual (per ekor) <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
            <input type="number" name="selling_price" value="{{ old('selling_price', $fish->selling_price) }}" required min="0"
              class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
              placeholder="0">
          </div>
        </div>
      </div>

      <!-- Lokasi Tank -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Lokasi Tank/Akuarium</label>
        <input type="text" name="tank_location" value="{{ old('tank_location', $fish->tank_location) }}"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: Tank A-1">
      </div>

      <!-- Status Kesehatan -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-3">Status Kesehatan</label>
        <div class="flex gap-4">
          <label class="flex items-center px-4 py-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary-500 transition {{ old('health_status', $fish->health_status) == 'sehat' ? 'border-primary-500 bg-primary-50' : '' }}">
            <input type="radio" name="health_status" value="sehat" {{ old('health_status', $fish->health_status) == 'sehat' ? 'checked' : '' }} class="mr-3 text-primary-600 focus:ring-primary-500">
            <span class="text-sm font-medium text-gray-700">✅ Sehat</span>
          </label>
          <label class="flex items-center px-4 py-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary-500 transition {{ old('health_status', $fish->health_status) == 'karantina' ? 'border-primary-500 bg-primary-50' : '' }}">
            <input type="radio" name="health_status" value="karantina" {{ old('health_status', $fish->health_status) == 'karantina' ? 'checked' : '' }} class="mr-3 text-primary-600 focus:ring-primary-500">
            <span class="text-sm font-medium text-gray-700">⚠️ Karantina</span>
          </label>
          <label class="flex items-center px-4 py-3 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary-500 transition {{ old('health_status', $fish->health_status) == 'sakit' ? 'border-primary-500 bg-primary-50' : '' }}">
            <input type="radio" name="health_status" value="sakit" {{ old('health_status', $fish->health_status) == 'sakit' ? 'checked' : '' }} class="mr-3 text-primary-600 focus:ring-primary-500">
            <span class="text-sm font-medium text-gray-700">❌ Sakit</span>
          </label>
        </div>
      </div>

      <!-- Minimum Stok -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Minimum Stok (Alert)</label>
        <input type="number" name="minimum_stock" value="{{ old('minimum_stock', $fish->minimum_stock) }}" min="0"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="5">
        <p class="text-xs text-gray-500 mt-2">💡 Sistem akan memberi peringatan jika stok di bawah angka ini</p>
      </div>

      <!-- Foto Saat Ini -->
      @if($fish->photo)
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Saat Ini</label>
        <div class="relative inline-block">
          <img src="{{ asset('storage/' . $fish->photo) }}" alt="{{ $fish->name }}" class="w-40 h-40 object-cover rounded-2xl border-2 border-gray-200">
          <div class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-lg">
            Terpasang
          </div>
        </div>
      </div>
      @endif

      <!-- Foto Baru -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          {{ $fish->photo ? 'Ganti Foto Ikan (Opsional)' : 'Upload Foto Ikan' }}
        </label>
        <div class="flex items-center justify-center w-full">
          <label class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-2xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
            <div class="flex flex-col items-center justify-center pt-5 pb-6">
              <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
              </svg>
              <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload foto baru</span></p>
              <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
            </div>
            <input type="file" name="photo" class="hidden" accept="image/*" onchange="previewImage(event)">
          </label>
        </div>
        <div id="imagePreview" class="mt-4 hidden">
          <p class="text-sm text-gray-600 mb-2">Preview foto baru:</p>
          <img id="preview" class="w-full h-64 object-cover rounded-2xl border border-gray-200">
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex gap-3 pt-6 border-t border-gray-200">
        <button type="submit" class="flex-1 bg-primary-600 text-white py-3 px-6 rounded-xl hover:bg-primary-700 transition font-semibold shadow-sm hover:shadow-md">
          💾 Update Data
        </button>
        <a href="{{ route('fish.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition font-semibold text-center">
          Batal
        </a>
        <button type="button" onclick="confirmDelete()" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-semibold">
          🗑️ Hapus
        </button>
      </div>
    </form>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('fish.destroy', $fish->id) }}" method="POST" class="hidden">
      @csrf
      @method('DELETE')
    </form>
  </div>
</div>

<script>
  function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewContainer = document.getElementById('imagePreview');
    const file = event.target.files[0];

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        previewContainer.classList.remove('hidden');
      }
      reader.readAsDataURL(file);
    }
  }

  function confirmDelete() {
    if (confirm('⚠️ PERHATIAN!\n\nApakah Anda yakin ingin menghapus data ikan "{{ $fish->name }}"?\n\nData yang sudah dihapus tidak dapat dikembalikan!')) {
      document.getElementById('deleteForm').submit();
    }
  }
</script>
@endsection