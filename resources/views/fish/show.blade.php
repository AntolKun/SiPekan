@extends('layouts.app')

@section('title', 'Detail Ikan - Toko Ikan Hias')
@section('page-title', 'Detail Ikan')

@section('content')
<div class="max-w-6xl mx-auto pb-24 lg:pb-6">

  <!-- Header -->
  <div class="bg-white rounded-2xl shadow-soft p-5 mb-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('fish.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
        <div>
          <h2 class="text-2xl font-bold text-gray-800">{{ $fish->name }}</h2>
          <p class="text-sm text-gray-500 mt-1">Detail informasi lengkap ikan</p>
        </div>
      </div>
      <a href="{{ route('fish.edit', $fish->id) }}" class="flex items-center px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit
      </a>
    </div>
  </div>

  <div class="grid lg:grid-cols-3 gap-6">

    <!-- Left Column - Image & Quick Info -->
    <div class="lg:col-span-1 space-y-6">

      <!-- Foto -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <div class="relative">
          @if($fish->photo)
          <img src="{{ asset('storage/' . $fish->photo) }}" alt="{{ $fish->name }}" class="w-full h-80 object-cover rounded-2xl">
          @else
          <div class="w-full h-80 bg-gray-100 rounded-2xl flex items-center justify-center">
            <span class="text-8xl">🐟</span>
          </div>
          @endif

          <!-- Status Badge Overlay -->
          <div class="absolute top-4 right-4 flex flex-col gap-2">
            @if($fish->health_status == 'sehat')
            <span class="px-3 py-2 bg-green-500 text-white text-xs rounded-xl font-semibold shadow-lg backdrop-blur-sm bg-opacity-90">
              ✓ Sehat
            </span>
            @elseif($fish->health_status == 'karantina')
            <span class="px-3 py-2 bg-orange-500 text-white text-xs rounded-xl font-semibold shadow-lg backdrop-blur-sm bg-opacity-90">
              ⚠ Karantina
            </span>
            @else
            <span class="px-3 py-2 bg-red-500 text-white text-xs rounded-xl font-semibold shadow-lg backdrop-blur-sm bg-opacity-90">
              ✕ Sakit
            </span>
            @endif

            @if($fish->stock < $fish->minimum_stock)
              <span class="px-3 py-2 bg-yellow-500 text-white text-xs rounded-xl font-semibold shadow-lg backdrop-blur-sm bg-opacity-90">
                ⚠ Stok Rendah
              </span>
              @endif
          </div>
        </div>
      </div>

      <!-- Status Card -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-primary-500 rounded-full mr-3"></span>
          Status & Kondisi
        </h3>
        <div class="space-y-3">
          <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
            <span class="text-sm text-gray-600 font-medium">Kesehatan</span>
            @if($fish->health_status == 'sehat')
            <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full font-semibold">✅ Sehat</span>
            @elseif($fish->health_status == 'karantina')
            <span class="px-3 py-1 bg-orange-100 text-orange-700 text-sm rounded-full font-semibold">⚠️ Karantina</span>
            @else
            <span class="px-3 py-1 bg-red-100 text-red-700 text-sm rounded-full font-semibold">❌ Sakit</span>
            @endif
          </div>
          <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
            <span class="text-sm text-gray-600 font-medium">Stok Tersedia</span>
            @if($fish->stock < $fish->minimum_stock)
              <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm rounded-full font-bold">
                {{ $fish->stock }} ekor (Rendah!)
              </span>
              @else
              <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full font-bold">
                {{ $fish->stock }} ekor
              </span>
              @endif
          </div>
          <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
            <span class="text-sm text-gray-600 font-medium">Min. Stok</span>
            <span class="text-sm font-semibold text-gray-800">{{ $fish->minimum_stock }} ekor</span>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Aksi Cepat
        </h3>
        <div class="space-y-2">
          <a href="{{ route('sales.create') }}?fish_id={{ $fish->id }}"
            class="block w-full py-3 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition text-center text-sm font-semibold border border-green-200">
            💰 Jual Ikan Ini
          </a>
          <a href="{{ route('purchases.create') }}?fish_id={{ $fish->id }}"
            class="block w-full py-3 bg-blue-50 text-blue-700 rounded-xl hover:bg-blue-100 transition text-center text-sm font-semibold border border-blue-200">
            📦 Restock Ikan
          </a>
          @if($fish->health_status != 'karantina')
          <a href="{{ route('quarantine.create') }}?fish_id={{ $fish->id }}"
            class="block w-full py-3 bg-orange-50 text-orange-700 rounded-xl hover:bg-orange-100 transition text-center text-sm font-semibold border border-orange-200">
            🏥 Masukkan Karantina
          </a>
          @endif
          <a href="{{ route('mortality.create') }}?fish_id={{ $fish->id }}"
            class="block w-full py-3 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition text-center text-sm font-semibold border border-red-200">
            📝 Catat Kematian
          </a>
        </div>
      </div>
    </div>

    <!-- Right Column - Details & Statistics -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Informasi Dasar -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
          Informasi Dasar
        </h3>
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-5">
          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Nama Ikan</p>
            <p class="text-lg font-bold text-gray-800">{{ $fish->name }}</p>
          </div>
          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Jenis/Type</p>
            <p class="text-lg font-bold text-gray-800">{{ $fish->type ?? '-' }}</p>
          </div>
          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Ukuran</p>
            <p class="text-lg font-bold text-gray-800">{{ $fish->size ?? '-' }}</p>
          </div>
          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Warna</p>
            <p class="text-lg font-bold text-gray-800">{{ $fish->color ?? '-' }}</p>
          </div>
          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Lokasi Tank</p>
            <p class="text-lg font-bold text-gray-800">{{ $fish->tank_location ?? '-' }}</p>
          </div>
          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Ditambahkan</p>
            <p class="text-lg font-bold text-gray-800">{{ $fish->created_at->format('d M Y') }}</p>
          </div>
        </div>
      </div>

      <!-- Informasi Harga & Laba -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Informasi Harga & Laba
        </h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
          <div class="bg-blue-50 rounded-2xl p-5 border border-blue-100">
            <div class="flex items-center justify-between mb-2">
              <p class="text-xs text-gray-600 font-medium uppercase">Harga Beli</p>
              <div class="p-2 bg-blue-100 rounded-lg">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
              </div>
            </div>
            <p class="text-2xl font-bold text-blue-700">Rp {{ number_format($fish->purchase_price, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">per ekor</p>
          </div>

          <div class="bg-green-50 rounded-2xl p-5 border border-green-100">
            <div class="flex items-center justify-between mb-2">
              <p class="text-xs text-gray-600 font-medium uppercase">Harga Jual</p>
              <div class="p-2 bg-green-100 rounded-lg">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
            </div>
            <p class="text-2xl font-bold text-green-700">Rp {{ number_format($fish->selling_price, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">per ekor</p>
          </div>

          <div class="bg-purple-50 rounded-2xl p-5 border border-purple-100">
            <div class="flex items-center justify-between mb-2">
              <p class="text-xs text-gray-600 font-medium uppercase">Laba per Ekor</p>
              <div class="p-2 bg-purple-100 rounded-lg">
                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
            </div>
            <p class="text-2xl font-bold text-purple-700">Rp {{ number_format($fish->selling_price - $fish->purchase_price, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">profit</p>
          </div>

          <div class="bg-orange-50 rounded-2xl p-5 border border-orange-100">
            <div class="flex items-center justify-between mb-2">
              <p class="text-xs text-gray-600 font-medium uppercase">Margin</p>
              <div class="p-2 bg-orange-100 rounded-lg">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
              </div>
            </div>
            <p class="text-2xl font-bold text-orange-700">{{ number_format($fish->profit_margin, 1) }}%</p>
            <p class="text-xs text-gray-500 mt-1">profit margin</p>
          </div>
        </div>
      </div>

      <!-- Statistik Stok -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
          Statistik Stok & Transaksi
        </h3>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">
          <div class="text-center p-5 bg-gray-50 rounded-2xl">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Stok Saat Ini</p>
            <p class="text-3xl font-bold text-gray-800">{{ $fish->stock }}</p>
            <p class="text-xs text-gray-500 mt-1">ekor</p>
          </div>

          <div class="text-center p-5 bg-gray-50 rounded-2xl">
            <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
              <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Nilai Stok</p>
            <p class="text-3xl font-bold text-gray-800">{{ number_format(($fish->stock * $fish->purchase_price)/1000, 0) }}k</p>
            <p class="text-xs text-gray-500 mt-1">rupiah</p>
          </div>

          <div class="text-center p-5 bg-gray-50 rounded-2xl">
            <div class="w-16 h-16 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
              <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Terjual</p>
            <p class="text-3xl font-bold text-gray-800">{{ $fish->saleItems->sum('quantity') ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">ekor</p>
          </div>

          <div class="text-center p-5 bg-gray-50 rounded-2xl">
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
              <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <p class="text-sm text-gray-500 mb-1">Total Dibeli</p>
            <p class="text-3xl font-bold text-gray-800">{{ $fish->purchases->sum('quantity') ?? 0 }}</p>
            <p class="text-xs text-gray-500 mt-1">ekor</p>
          </div>
        </div>
      </div>

      <!-- Riwayat Penjualan -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
            Riwayat Penjualan
          </h3>
          <a href="{{ route('sales.index') }}?fish={{ $fish->id }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua →
          </a>
        </div>
        @if($fish->saleItems->count() > 0)
        <div class="space-y-3">
          @foreach($fish->saleItems->take(5) as $item)
          <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-800">{{ $item->quantity }} ekor - Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $item->created_at->diffForHumans() }}</p>
              </div>
            </div>
            <a href="{{ route('sales.show', $item->sale_id) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
              Detail →
            </a>
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-12">
          <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
          </div>
          <p class="text-gray-500 font-medium">Belum ada penjualan</p>
          <p class="text-sm text-gray-400 mt-1">Ikan ini belum pernah terjual</p>
        </div>
        @endif
      </div>

      <!-- Riwayat Pembelian -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
            Riwayat Pembelian (Restock)
          </h3>
          <a href="{{ route('purchases.index') }}?fish={{ $fish->id }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua →
          </a>
        </div>
        @if($fish->purchases->count() > 0)
        <div class="space-y-3">
          @foreach($fish->purchases->take(5) as $purchase)
          <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
            <div class="flex items-center gap-4">
              <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-semibold text-gray-800">{{ $purchase->quantity }} ekor dari {{ $purchase->supplier->name }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $purchase->purchase_date->format('d M Y') }} - Rp {{ number_format($purchase->total_cost, 0, ',', '.') }}</p>
              </div>
            </div>
            <a href="{{ route('purchases.show', $purchase->id) }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
              Detail →
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
          <p class="text-gray-500 font-medium">Belum ada pembelian</p>
          <p class="text-sm text-gray-400 mt-1">Belum ada riwayat pembelian ikan ini</p>
        </div>
        @endif
      </div>

    </div>
  </div>
</div>
@endsection