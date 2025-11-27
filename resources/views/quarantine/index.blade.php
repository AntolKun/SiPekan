@extends('layouts.app')

@section('title', 'Catatan Karantina Ikan')
@section('page-title', 'Karantina Ikan')

@section('content')
<div class="max-w-7xl mx-auto">
  <!-- Header Section -->
  <div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h2 class="text-2xl font-bold text-gray-800">Catatan Karantina Ikan</h2>
        <p class="text-sm text-gray-600 mt-1">Kelola dan pantau ikan yang sedang karantina</p>
      </div>
      <a href="{{ route('quarantine.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Karantina
      </a>
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

  @if($errors->any())
  <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
    <div class="flex items-center">
      <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
      </svg>
      {{ $errors->first() }}
    </div>
  </div>
  @endif

  <!-- Statistics Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    <!-- Active Quarantine -->
    <div class="bg-white rounded-lg shadow-sm p-5">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600">Karantina Aktif</p>
          <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($activeQuarantine) }} record</p>
        </div>
        <div class="bg-purple-100 p-3 rounded-lg">
          <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Fish in Quarantine -->
    <div class="bg-white rounded-lg shadow-sm p-5">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-sm text-gray-600">Total Ikan Dikarantina</p>
          <p class="text-2xl font-bold text-gray-800 mt-1">{{ number_format($totalQuarantineFish) }} ekor</p>
        </div>
        <div class="bg-orange-100 p-3 rounded-lg">
          <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Filter Tabs -->
  <div class="mb-6 bg-white rounded-lg shadow-sm p-2">
    <div class="flex gap-2">
      <a href="{{ route('quarantine.index') }}"
        class="flex-1 px-4 py-2 text-center rounded-lg transition {{ !request('status') ? 'bg-purple-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        Semua
      </a>
      <a href="{{ route('quarantine.index', ['status' => 'aktif']) }}"
        class="flex-1 px-4 py-2 text-center rounded-lg transition {{ request('status') == 'aktif' ? 'bg-purple-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        Aktif
      </a>
      <a href="{{ route('quarantine.index', ['status' => 'selesai']) }}"
        class="flex-1 px-4 py-2 text-center rounded-lg transition {{ request('status') == 'selesai' ? 'bg-purple-600 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
        Selesai
      </a>
    </div>
  </div>

  <!-- Records Table -->
  <div class="bg-white rounded-lg shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ikan</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Treatment</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @forelse($records as $record)
          <tr class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 whitespace-nowrap">
              @if($record->status === 'aktif')
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                <span class="w-2 h-2 bg-purple-600 rounded-full mr-1.5 animate-pulse"></span>
                Aktif
              </span>
              @else
              <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Selesai
              </span>
              @endif
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">{{ $record->fish->name }}</div>
              <div class="text-xs text-gray-500">{{ $record->fish->type ?? '-' }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="text-sm font-semibold text-purple-600">{{ $record->quantity }} ekor</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
              {{ $record->start_date->format('d M Y') }}
              <div class="text-xs text-gray-500">{{ $record->start_date->format('H:i') }}</div>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="text-sm font-medium text-gray-900">
                {{ $record->duration }} hari
              </div>
              @if($record->status === 'aktif' && $record->isOverdue())
              <span class="text-xs text-red-600 font-medium">⚠️ Terlalu lama</span>
              @endif
            </td>
            <td class="px-6 py-4">
              <span class="text-sm text-gray-700 line-clamp-2">{{ $record->treatment ?: 'Belum ada treatment' }}</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
              <div class="flex items-center gap-2">
                @if($record->status === 'aktif')
                <form action="{{ route('quarantine.complete', $record->id) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="text-green-600 hover:text-green-800" title="Selesaikan Karantina" onclick="return confirm('Tandai karantina sebagai selesai?')">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                  </button>
                </form>
                @endif
                <a href="{{ route('quarantine.show', $record->id) }}" class="text-blue-600 hover:text-blue-800" title="Lihat Detail">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                  </svg>
                </a>
                <a href="{{ route('quarantine.edit', $record->id) }}" class="text-yellow-600 hover:text-yellow-800" title="Edit">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </a>
                <form action="{{ route('quarantine.destroy', $record->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus catatan karantina ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
              <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              <p class="text-lg font-medium">Belum ada catatan karantina</p>
              <p class="text-sm mt-2">Klik tombol "Tambah Karantina" untuk menambah data</p>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($records->hasPages())
    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
      {{ $records->links() }}
    </div>
    @endif
  </div>
</div>
@endsection