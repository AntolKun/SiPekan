@extends('layouts.app')

@section('title', 'Edit Catatan Kematian')
@section('page-title', 'Edit Kematian')

@section('content')
<div class="max-w-3xl mx-auto">
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center gap-3 mb-2">
      <a href="{{ route('mortality.index') }}" class="text-gray-600 hover:text-gray-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Edit Catatan Kematian</h2>
        <p class="text-sm text-gray-600 mt-1">Perbarui informasi kematian ikan</p>
      </div>
    </div>
  </div>

  <!-- Alert Messages -->
  @if($errors->any())
  <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    <div class="flex items-center mb-2">
      <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
      </svg>
      <span class="font-medium">Terjadi kesalahan:</span>
    </div>
    <ul class="list-disc list-inside text-sm">
      @foreach($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
  @endif

  <!-- Info Box -->
  <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg">
    <div class="flex items-start">
      <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
      </svg>
      <div>
        <p class="font-medium">Perhatian!</p>
        <p class="text-sm mt-1">Mengubah data ini akan mempengaruhi perhitungan stok ikan. Stok lama akan dikembalikan, dan stok baru akan dikurangi sesuai data yang diupdate.</p>
      </div>
    </div>
  </div>

  <!-- Form -->
  <form action="{{ route('mortality.update', $mortality->id) }}" method="POST" class="bg-white rounded-lg shadow-sm p-6">
    @csrf
    @method('PUT')

    <!-- Fish Selection -->
    <div class="mb-5">
      <label for="fish_id" class="block text-sm font-medium text-gray-700 mb-2">
        Pilih Ikan <span class="text-red-600">*</span>
      </label>
      <select name="fish_id" id="fish_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
        <option value="">-- Pilih Ikan --</option>
        @foreach($fish as $item)
        <option value="{{ $item->id }}"
          data-stock="{{ $item->stock }}"
          data-price="{{ $item->purchase_price }}"
          {{ old('fish_id', $mortality->fish_id) == $item->id ? 'selected' : '' }}>
          {{ $item->name }}
          @if($item->type)- {{ $item->type }}@endif
          (Stok: {{ $item->stock }} ekor)
        </option>
        @endforeach
      </select>
      <p class="text-xs text-gray-500 mt-1">Pilih jenis ikan yang mengalami kematian</p>
      <p id="stockInfo" class="text-sm text-blue-600 mt-2 hidden"></p>
    </div>

    <!-- Quantity -->
    <div class="mb-5">
      <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
        Jumlah Ikan Mati <span class="text-red-600">*</span>
      </label>
      <input type="number"
        name="quantity"
        id="quantity"
        required
        min="1"
        value="{{ old('quantity', $mortality->quantity) }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
        placeholder="Masukkan jumlah ikan">
      <p class="text-xs text-gray-500 mt-1">Jumlah ikan yang mati (dalam ekor)</p>
    </div>

    <!-- Reason -->
    <div class="mb-5">
      <label for="reason" class="block text-sm font-medium text-gray-700 mb-2">
        Penyebab Kematian
      </label>
      <select name="reason_select" id="reason_select" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 mb-2">
        <option value="">-- Pilih Penyebab --</option>
        @foreach($reasons as $reason)
        <option value="{{ $reason }}" {{ old('reason', $mortality->reason) == $reason ? 'selected' : '' }}>{{ $reason }}</option>
        @endforeach
      </select>

      <textarea name="reason"
        id="reason"
        rows="3"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
        placeholder="Atau tulis penyebab lainnya secara detail...">{{ old('reason', $mortality->reason) }}</textarea>
      <p class="text-xs text-gray-500 mt-1">Pilih dari daftar atau tulis manual</p>
    </div>

    <!-- Recorded Date -->
    <div class="mb-5">
      <label for="recorded_date" class="block text-sm font-medium text-gray-700 mb-2">
        Tanggal Kejadian <span class="text-red-600">*</span>
      </label>
      <input type="datetime-local"
        name="recorded_date"
        id="recorded_date"
        required
        value="{{ old('recorded_date', $mortality->recorded_date->format('Y-m-d\TH:i')) }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
      <p class="text-xs text-gray-500 mt-1">Kapan kejadian kematian ini terjadi</p>
    </div>

    <!-- Estimated Loss (Auto Calculate) -->
    <div class="mb-6 p-4 bg-orange-50 border border-orange-200 rounded-lg">
      <div class="flex items-start">
        <svg class="w-5 h-5 text-orange-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
          <p class="text-sm font-medium text-orange-800">Estimasi Kerugian</p>
          <p id="lossAmount" class="text-lg font-bold text-orange-900 mt-1">Rp {{ number_format($mortality->loss_amount, 0, ',', '.') }}</p>
          <p class="text-xs text-orange-700 mt-1">Dihitung otomatis berdasarkan harga beli × jumlah</p>
        </div>
      </div>
    </div>

    <!-- Meta Information -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg text-sm text-gray-600">
      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-medium">Dicatat:</span> {{ $mortality->created_at->format('d M Y, H:i') }}
        </div>
        @if($mortality->created_at != $mortality->updated_at)
        <div>
          <span class="font-medium">Diupdate:</span> {{ $mortality->updated_at->format('d M Y, H:i') }}
        </div>
        @endif
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-3">
      <button type="submit" class="flex-1 bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition font-medium">
        <div class="flex items-center justify-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Update Catatan
        </div>
      </button>
      <a href="{{ route('mortality.show', $mortality->id) }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-medium text-center">
        Batal
      </a>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fishSelect = document.getElementById('fish_id');
    const quantityInput = document.getElementById('quantity');
    const stockInfo = document.getElementById('stockInfo');
    const lossAmountDisplay = document.getElementById('lossAmount');
    const reasonSelect = document.getElementById('reason_select');
    const reasonTextarea = document.getElementById('reason');

    // Handle reason selection
    reasonSelect.addEventListener('change', function() {
      if (this.value) {
        reasonTextarea.value = this.value;
      }
    });

    reasonTextarea.addEventListener('input', function() {
      if (this.value) {
        reasonSelect.value = '';
      }
    });

    // Calculate loss amount
    function calculateLoss() {
      const selectedOption = fishSelect.options[fishSelect.selectedIndex];
      if (!selectedOption.value) {
        stockInfo.classList.add('hidden');
        return;
      }

      const stock = parseInt(selectedOption.dataset.stock);
      const price = parseFloat(selectedOption.dataset.price);
      const quantity = parseInt(quantityInput.value) || 0;

      // Show stock info
      stockInfo.classList.remove('hidden');
      stockInfo.textContent = `ℹ️ Stok tersedia: ${stock} ekor`;

      // Validate quantity (add old quantity back to stock for validation)
      const oldQuantity = {
        {
          $mortality - > quantity
        }
      };
      const oldFishId = {
        {
          $mortality - > fish_id
        }
      };
      const availableStock = selectedOption.value == oldFishId ? stock + oldQuantity : stock;

      if (quantity > availableStock) {
        stockInfo.textContent = `⚠️ Jumlah melebihi stok! Stok tersedia: ${availableStock} ekor`;
        stockInfo.classList.remove('text-blue-600');
        stockInfo.classList.add('text-red-600');
        quantityInput.setCustomValidity('Jumlah melebihi stok yang tersedia');
      } else {
        stockInfo.classList.remove('text-red-600');
        stockInfo.classList.add('text-blue-600');
        quantityInput.setCustomValidity('');
      }

      // Calculate loss
      const totalLoss = price * quantity;
      lossAmountDisplay.textContent = 'Rp ' + totalLoss.toLocaleString('id-ID');
    }

    fishSelect.addEventListener('change', calculateLoss);
    quantityInput.addEventListener('input', calculateLoss);

    // Initial calculation
    calculateLoss();
  });
</script>
@endsection