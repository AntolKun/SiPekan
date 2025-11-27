@extends('layouts.app')

@section('title', 'Edit Pengeluaran - Toko Ikan Hias')
@section('page-title', 'Edit Pengeluaran')

@section('content')
<div class="max-w-3xl mx-auto pb-24 lg:pb-6">
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">

    <!-- Header -->
    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
      <a href="{{ route('expenses.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Pengeluaran</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui data pengeluaran operasional</p>
      </div>
    </div>

    <form action="{{ route('expenses.update', $expense->id) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Kategori -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Kategori <span class="text-red-500">*</span>
        </label>
        <select name="category" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
          <option value="">Pilih Kategori</option>
          @foreach(\App\Models\Expense::$categories as $key => $label)
          <option value="{{ $key }}" {{ old('category', $expense->category) == $key ? 'selected' : '' }}>
            {{ $label }}
          </option>
          @endforeach
        </select>
        @error('category')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Deskripsi -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Deskripsi <span class="text-red-500">*</span>
        </label>
        <input type="text" name="description" value="{{ old('description', $expense->description) }}" required
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
          placeholder="Contoh: Pakan Ikan Merek XYZ">
        @error('description')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Jumlah -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Jumlah <span class="text-red-500">*</span>
        </label>
        <div class="relative">
          <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
          <input type="number" name="amount" value="{{ old('amount', $expense->amount) }}" required min="0"
            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="0">
        </div>
        @error('amount')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Tanggal -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Pengeluaran</label>
        <input type="datetime-local" name="expense_date" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d\TH:i')) }}"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
        @error('expense_date')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Buttons -->
      <div class="flex gap-3 pt-6 border-t border-gray-200">
        <button type="submit" class="flex-1 bg-orange-600 text-white py-3 px-6 rounded-xl hover:bg-orange-700 transition font-semibold shadow-sm hover:shadow-md">
          💾 Update Pengeluaran
        </button>
        <a href="{{ route('expenses.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition font-semibold text-center">
          Batal
        </a>
        <button type="button" onclick="confirmDelete()" class="px-6 py-3 bg-red-600 text-white rounded-xl hover:bg-red-700 transition font-semibold">
          🗑️ Hapus
        </button>
      </div>
    </form>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="hidden">
      @csrf
      @method('DELETE')
    </form>
  </div>
</div>

<script>
  function confirmDelete() {
    if (confirm('⚠️ Hapus pengeluaran ini?\n\nData yang sudah dihapus tidak dapat dikembalikan!')) {
      document.getElementById('deleteForm').submit();
    }
  }
</script>
@endsection