@extends('layouts.app')

@section('title', 'Tambah Penjualan - Toko Ikan Hias')
@section('page-title', 'Tambah Penjualan')

@section('content')
<div class="max-w-5xl mx-auto pb-24 lg:pb-6">
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">

    <!-- Header -->
    <div class="flex items-center mb-6 pb-6 border-b border-gray-200">
      <a href="{{ route('sales.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Transaksi Penjualan Baru</h2>
        <p class="text-sm text-gray-500 mt-1">Catat penjualan ikan kepada pelanggan</p>
      </div>
    </div>

    <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
      @csrf

      <div class="grid lg:grid-cols-3 gap-6">
        <!-- Left: Form Input -->
        <div class="lg:col-span-2 space-y-6">

          <!-- Pelanggan -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Pelanggan</label>
            <div class="flex gap-2">
              <select name="customer_id" id="customerSelect" class="flex-1 px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                <option value="">Pelanggan Umum</option>
                @foreach($customers as $customer)
                <option value="{{ $customer->id }}">{{ $customer->name }} - {{ $customer->phone }}</option>
                @endforeach
              </select>
              <button type="button" onclick="alert('Fitur tambah pelanggan baru akan segera hadir!')" class="px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
              </button>
            </div>
          </div>

          <!-- Tanggal -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal & Waktu Penjualan</label>
            <input type="datetime-local" name="sale_date" value="{{ old('sale_date', date('Y-m-d\TH:i')) }}"
              class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
          </div>

          <!-- Item Penjualan -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Item Penjualan</label>
            <div id="saleItems" class="space-y-3">
              <!-- Items will be added here via JavaScript -->
            </div>
            <button type="button" onclick="addSaleItem()" class="mt-3 w-full py-3 border-2 border-dashed border-gray-300 rounded-xl text-gray-600 hover:border-primary-500 hover:text-primary-600 hover:bg-primary-50 transition font-medium">
              + Tambah Item
            </button>
          </div>

          <!-- Metode Pembayaran -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-3">Metode Pembayaran</label>
            <div class="grid grid-cols-3 gap-3">
              <label class="relative flex items-center justify-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary-500 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                <input type="radio" name="payment_method" value="cash" checked class="sr-only">
                <div class="text-center">
                  <div class="text-3xl mb-2">💵</div>
                  <span class="text-sm font-semibold text-gray-700">Cash</span>
                </div>
              </label>
              <label class="relative flex items-center justify-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary-500 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                <input type="radio" name="payment_method" value="transfer" class="sr-only">
                <div class="text-center">
                  <div class="text-3xl mb-2">🏦</div>
                  <span class="text-sm font-semibold text-gray-700">Transfer</span>
                </div>
              </label>
              <label class="relative flex items-center justify-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary-500 transition has-[:checked]:border-primary-500 has-[:checked]:bg-primary-50">
                <input type="radio" name="payment_method" value="qris" class="sr-only">
                <div class="text-center">
                  <div class="text-3xl mb-2">📱</div>
                  <span class="text-sm font-semibold text-gray-700">QRIS</span>
                </div>
              </label>
            </div>
          </div>

          <!-- Catatan -->
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
            <textarea name="notes" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition" placeholder="Tambahkan catatan untuk transaksi ini...">{{ old('notes') }}</textarea>
          </div>
        </div>

        <!-- Right: Summary -->
        <div class="lg:col-span-1">
          <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200 sticky top-20">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Ringkasan</h3>

            <div class="space-y-3 mb-4">
              <div class="flex justify-between text-sm">
                <span class="text-gray-600">Subtotal</span>
                <span class="font-semibold text-gray-800" id="subtotalDisplay">Rp 0</span>
              </div>
              <div class="flex justify-between text-sm items-center">
                <span class="text-gray-600">Diskon</span>
                <div class="flex items-center gap-2">
                  <span class="text-gray-500 text-xs">Rp</span>
                  <input type="number" name="discount" id="discountInput" value="0" min="0"
                    class="w-24 px-2 py-1 border border-gray-300 rounded-lg text-sm text-right focus:outline-none focus:ring-2 focus:ring-primary-500"
                    onchange="updateTotal()">
                </div>
              </div>
            </div>

            <div class="border-t border-gray-300 pt-4 mb-6">
              <div class="flex justify-between items-center">
                <span class="text-lg font-bold text-gray-800">Total</span>
                <span class="text-2xl font-bold text-green-600" id="totalDisplay">Rp 0</span>
              </div>
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-4 px-6 rounded-xl hover:bg-green-700 transition font-bold text-lg shadow-lg hover:shadow-xl">
              💰 Proses Penjualan
            </button>

            <a href="{{ route('sales.index') }}" class="block w-full mt-3 bg-gray-100 text-gray-700 py-3 px-6 rounded-xl hover:bg-gray-200 transition font-semibold text-center">
              Batal
            </a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  let itemCounter = 0;
  const fishData = @json($fish);

  function addSaleItem() {
    itemCounter++;
    const itemHtml = `
        <div class="sale-item border-2 border-gray-200 rounded-2xl p-4 bg-white hover:border-primary-300 transition" id="item-${itemCounter}">
            <div class="flex justify-between items-start mb-3">
                <h4 class="font-semibold text-gray-800">Item #${itemCounter}</h4>
                <button type="button" onclick="removeSaleItem(${itemCounter})" class="text-red-600 hover:text-red-800 p-1 hover:bg-red-50 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Pilih Ikan</label>
                    <select name="items[${itemCounter}][fish_id]" onchange="updateItemPrice(${itemCounter})" class="fish-select w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 transition" required>
                        <option value="">-- Pilih Ikan --</option>
                        ${fishData.filter(f => f.stock > 0 && f.health_status === 'sehat').map(fish => `
                            <option value="${fish.id}" data-price="${fish.selling_price}" data-stock="${fish.stock}">
                                ${fish.name} - Rp ${formatRupiah(fish.selling_price)} (Stok: ${fish.stock})
                            </option>
                        `).join('')}
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Jumlah</label>
                        <input type="number" name="items[${itemCounter}][quantity]" min="1" value="1" 
                               onchange="updateItemSubtotal(${itemCounter})" 
                               class="item-quantity w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Harga Satuan</label>
                        <input type="number" name="items[${itemCounter}][price]" min="0" 
                               onchange="updateItemSubtotal(${itemCounter})" 
                               class="item-price w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    </div>
                </div>
                <div class="bg-blue-50 p-3 rounded-xl">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-600">Subtotal</span>
                        <span class="text-lg font-bold text-blue-600 item-subtotal">Rp 0</span>
                    </div>
                </div>
            </div>
        </div>
    `;
    document.getElementById('saleItems').insertAdjacentHTML('beforeend', itemHtml);
  }

  function removeSaleItem(id) {
    document.getElementById(`item-${id}`).remove();
    updateTotal();
  }

  function updateItemPrice(id) {
    const item = document.getElementById(`item-${id}`);
    const select = item.querySelector('.fish-select');
    const priceInput = item.querySelector('.item-price');
    const selectedOption = select.options[select.selectedIndex];

    if (selectedOption.value) {
      const price = selectedOption.dataset.price;
      priceInput.value = price;
      updateItemSubtotal(id);
    }
  }

  function updateItemSubtotal(id) {
    const item = document.getElementById(`item-${id}`);
    const quantity = parseFloat(item.querySelector('.item-quantity').value) || 0;
    const price = parseFloat(item.querySelector('.item-price').value) || 0;
    const subtotal = quantity * price;

    item.querySelector('.item-subtotal').textContent = 'Rp ' + formatRupiah(subtotal);
    updateTotal();
  }

  function updateTotal() {
    let subtotal = 0;
    document.querySelectorAll('.sale-item').forEach(item => {
      const quantity = parseFloat(item.querySelector('.item-quantity').value) || 0;
      const price = parseFloat(item.querySelector('.item-price').value) || 0;
      subtotal += quantity * price;
    });

    const discount = parseFloat(document.getElementById('discountInput').value) || 0;
    const total = subtotal - discount;

    document.getElementById('subtotalDisplay').textContent = 'Rp ' + formatRupiah(subtotal);
    document.getElementById('totalDisplay').textContent = 'Rp ' + formatRupiah(total);
  }

  function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID').format(angka);
  }

  // Validate stock before submit
  document.getElementById('saleForm').addEventListener('submit', function(e) {
    const items = document.querySelectorAll('.sale-item');

    if (items.length === 0) {
      e.preventDefault();
      alert('❌ Minimal harus ada 1 item penjualan!');
      return;
    }

    let valid = true;
    items.forEach(item => {
      const select = item.querySelector('.fish-select');
      const quantity = parseFloat(item.querySelector('.item-quantity').value) || 0;
      const selectedOption = select.options[select.selectedIndex];

      if (!selectedOption.value) {
        alert('❌ Pilih ikan untuk semua item!');
        valid = false;
        return;
      }

      if (selectedOption.value) {
        const stock = parseFloat(selectedOption.dataset.stock);
        if (quantity > stock) {
          alert(`❌ Stok ${selectedOption.text.split(' - ')[0]} tidak mencukupi!\nStok tersedia: ${stock} ekor\nYang diminta: ${quantity} ekor`);
          valid = false;
        }
      }
    });

    if (!valid) {
      e.preventDefault();
    }
  });

  // Add first item automatically
  document.addEventListener('DOMContentLoaded', function() {
    addSaleItem();
  });
</script>
@endsection