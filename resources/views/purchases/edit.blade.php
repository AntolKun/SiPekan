@extends('layouts.app')

@section('title', 'Edit Pembelian - Toko Ikan Hias')
@section('page-title', 'Edit Pembelian')

@section('content')
<div class="max-w-3xl mx-auto pb-24 lg:pb-6">
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">

    <!-- Header -->
    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
      <a href="{{ route('purchases.show', $purchase->id) }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Pembelian #{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</h2>
        <p class="text-sm text-gray-500 mt-1">Perbarui data pembelian ikan</p>
      </div>
    </div>

    <!-- Warning -->
    <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-xl p-4 mb-6">
      <div class="flex items-start">
        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <div class="flex-1">
          <p class="text-sm font-semibold text-yellow-800">Perhatian!</p>
          <p class="text-sm text-yellow-700 mt-1">Mengubah data pembelian akan mempengaruhi stok ikan.</p>
        </div>
      </div>
    </div>

    <form action="{{ route('purchases.update', $purchase->id) }}" method="POST">
      @csrf
      @method('PUT')

      <!-- Supplier -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Supplier <span class="text-red-500">*</span>
        </label>
        <select name="supplier_id" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
          @foreach($suppliers as $supplier)
          <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id) == $supplier->id ? 'selected' : '' }}>
            {{ $supplier->name }}
            @if($supplier->contact)
            - {{ $supplier->contact }}
            @endif
          </option>
          @endforeach
        </select>
        @error('supplier_id')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Ikan -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Ikan <span class="text-red-500">*</span>
        </label>
        <select name="fish_id" id="fishSelect" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" onchange="updateFishInfo()">
          @foreach($fish as $item)
          <option value="{{ $item->id }}"
            data-current-stock="{{ $item->stock }}"
            data-purchase-price="{{ $item->purchase_price }}"
            {{ old('fish_id', $purchase->fish_id) == $item->id ? 'selected' : '' }}>
            {{ $item->name }} - Stok: {{ $item->stock }} ekor
          </option>
          @endforeach
        </select>
        @error('fish_id')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Info Stok Lama -->
      <div class="bg-blue-50 border-l-4 border-blue-500 rounded-xl p-4 mb-6">
        <p class="text-sm text-blue-800">
          <span class="font-semibold">Data lama:</span> {{ $purchase->quantity }} ekor dari {{ $purchase->fish->name }}
        </p>
      </div>

      <!-- Jumlah & Harga -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Jumlah Dibeli <span class="text-red-500">*</span>
          </label>
          <input type="number" name="quantity" id="quantityInput" value="{{ old('quantity', $purchase->quantity) }}" required min="1"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="0"
            onchange="calculateTotal()">
          @error('quantity')
          <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Harga per Ekor <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
            <input type="number" name="price_per_unit" id="priceInput" value="{{ old('price_per_unit', $purchase->price_per_unit) }}" required min="0"
              class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
              placeholder="0"
              onchange="calculateTotal()">
          </div>
          @error('price_per_unit')
          <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <!-- Biaya Transport -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Biaya Transport
        </label>
        <div class="relative">
          <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
          <input type="number" name="transport_cost" id="transportInput" value="{{ old('transport_cost', $purchase->transport_cost) }}" min="0"
            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="0"
            onchange="calculateTotal()">
        </div>
        @error('transport_cost')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Tanggal Pembelian -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Tanggal Pembelian
        </label>
        <input type="datetime-local" name="purchase_date" value="{{ old('purchase_date', $purchase->purchase_date->format('Y-m-d\TH:i')) }}"
          class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
        @error('purchase_date')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
      </div>

      <!-- Summary -->
      <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan Pembelian</h3>
        <div class="space-y-3">
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Subtotal Ikan</span>
            <span class="font-semibold text-gray-800" id="subtotalDisplay">Rp 0</span>
          </div>
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Biaya Transport</span>
            <span class="font-semibold text-gray-800" id="transportDisplay">Rp 0</span>
          </div>
          <div class="border-t border-blue-300 pt-3">
            <div class="flex justify-between items-center">
              <span class="text-lg font-bold text-gray-800">Total Biaya</span>
              <span class="text-2xl font-bold text-blue-600" id="totalDisplay">Rp 0</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex gap-3 pt-6 border-t border-gray-200">
        <button type="submit" class="flex-1 bg-primary-600 text-white py-3 px-6 rounded-xl hover:bg-primary-700 transition font-semibold shadow-sm hover:shadow-md">
          💾 Update Pembelian
        </button>
        <a href="{{ route('purchases.show', $purchase->id) }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition font-semibold text-center">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantityInput').value) || 0;
    const price = parseFloat(document.getElementById('priceInput').value) || 0;
    const transport = parseFloat(document.getElementById('transportInput').value) || 0;

    const subtotal = quantity * price;
    const total = subtotal + transport;

    document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatRupiah(subtotal);
    document.getElementById('transportDisplay').textContent = 'Rp ' + formatRupiah(transport);
    document.getElementById('totalDisplay').textContent = 'Rp ' + formatRupiah(total);
  }

  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
  }

  // Initialize on load
  document.addEventListener('DOMContentLoaded', function() {
    calculateTotal();
  });
</script>
@endsection