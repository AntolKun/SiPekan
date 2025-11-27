@extends('layouts.app')

@section('title', 'Edit Catatan Karantina')
@section('page-title', 'Edit Karantina')

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
        <h2 class="text-2xl font-bold text-gray-800">Edit Catatan Karantina</h2>
        <p class="text-sm text-gray-600 mt-1">Perbarui informasi karantina ikan</p>
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
        <p class="font-medium">Informasi</p>
        <p class="text-sm mt-1">Mengubah status dari "aktif" ke "selesai" akan mengubah status ikan menjadi sehat.</p>
      </div>
    </div>
  </div>

  <!-- Form -->
  <form action="{{ route('quarantine.update', $quarantine->id) }}" method="POST" class="bg-white rounded-lg shadow-sm p-6">
    @csrf
    @method('PUT')

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
          {{ old('fish_id', $quarantine->fish_id) == $item->id ? 'selected' : '' }}>
          {{ $item->name }}
          @if($item->type)- {{ $item->type }}@endif
          (Stok: {{ $item->stock }} ekor)
        </option>
        @endforeach
      </select>
      <p class="text-xs text-gray-500 mt-1">Pilih jenis ikan yang dikarantina</p>
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
        value="{{ old('quantity', $quarantine->quantity) }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
        placeholder="Masukkan jumlah ikan">
      <p class="text-xs text-gray-500 mt-1">Berapa ekor ikan yang dikarantina</p>
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
        value="{{ old('start_date', $quarantine->start_date->format('Y-m-d\TH:i')) }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
      <p class="text-xs text-gray-500 mt-1">Kapan karantina dimulai</p>
    </div>

    <!-- Status -->
    <div class="mb-5">
      <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
        Status <span class="text-red-600">*</span>
      </label>
      <select name="status" id="status" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
        <option value="aktif" {{ old('status', $quarantine->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="selesai" {{ old('status', $quarantine->status) === 'selesai' ? 'selected' : '' }}>Selesai</option>
      </select>
      <p class="text-xs text-gray-500 mt-1">Status karantina saat ini</p>
    </div>

    <!-- End Date (conditional) -->
    <div class="mb-5" id="endDateField" style="display: {{ old('status', $quarantine->status) === 'selesai' ? 'block' : 'none' }}">
      <label for="end_date" class="block text-sm font-medium text-gray-700 mb-2">
        Tanggal Selesai Karantina
      </label>
      <input type="datetime-local"
        name="end_date"
        id="end_date"
        value="{{ old('end_date', $quarantine->end_date ? $quarantine->end_date->format('Y-m-d\TH:i') : '') }}"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
      <p class="text-xs text-gray-500 mt-1">Kapan karantina selesai (wajib diisi jika status selesai)</p>
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
        placeholder="Contoh:&#10;- Ganti air setiap 2 hari&#10;- Berikan antibiotik (Tetracycline) 1x sehari&#10;- Observasi kondisi sisik dan sirip&#10;- Jaga suhu air 26-28°C">{{ old('treatment', $quarantine->treatment) }}</textarea>
      <p class="text-xs text-gray-500 mt-1">Catat treatment atau perawatan khusus yang diberikan</p>
    </div>

    <!-- Duration Info -->
    <div class="mb-6 p-4 bg-purple-50 border border-purple-200 rounded-lg">
      <div class="flex items-start">
        <svg class="w-5 h-5 text-purple-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <div>
          <p class="text-sm font-medium text-purple-800">Informasi Durasi</p>
          <p class="text-sm text-purple-700 mt-1">
            Durasi karantina saat ini: <span class="font-bold">{{ $quarantine->duration }} hari</span>
            @if($quarantine->duration < 14)
              <span class="block mt-1 text-xs">⏳ Masih {{ 14 - $quarantine->duration }} hari lagi hingga durasi minimal (14 hari)</span>
              @else
              <span class="block mt-1 text-xs">✅ Sudah melewati durasi minimal</span>
              @endif
          </p>
        </div>
      </div>
    </div>

    <!-- Meta Information -->
    <div class="mb-6 p-4 bg-gray-50 rounded-lg text-sm text-gray-600">
      <div class="grid grid-cols-2 gap-2">
        <div>
          <span class="font-medium">Dicatat:</span> {{ $quarantine->created_at->format('d M Y, H:i') }}
        </div>
        @if($quarantine->created_at != $quarantine->updated_at)
        <div>
          <span class="font-medium">Diupdate:</span> {{ $quarantine->updated_at->format('d M Y, H:i') }}
        </div>
        @endif
      </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-3">
      <button type="submit" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition font-medium">
        <div class="flex items-center justify-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Update Catatan
        </div>
      </button>
      <a href="{{ route('quarantine.show', $quarantine->id) }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-medium text-center">
        Batal
      </a>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const statusSelect = document.getElementById('status');
    const endDateField = document.getElementById('endDateField');
    const endDateInput = document.getElementById('end_date');

    // Show/hide end date based on status
    statusSelect.addEventListener('change', function() {
      if (this.value === 'selesai') {
        endDateField.style.display = 'block';
        if (!endDateInput.value) {
          // Set current date/time if empty
          const now = new Date();
          const year = now.getFullYear();
          const month = String(now.getMonth() + 1).padStart(2, '0');
          const day = String(now.getDate()).padStart(2, '0');
          const hours = String(now.getHours()).padStart(2, '0');
          const minutes = String(now.getMinutes()).padStart(2, '0');
          endDateInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        }
        endDateInput.required = true;
      } else {
        endDateField.style.display = 'none';
        endDateInput.required = false;
        endDateInput.value = '';
      }
    });

    // Validation: end date must be after start date
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
      if (statusSelect.value === 'selesai') {
        const startDate = new Date(document.getElementById('start_date').value);
        const endDate = new Date(endDateInput.value);

        if (!endDateInput.value) {
          e.preventDefault();
          alert('Tanggal selesai harus diisi jika status adalah "Selesai"');
          return false;
        }

        if (endDate < startDate) {
          e.preventDefault();
          alert('Tanggal selesai harus setelah tanggal mulai!');
          return false;
        }
      }
    });
  });
</script>
@endsection