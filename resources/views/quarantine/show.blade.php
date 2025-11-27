@extends('layouts.app')

@section('title', 'Detail Karantina Ikan')
@section('page-title', 'Detail Karantina')

@section('content')
<div class="max-w-4xl mx-auto">
  <!-- Header -->
  <div class="mb-6">
    <div class="flex items-center gap-3 mb-2">
      <a href="{{ route('quarantine.index') }}" class="text-gray-600 hover:text-gray-800">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
      </a>
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Detail Karantina Ikan</h2>
        <p class="text-sm text-gray-600 mt-1">Informasi lengkap catatan karantina</p>
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
    <div class="bg-purple-600 text-white p-6">
      <div class="flex items-center justify-between">
        <div>
          <h3 class="text-xl font-bold">Catatan Karantina #{{ $quarantine->id }}</h3>
          <p class="text-purple-100 mt-1">{{ $quarantine->start_date->format('d F Y, H:i') }} WIB</p>
        </div>
        <div class="flex items-center gap-3">
          @if($quarantine->status === 'aktif')
          <span class="px-4 py-2 bg-purple-800 rounded-lg font-semibold flex items-center">
            <span class="w-2 h-2 bg-white rounded-full mr-2 animate-pulse"></span>
            Aktif
          </span>
          @else
          <span class="px-4 py-2 bg-green-600 rounded-lg font-semibold flex items-center">
            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Selesai
          </span>
          @endif
        </div>
      </div>
    </div>

    <!-- Details Section -->
    <div class="p-6">
      <!-- Fish Information -->
      <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
          Informasi Ikan
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-7">
          <div>
            <p class="text-sm text-gray-600">Nama Ikan</p>
            <p class="font-semibold text-gray-900">{{ $quarantine->fish->name }}</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Jenis/Tipe</p>
            <p class="font-semibold text-gray-900">{{ $quarantine->fish->type ?: '-' }}</p>
          </div>
          @if($quarantine->fish->size)
          <div>
            <p class="text-sm text-gray-600">Ukuran</p>
            <p class="font-semibold text-gray-900">{{ $quarantine->fish->size }}</p>
          </div>
          @endif
          @if($quarantine->fish->color)
          <div>
            <p class="text-sm text-gray-600">Warna</p>
            <p class="font-semibold text-gray-900">{{ $quarantine->fish->color }}</p>
          </div>
          @endif
          <div>
            <p class="text-sm text-gray-600">Status Kesehatan</p>
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                            @if($quarantine->fish->health_status === 'sehat') bg-green-100 text-green-800
                            @elseif($quarantine->fish->health_status === 'sakit') bg-red-100 text-red-800
                            @else bg-purple-100 text-purple-800
                            @endif">
              {{ ucfirst($quarantine->fish->health_status) }}
            </span>
          </div>
          <div>
            <p class="text-sm text-gray-600">Stok Saat Ini</p>
            <p class="font-semibold text-gray-900">{{ $quarantine->fish->stock }} ekor</p>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-200 my-6"></div>

      <!-- Quarantine Details -->
      <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Detail Karantina
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pl-7">
          <div>
            <p class="text-sm text-gray-600">Jumlah Ikan Dikarantina</p>
            <p class="text-2xl font-bold text-purple-600">{{ $quarantine->quantity }} ekor</p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Status</p>
            <p class="text-2xl font-bold {{ $quarantine->status === 'aktif' ? 'text-purple-600' : 'text-green-600' }}">
              {{ ucfirst($quarantine->status) }}
            </p>
          </div>
          <div>
            <p class="text-sm text-gray-600">Tanggal Mulai</p>
            <p class="font-semibold text-gray-900">{{ $quarantine->start_date->format('d M Y, H:i') }} WIB</p>
          </div>
          @if($quarantine->end_date)
          <div>
            <p class="text-sm text-gray-600">Tanggal Selesai</p>
            <p class="font-semibold text-gray-900">{{ $quarantine->end_date->format('d M Y, H:i') }} WIB</p>
          </div>
          @endif
          <div>
            <p class="text-sm text-gray-600">Durasi Karantina</p>
            <p class="font-semibold text-gray-900">
              {{ $quarantine->duration }} hari
              @if($quarantine->status === 'aktif' && $quarantine->isOverdue())
              <span class="text-xs text-red-600 ml-2">⚠️ Sudah lebih dari 14 hari</span>
              @endif
            </p>
          </div>
        </div>
      </div>

      <!-- Treatment Information -->
      @if($quarantine->treatment)
      <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
          <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
          Treatment / Perawatan
        </h4>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
          <p class="text-sm text-gray-700 whitespace-pre-line">{{ $quarantine->treatment }}</p>
        </div>
      </div>
      @endif

      <!-- Timeline -->
      <div class="mb-6">
        <h4 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
          <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          Timeline
        </h4>
        <div class="space-y-3 pl-7">
          <div class="flex items-start">
            <div class="flex-shrink-0 w-2 h-2 bg-purple-600 rounded-full mt-2"></div>
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-900">Karantina Dimulai</p>
              <p class="text-xs text-gray-500">{{ $quarantine->start_date->format('d M Y, H:i') }}</p>
            </div>
          </div>
          @if($quarantine->status === 'aktif')
          <div class="flex items-start">
            <div class="flex-shrink-0 w-2 h-2 bg-yellow-500 rounded-full mt-2 animate-pulse"></div>
            <div class="ml-3">
              <p class="text-sm font-medium text-yellow-700">Sedang Berlangsung</p>
              <p class="text-xs text-gray-500">Hari ke-{{ $quarantine->duration }} dari minimal 14 hari</p>
            </div>
          </div>
          @else
          <div class="flex items-start">
            <div class="flex-shrink-0 w-2 h-2 bg-green-600 rounded-full mt-2"></div>
            <div class="ml-3">
              <p class="text-sm font-medium text-green-900">Karantina Selesai</p>
              <p class="text-xs text-gray-500">{{ $quarantine->end_date->format('d M Y, H:i') }}</p>
            </div>
          </div>
          @endif
          <div class="flex items-start">
            <div class="flex-shrink-0 w-2 h-2 bg-gray-400 rounded-full mt-2"></div>
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-900">Dicatat dalam sistem</p>
              <p class="text-xs text-gray-500">{{ $quarantine->created_at->format('d M Y, H:i') }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Progress Bar (for active quarantine) -->
      @if($quarantine->status === 'aktif')
      <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <div class="flex items-center justify-between mb-2">
          <span class="text-sm font-medium text-blue-800">Progress Karantina</span>
          <span class="text-sm font-bold text-blue-900">{{ min(100, round(($quarantine->duration / 14) * 100)) }}%</span>
        </div>
        <div class="w-full bg-blue-200 rounded-full h-2.5">
          <div class="bg-blue-600 h-2.5 rounded-full transition-all" style="width: {{ min(100, round(($quarantine->duration / 14) * 100)) }}%"></div>
        </div>
        <p class="text-xs text-blue-700 mt-2">
          @if($quarantine->duration < 14)
            Masih {{ 14 - $quarantine->duration }} hari lagi hingga durasi minimal tercapai
            @else
            Sudah melewati durasi minimal (14 hari). Siap untuk diselesaikan.
            @endif
            </p>
      </div>
      @endif
    </div>

    <!-- Actions -->
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
      <div class="flex flex-col sm:flex-row gap-3">
        @if($quarantine->status === 'aktif')
        <form action="{{ route('quarantine.complete', $quarantine->id) }}" method="POST" class="flex-1">
          @csrf
          <button type="submit" onclick="return confirm('Tandai karantina sebagai selesai? Ikan akan kembali ke status sehat.')" class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-medium">
            <div class="flex items-center justify-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Selesaikan Karantina
            </div>
          </button>
        </form>
        @endif
        <a href="{{ route('quarantine.edit', $quarantine->id) }}" class="flex-1 bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition font-medium text-center">
          <div class="flex items-center justify-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Catatan
          </div>
        </a>
        <form action="{{ route('quarantine.destroy', $quarantine->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus catatan ini? Status ikan akan dikembalikan ke sehat.')">
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
      </div>
      <div class="mt-3">
        <a href="{{ route('quarantine.index') }}" class="w-full block bg-gray-200 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-300 transition font-medium text-center">
          Kembali ke List
        </a>
      </div>
    </div>
  </div>
</div>
@endsection