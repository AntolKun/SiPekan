@extends('layouts.app')

@section('title', 'Tambah Pengeluaran - Toko Ikan Hias')
@section('page-title', 'Tambah Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto pb-20 lg:pb-6">
  <div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex items-center mb-6">
      <a href="{{ route('expenses.index') }}" class="mr-4 text-gray-600 hover:text-gray-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <h2 class="text-xl font-semibold text-gray-800">Catat Pengeluaran</h2>
    </div>

    <form action="{{ route('expenses.store') }}" method="POST">
      @csrf

      <!-- Kategori -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
        <select name="category" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">Pilih Kategori</option>
          <option value="pakan">🥘 Pakan</option>
          <option value="listrik">⚡ Listrik</option>
          <option value="air_treatment">💧 Air & Treatment</option>
          <option value="gaji">👤 Gaji Karyawan</option>
          <option value="sewa">🏠 Sewa Toko</option>
          <option value="peralatan">🔧 Peralatan</option>
          <option value="maintenance">🛠️ Maintenance</option>
          <option value="lainnya">📝 Lainnya</option>
        </select>
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi <span class="text-red-500">*</span></label>
        <input type="text" name="description" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Pakan Ikan Merek XYZ">
      </div>

      <!-- Jumlah -->
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
        <div class="relative">
          <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
          <input type="number" name="amount" required min="0" class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="0">
        </div>
      </div>

      <!-- Tanggal -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pengeluaran</label>
        <input type="datetime-local" name="expense_date" value="{{ date('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
      </div>

      <!-- Quick Amount Buttons -->
      <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Cepat</label>
        <div class="grid grid-cols-3 gap-2">
          <button type="button" onclick="setAmount(50000)" class="py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">Rp 50.000</button>
          <button type="button" onclick="setAmount(100000)" class="py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">Rp 100.000</button>
          <button type="button" onclick="setAmount(150000)" class="py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">Rp 150.000</button>
          <button type="button" onclick="setAmount(200000)" class="py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">Rp 200.000</button>
          <button type="button" onclick="setAmount(500000)" class="py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">Rp 500.000</button>
          <button type="button" onclick="setAmount(1000000)" class="py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm">Rp 1.000.000</button>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex gap-3">
        <button type="submit" class="flex-1 bg-orange-600 text-white py-2 px-4 rounded-lg hover:bg-orange-700 transition font-medium">
          💸 Simpan Pengeluaran
        </button>
        <a href="{{ route('expenses.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition font-medium text-center">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  function setAmount(amount) {
    document.querySelector('input[name="amount"]').value = amount;
  }
</script>
@endsection