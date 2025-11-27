@extends('layouts.app')

@section('title', 'Detail Supplier - Toko Ikan Hias')
@section('page-title', 'Detail Supplier')

@section('content')
<div class="max-w-6xl mx-auto pb-24 lg:pb-6">

  <!-- Header -->
  <div class="bg-white rounded-2xl shadow-soft p-5 mb-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('suppliers.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
        <div class="flex items-center gap-4">
          <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
          </div>
          <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $supplier->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap supplier</p>
          </div>
        </div>
      </div>
      <a href="{{ route('suppliers.edit', $supplier->id) }}" class="flex items-center px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit
      </a>
    </div>
  </div>

  <div class="grid lg:grid-cols-3 gap-6">

    <!-- Left Column - Supplier Info -->
    <div class="lg:col-span-1 space-y-6">

      <!-- Contact Info -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
          Informasi Kontak
        </h3>
        <div class="space-y-4">
          <div>
            <p class="text-xs text-gray-500 mb-1">Nama Supplier</p>
            <p class="font-semibold text-gray-800">{{ $supplier->name }}</p>
          </div>

          @if($supplier->contact)
          <div>
            <p class="text-xs text-gray-500 mb-1">Kontak</p>
            <a href="tel:{{ $supplier->contact }}" class="font-semibold text-primary-600 hover:text-primary-700">
              {{ $supplier->contact }}
            </a>
          </div>
          @endif

          @if($supplier->address)
          <div>
            <p class="text-xs text-gray-500 mb-1">Alamat</p>
            <p class="text-sm text-gray-700 leading-relaxed">{{ $supplier->address }}</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Quality Score -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Kualitas Supplier
        </h3>
        <div class="space-y-4">
          <div class="text-center bg-green-50 rounded-xl p-6">
            <p class="text-xs text-gray-600 mb-2">Survival Rate</p>
            <p class="text-5xl font-bold text-green-600 mb-2">{{ $supplier->survival_rate }}%</p>
            <div class="w-full bg-gray-200 rounded-full h-3 mb-2">
              <div class="bg-green-500 h-3 rounded-full transition-all duration-500" style="width: {{ $supplier->survival_rate }}%"></div>
            </div>
            <p class="text-xs text-gray-500">Tingkat bertahan hidup ikan</p>
          </div>

          <!-- Quality Badge -->
          @php
          $quality = 'Perlu Evaluasi';
          $qualityColor = 'gray';
          if ($supplier->survival_rate >= 90) {
          $quality = 'Excellent';
          $qualityColor = 'green';
          } elseif ($supplier->survival_rate >= 75) {
          $quality = 'Good';
          $qualityColor = 'blue';
          } elseif ($supplier->survival_rate >= 60) {
          $quality = 'Average';
          $qualityColor = 'yellow';
          } elseif ($supplier->survival_rate > 0) {
          $quality = 'Poor';
          $qualityColor = 'red';
          }
          @endphp

          <div class="text-center">
            <span class="px-4 py-2 bg-{{ $qualityColor }}-100 text-{{ $qualityColor }}-700 rounded-full font-bold text-sm">
              {{ $quality }}
            </span>
          </div>
        </div>
      </div>

      <!-- Statistics -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
          Statistik
        </h3>
        <div class="space-y-4">
          <div class="bg-blue-50 rounded-xl p-4 text-center">
            <p class="text-xs text-gray-600 mb-1">Total Pembelian</p>
            <p class="text-3xl font-bold text-blue-600">{{ $supplier->purchases->count() }}</p>
            <p class="text-xs text-gray-500 mt-1">transaksi</p>
          </div>

          <div class="bg-purple-50 rounded-xl p-4 text-center">
            <p class="text-xs text-gray-600 mb-1">Total Nilai</p>
            <p class="text-2xl font-bold text-purple-600">Rp {{ number_format($totalPurchaseValue ?? 0, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">nilai transaksi</p>
          </div>

          @if($supplier->purchases->count() > 0)
          <div class="bg-orange-50 rounded-xl p-4 text-center">
            <p class="text-xs text-gray-600 mb-1">Rata-rata Pembelian</p>
            <p class="text-xl font-bold text-orange-600">Rp {{ number_format(($totalPurchaseValue ?? 0) / $supplier->purchases->count(), 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">per transaksi</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Registered Info -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-gray-500 rounded-full mr-3"></span>
          Info Supplier
        </h3>
        <div class="space-y-3 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-600">Terdaftar Sejak</span>
            <span class="font-semibold text-gray-800">{{ $supplier->created_at->format('d M Y') }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Supplier Selama</span>
            <span class="font-semibold text-gray-800">{{ $supplier->created_at->diffForHumans(null, true) }}</span>
          </div>
          @if($lastPurchase)
          <div class="flex justify-between">
            <span class="text-gray-600">Terakhir Supply</span>
            <span class="font-semibold text-gray-800">{{ $lastPurchase->purchase_date->diffForHumans() }}</span>
          </div>
          @endif
          <div class="flex justify-between">
            <span class="text-gray-600">Status</span>
            @if($supplier->purchases->count() > 0)
            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">✓ Aktif</span>
            @else
            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-semibold">Belum Supply</span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column - Purchase History -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Riwayat Pembelian -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span>
            Riwayat Pembelian
          </h3>
          @if($supplier->purchases->count() > 0)
          <a href="{{ route('purchases.index') }}?supplier={{ $supplier->id }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua →
          </a>
          @endif
        </div>

        @if($supplier->purchases->count() > 0)
        <div class="space-y-4">
          @foreach($supplier->purchases as $purchase)
          <div class="border border-gray-200 rounded-xl p-4 hover:border-primary-300 transition">
            <div class="flex items-start justify-between mb-3">
              <div>
                <div class="flex items-center gap-2 mb-2">
                  <h4 class="font-semibold text-gray-800">#{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</h4>
                  <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">📦 Pembelian</span>
                </div>
                <p class="text-sm text-gray-500">{{ $purchase->purchase_date->format('d M Y, H:i') }}</p>
              </div>
              <p class="text-xl font-bold text-blue-600">Rp {{ number_format($purchase->total_cost, 0, ',', '.') }}</p>
            </div>

            <!-- Fish Info -->
            <div class="bg-gray-50 rounded-lg p-3 mb-3">
              <div class="flex items-center gap-3">
                <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                  @if($purchase->fish->photo)
                  <img src="{{ asset('storage/' . $purchase->fish->photo) }}" alt="{{ $purchase->fish->name }}" class="w-full h-full object-cover">
                  @else
                  <div class="w-full h-full flex items-center justify-center text-xl">🐟</div>
                  @endif
                </div>
                <div class="flex-1 min-w-0">
                  <p class="font-semibold text-gray-800">{{ $purchase->fish->name }}</p>
                  <p class="text-sm text-gray-600">
                    <span class="font-bold">{{ $purchase->quantity }}</span> ekor ×
                    Rp {{ number_format($purchase->price_per_unit, 0, ',', '.') }}
                  </p>
                </div>
              </div>
            </div>

            @if($purchase->transport_cost > 0)
            <p class="text-xs text-gray-500 mb-3">
              <span class="font-semibold">Biaya Transport:</span> Rp {{ number_format($purchase->transport_cost, 0, ',', '.') }}
            </p>
            @endif

            <a href="{{ route('purchases.show', $purchase->id) }}" class="block w-full py-2 bg-primary-50 text-primary-700 rounded-lg text-sm font-medium hover:bg-primary-100 transition text-center">
              Detail Pembelian
            </a>
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-12">
          <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
          </div>
          <p class="text-gray-500 font-medium mb-2">Belum Ada Pembelian</p>
          <p class="text-sm text-gray-400 mb-4">Supplier ini belum pernah menyuplai ikan</p>
          <a href="{{ route('purchases.create') }}?supplier={{ $supplier->id }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Pembelian Baru
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection