@extends('layouts.app')

@section('title', 'Tambah Pembelian - Toko Ikan Hias')
@section('page-title', 'Tambah Pembelian')

@section('content')
<div class="max-w-3xl mx-auto pb-24 lg:pb-6">
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">

    <!-- Header -->
    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
      <a href="{{ route('purchases.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Pembelian Ikan</h2>
        <p class="text-sm text-gray-500 mt-1">Catat pembelian/restock ikan dari supplier</p>
      </div>
    </div>

    <form action="{{ route('purchases.store') }}" method="POST">
      @csrf

      <!-- Supplier -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Supplier <span class="text-red-500">*</span>
        </label>
        <div class="flex gap-2">
          <select name="supplier_id" required class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
            <option value="">-- Pilih Supplier --</option>
            @foreach($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
              {{ $supplier->name }}
              @if($supplier->contact)
              - {{ $supplier->contact }}
              @endif
            </option>
            @endforeach
          </select>
          <a href="{{ route('suppliers.create') }}" target="_blank" class="px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition flex items-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
          </a>
        </div>
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
          <option value="">-- Pilih Ikan --</option>
          @foreach($fish as $item)
          <option value="{{ $item->id }}"
            data-current-stock="{{ $item->stock }}"
            data-purchase-price="{{ $item->purchase_price }}"
            {{ old('fish_id', $selectedFishId ?? '') == $item->id ? 'selected' : '' }}>
            {{ $item->name }} - Stok: {{ $item->stock }} ekor
          </option>
          @endforeach
        </select>
        @error('fish_id')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror

        <!-- Fish Info Display -->
        <div id="fishInfo" class="mt-3 p-4 bg-blue-50 rounded-xl border border-blue-200 hidden">
          <p class="text-sm text-gray-700">
            <span class="font-semibold">Stok saat ini:</span>
            <span id="currentStock" class="text-blue-600 font-bold">-</span> ekor
          </p>
        </div>
      </div>

      <!-- Jumlah & Harga -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Jumlah Dibeli <span class="text-red-500">*</span>
          </label>
          <input type="number" name="quantity" id="quantityInput" value="{{ old('quantity', 1) }}" required min="1"
            class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="0"
            onchange="calculateTotal()">
          @error('quantity')
          <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
          @enderror
          <p class="text-xs text-gray-500 mt-2">Jumlah ikan yang dibeli (dalam ekor)</p>
        </div>

        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">
            Harga per Ekor <span class="text-red-500">*</span>
          </label>
          <div class="relative">
            <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
            <input type="number" name="price_per_unit" id="priceInput" value="{{ old('price_per_unit') }}" required min="0"
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
          Biaya Transport (Opsional)
        </label>
        <div class="relative">
          <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">Rp</span>
          <input type="number" name="transport_cost" id="transportInput" value="{{ old('transport_cost', 0) }}" min="0"
            class="w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
            placeholder="0"
            onchange="calculateTotal()">
        </div>
        @error('transport_cost')
        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
        <p class="text-xs text-gray-500 mt-2">💡 Biaya pengiriman/transport dari supplier</p>
      </div>

      <!-- Tanggal Pembelian -->
      <div class="mb-6">
        <label class="block text-sm font-semibold text-gray-700 mb-2">
          Tanggal Pembelian
        </label>
        <input type="datetime-local" name="purchase_date" value="{{ old('purchase_date', date('Y-m-d\TH:i')) }}"
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

      <!-- Info Stok -->
      <div class="bg-green-50 border-l-4 border-green-500 rounded-xl p-4 mb-6" id="stockInfo" style="display: none;">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div class="flex-1">
            <p class="text-sm font-semibold text-green-800">Stok akan bertambah</p>
            <p class="text-sm text-green-700 mt-1">
              Stok <span id="stockFishName">-</span> akan menjadi:
              <span class="font-bold" id="newStock">-</span> ekor
            </p>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="flex gap-3 pt-6 border-t border-gray-200">
        <button type="submit" class="flex-1 bg-blue-600 text-white py-3 px-6 rounded-xl hover:bg-blue-700 transition font-semibold shadow-sm hover:shadow-md">
          📦 Simpan Pembelian
        </button>
        <a href="{{ route('purchases.index') }}" class="flex-1 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition font-semibold text-center">
          Batal
        </a>
      </div>
    </form>
  </div>
</div>

<script>
  function updateFishInfo() {
    const select = document.getElementById('fishSelect');
    const selectedOption = select.options[select.selectedIndex];
    const priceInput = document.getElementById('priceInput');

    if (selectedOption.value) {
      const currentStock = selectedOption.dataset.currentStock;
      const purchasePrice = selectedOption.dataset.purchasePrice;

      // Show fish info
      document.getElementById('fishInfo').style.display = 'block';
      document.getElementById('currentStock').textContent = currentStock;

      // Set price if empty
      if (!priceInput.value || priceInput.value == 0) {
        priceInput.value = purchasePrice;
      }

      calculateTotal();
    } else {
      document.getElementById('fishInfo').style.display = 'none';
      document.getElementById('stockInfo').style.display = 'none';
    }
  }

  function calculateTotal() {
    const quantity = parseFloat(document.getElementById('quantityInput').value) || 0;
    const price = parseFloat(document.getElementById('priceInput').value) || 0;
    const transport = parseFloat(document.getElementById('transportInput').value) || 0;

    const subtotal = quantity * price;
    const total = subtotal + transport;

    document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatRupiah(subtotal);
    document.getElementById('transportDisplay').textContent = 'Rp ' + formatRupiah(transport);
    document.getElementById('totalDisplay').textContent = 'Rp ' + formatRupiah(total);

    // Update stock info
    const select = document.getElementById('fishSelect');
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value && quantity > 0) {
      const currentStock = parseInt(selectedOption.dataset.currentStock);
      const newStock = currentStock + quantity;

      document.getElementById('stockInfo').style.display = 'block';
      document.getElementById('stockFishName').textContent = selectedOption.text.split(' - ')[0];
      document.getElementById('newStock').textContent = newStock;
    }
  }

  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
  }

  // Initialize on load
  document.addEventListener('DOMContentLoaded', function() {
    updateFishInfo();
    calculateTotal();
  });
</script>
@endsection