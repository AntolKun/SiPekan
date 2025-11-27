@extends('layouts.app')

@section('title', 'Tambah Karantina Ikan')
@section('page-title', 'Tambah Karantina')

@section('content')
<div class="max-w-3xl mx-auto">
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center gap-3 mb-2">
      <a href="{{ route('quarantine.index') }}" class="text-gray-600 hover:text-gray-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Tambah Karantina Ikan</h2>
        <p class="text-sm text-gray-600 mt-1">Masukkan ikan ke dalam karantina</p>
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
  <div class="mb-6 bg-purple-50 border border-purple-200 text-purple-800 px-4 py-3 rounded-lg">
    <div class="flex items-start">
      <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
      </svg>
      <div>
        <p class="font-medium">Tentang Karantina</p>
        <p class="text-sm mt-1">Ikan yang dikarantina akan otomatis ditandai dengan status "karantina". Durasi karantina standar adalah 14 hari. Jangan lupa berikan treatment yang tepat!</p>
      </div>
    </div>
  </div>

  <!-- Form -->
  <form action="{{ route('quarantine.store') }}" method="POST" class="bg-white rounded-lg shadow-sm p-6">
    @csrf

    <!-- Fish Selection -->
    <div class="mb-5">
      <label for="fish_id" class="block text-sm font-medium text-gray-700 mb-2">
        Pilih Ikan <span class="text-red-600">*</span>
      </label>
      <select name="fish_id" id="fish_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
        <option value="">-- Pilih Ikan --</option>
        @foreach($fish as $item)
        <option value="{{ $item->id }}"
          data-stock="{{ $item->stock }}"
          data-status="{{ $item->health_status }}"
          {{ old('fish_id') == $item->id ? 'selected' : '' }}>
          {{ $item->name }}
          @if($item->type)- {{ $item->type }}@endif
          (Stok: {{ $item->stock }} ekor - Status: {{ ucfirst($item->health_status) }})
        </option>
        @endforeach
      </select>
      <p class="text-xs text-gray-500 mt-1">Hanya menampilkan ikan dengan status sehat atau sakit</p>
      <p id="stockInfo" class="text-sm text-blue-600 mt-2 hidden"></p>
    </div>

    <!-- Quantity -->
    <div class="mb-5">
      <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
        Jumlah Ikan <span class="text-red-600">*</span>
      </label>
      <input type="number"
        name="quantity"
        id="quantity"
        required
        min="1"
        value="{{ old('quantity') }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
        placeholder="Masukkan jumlah ikan">
      <p class="text-xs text-gray-500 mt-1">Berapa ekor ikan yang akan dikarantina</p>
    </div>

    <!-- Start Date -->
    <div class="mb-5">
      <label for="start_date" class="block text-sm font-medium text-gray-700 mb-2">
        Tanggal Mulai Karantina <span class="text-red-600">*</span>
      </label>
      <input type="datetime-local"
        name="start_date"
        id="start_date"
        required
        value="{{ old('start_date', now()->format('Y-m-d\TH:i')) }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
      <p class="text-xs text-gray-500 mt-1">Kapan karantina dimulai</p>
    </div>

    <!-- Treatment -->
    <div class="mb-5">
      <label for="treatment" class="block text-sm font-medium text-gray-700 mb-2">
        Treatment / Perawatan
      </label>
      <textarea name="treatment"
        id="treatment"
        rows="4"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
        placeholder="Contoh:&#10;- Ganti air setiap 2 hari&#10;- Berikan antibiotik (Tetracycline) 1x sehari&#10;- Observasi kondisi sisik dan sirip&#10;- Jaga suhu air 26-28°C">{{ old('treatment') }}</textarea>
      <p class="text-xs text-gray-500 mt-1">Catat treatment atau perawatan khusus yang diberikan</p>
    </div>

    <!-- Expected End Date (Information) -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
      <div class="flex items-start">
        <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        <div>
          <p class="text-sm font-medium text-blue-800">Estimasi Selesai Karantina</p>
          <p id="expectedEndDate" class="text-lg font-bold text-blue-900 mt-1">-</p>
          <p class="text-xs text-blue-700 mt-1">Berdasarkan durasi standar 14 hari</p>
        </div>
      </div>
    </div>

    <!-- Important Notes -->
    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
      <div class="flex items-start">
        <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
        <div class="text-sm text-yellow-800">
          <p class="font-medium mb-1">Catatan Penting:</p>
          <ul class="list-disc list-inside space-y-1">
            <li>Status ikan akan otomatis berubah menjadi "karantina"</li>
            <li>Ikan tidak dapat dijual selama dalam karantina</li>
            <li>Pastikan memberikan treatment yang tepat</li>
            <li>Monitor kondisi ikan secara berkala</li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-3">
      <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-medium">
        <div class="flex items-center justify-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Masukkan ke Karantina
        </div>
      </button>
      <a href="{{ route('quarantine.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-medium text-center">
        Batal
      </a>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const fishSelect = document.getElementById('fish_id');
    const quantityInput = document.getElementById('quantity');
    const startDateInput = document.getElementById('start_date');
    const stockInfo = document.getElementById('stockInfo');
    const expectedEndDate = document.getElementById('expectedEndDate');

    // Validate stock
    function validateStock() {
      const selectedOption = fishSelect.options[fishSelect.selectedIndex];
      if (!selectedOption.value) {
        stockInfo.classList.add('hidden');
        return;
      }

      const stock = parseInt(selectedOption.dataset.stock);
      const quantity = parseInt(quantityInput.value) || 0;

      stockInfo.classList.remove('hidden');
      stockInfo.textContent = `ℹ️ Stok tersedia: ${stock} ekor`;

      if (quantity > stock) {
        stockInfo.textContent = `⚠️ Jumlah melebihi stok! Stok tersedia: ${stock} ekor`;
        stockInfo.classList.remove('text-blue-600');
        stockInfo.classList.add('text-red-600');
        quantityInput.setCustomValidity('Jumlah melebihi stok yang tersedia');
      } else {
        stockInfo.classList.remove('text-red-600');
        stockInfo.classList.add('text-blue-600');
        quantityInput.setCustomValidity('');
      }
    }

    // Calculate expected end date
    function calculateEndDate() {
      const startDate = new Date(startDateInput.value);
      if (!isNaN(startDate)) {
        const endDate = new Date(startDate);
        endDate.setDate(endDate.getDate() + 14); // Add 14 days

        const options = {
          weekday: 'long',
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        };
        expectedEndDate.textContent = endDate.toLocaleDateString('id-ID', options);
      } else {
        expectedEndDate.textContent = '-';
      }
    }

    fishSelect.addEventListener('change', validateStock);
    quantityInput.addEventListener('input', validateStock);
    startDateInput.addEventListener('change', calculateEndDate);

    // Initial calculations
    if (fishSelect.value) validateStock();
    calculateEndDate();
  });
</script>
@endsection