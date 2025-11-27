@extends('layouts.app')

@section('title', 'Detail Kematian Ikan')
@section('page-title', 'Detail Kematian')

@section('content')
<div class="max-w-4xl mx-auto">
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center gap-3 mb-2">
      <a href="{{ route('mortality.index') }}" class="text-gray-600 hover:text-gray-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Detail Catatan Kematian</h2>
        <p class="text-sm text-gray-600 mt-1">Informasi lengkap kematian ikan</p>
      </div>
    </div>
  </div>

  <!-- Alert Messages -->
  @if(session('success'))
  <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
    <div class="flex items-center">
      <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
      </svg>
      {{ session('success') }}
    </div>
  </div>
  @endif

  <!-- Main Content -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <!-- Header Section -->
    <div class="bg-red-600 text-white p-6">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-xl font-bold">Catatan Kematian #{{ $mortality->id }}</h3>
          <p class="text-red-100 mt-1">{{ $mortality->recorded_date->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="bg-red-700 p-4 rounded-lg">
          <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Details Section -->
    <div class="p-6">
      <!-- Fish Information -->
      <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          Informasi Ikan
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-7">
          <div>
            <p class="text-sm text-gray-600">Nama Ikan</p>
            <p class="font-semibold text-gray-900">{{ $mortality->fish->name }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Jenis/Tipe</p>
            <p class="font-semibold text-gray-900">{{ $mortality->fish->type ?: '-' }}</p>
          </div>
          @if($mortality->fish->size)
          <div>
            <p class="text-sm text-gray-600">Ukuran</p>
            <p class="font-semibold text-gray-900">{{ $mortality->fish->size }}</p>
          </div>
          @endif
          @if($mortality->fish->color)
          <div>
            <p class="text-sm text-gray-600">Warna</p>
            <p class="font-semibold text-gray-900">{{ $mortality->fish->color }}</p>
          </div>
          @endif
          <div>
            <p class="text-sm text-gray-600">Harga Beli (per ekor)</p>
            <p class="font-semibold text-gray-900">Rp {{ number_format($mortality->fish->purchase_price, 0, ',', '.') }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Stok Saat Ini</p>
            <p class="font-semibold text-gray-900">{{ $mortality->fish->stock }} ekor</p>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-200 my-6"></div>

      <!-- Mortality Details -->
      <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
          Detail Kematian
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-7">
          <div>
            <p class="text-sm text-gray-600">Jumlah Ikan Mati</p>
            <p class="text-2xl font-bold text-red-600">{{ $mortality->quantity }} ekor</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Total Kerugian</p>
            <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($mortality->loss_amount, 0, ',', '.') }}</p>
          </div>
          <div class="md:col-span-2">
            <p class="text-sm text-gray-600">Penyebab Kematian</p>
            <p class="font-semibold text-gray-900">{{ $mortality->reason ?: 'Tidak disebutkan' }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Tanggal Dicatat</p>
            <p class="font-semibold text-gray-900">{{ $mortality->created_at->format('d M Y, H:i') }} WIB</p>
          </div>
          @if($mortality->created_at != $mortality->updated_at)
          <div>
            <p class="text-sm text-gray-600">Terakhir Diupdate</p>
            <p class="font-semibold text-gray-900">{{ $mortality->updated_at->format('d M Y, H:i') }} WIB</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Loss Calculation -->
      <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
        <h5 class="font-semibold text-orange-800 mb-3 flex items-center">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
          Perhitungan Kerugian
        </h5>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-700">Harga Beli per Ekor:</span>
            <span class="font-semibold">Rp {{ number_format($mortality->fish->purchase_price, 0, ',', '.') }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-700">Jumlah Ikan Mati:</span>
            <span class="font-semibold">{{ $mortality->quantity }} ekor</span>
          </div>
          <div class="border-t border-orange-300 pt-2 flex justify-between">
            <span class="font-semibold text-orange-900">Total Kerugian:</span>
            <span class="font-bold text-lg text-orange-900">Rp {{ number_format($mortality->loss_amount, 0, ',', '.') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Actions -->
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
      <div class="flex flex-col sm:flex-row gap-3">
        <a href="{{ route('mortality.edit', $mortality->id) }}" class="flex-1 bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition font-medium text-center">
          <div class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Catatan
          </div>
        </a>
        <form action="{{ route('mortality.destroy', $mortality->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus catatan ini? Stok ikan akan dikembalikan.')">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition font-medium">
            <div class="flex items-center justify-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              Hapus Catatan
            </div>
          </button>
        </form>
        <a href="{{ route('mortality.index') }}" class="flex-1 bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-medium text-center">
          Kembali
        </a>
      </div>
    </div>
  </div>
</div>
@endsection