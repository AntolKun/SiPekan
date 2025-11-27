@extends('layouts.app')

@section('title', 'Detail Pelanggan - Toko Ikan Hias')
@section('page-title', 'Detail Pelanggan')

@section('content')
<div class="max-w-6xl mx-auto pb-24 lg:pb-6">

  <!-- Header -->
  <div class="bg-white rounded-2xl shadow-soft p-5 mb-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('customers.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
        <div class="flex items-center gap-4">
          <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center">
            <span class="text-3xl font-bold text-purple-600">
              {{ strtoupper(substr($customer->name, 0, 1)) }}
            </span>
          </div>
          <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $customer->name }}</h2>
            <p class="text-sm text-gray-500 mt-1">Informasi lengkap pelanggan</p>
          </div>
        </div>
      </div>
      <a href="{{ route('customers.edit', $customer->id) }}" class="flex items-center px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit
      </a>
    </div>
  </div>

  <div class="grid lg:grid-cols-3 gap-6">

    <!-- Left Column - Customer Info -->
    <div class="lg:col-span-1 space-y-6">

      <!-- Contact Info -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
          Informasi Kontak
        </h3>
        <div class="space-y-4">
          <div>
            <p class="text-xs text-gray-500 mb-1">Nama Lengkap</p>
            <p class="font-semibold text-gray-800">{{ $customer->name }}</p>
          </div>

          @if($customer->phone)
          <div>
            <p class="text-xs text-gray-500 mb-1">Nomor Telepon</p>
            <a href="tel:{{ $customer->phone }}" class="font-semibold text-primary-600 hover:text-primary-700">
              {{ $customer->phone }}
            </a>
          </div>
          @endif

          @if($customer->address)
          <div>
            <p class="text-xs text-gray-500 mb-1">Alamat</p>
            <p class="text-sm text-gray-700 leading-relaxed">{{ $customer->address }}</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Statistics -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Statistik
        </h3>
        <div class="space-y-4">
          <div class="bg-blue-50 rounded-xl p-4 text-center">
            <p class="text-xs text-gray-600 mb-1">Total Transaksi</p>
            <p class="text-3xl font-bold text-blue-600">{{ $customer->purchase_count }}</p>
            <p class="text-xs text-gray-500 mt-1">kali pembelian</p>
          </div>

          <div class="bg-green-50 rounded-xl p-4 text-center">
            <p class="text-xs text-gray-600 mb-1">Total Pembelian</p>
            <p class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPurchase ?? 0, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">nilai transaksi</p>
          </div>

          @if($customer->purchase_count > 0)
          <div class="bg-purple-50 rounded-xl p-4 text-center">
            <p class="text-xs text-gray-600 mb-1">Rata-rata Pembelian</p>
            <p class="text-xl font-bold text-purple-600">Rp {{ number_format(($totalPurchase ?? 0) / $customer->purchase_count, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">per transaksi</p>
          </div>
          @endif
        </div>
      </div>

      <!-- Member Since -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-gray-500 rounded-full mr-3"></span>
          Info Member
        </h3>
        <div class="space-y-3 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-600">Terdaftar Sejak</span>
            <span class="font-semibold text-gray-800">{{ $customer->created_at->format('d M Y') }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Member Selama</span>
            <span class="font-semibold text-gray-800">{{ $customer->created_at->diffForHumans(null, true) }}</span>
          </div>
          @if($lastPurchase)
          <div class="flex justify-between">
            <span class="text-gray-600">Terakhir Belanja</span>
            <span class="font-semibold text-gray-800">{{ $lastPurchase->sale_date->diffForHumans() }}</span>
          </div>
          @endif
          <div class="flex justify-between">
            <span class="text-gray-600">Status</span>
            @if($customer->purchase_count > 0)
            <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">✓ Aktif</span>
            @else
            <span class="px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-semibold">Belum Transaksi</span>
            @endif
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column - Transaction History -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Riwayat Transaksi -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
            Riwayat Transaksi
          </h3>
          @if($customer->sales->count() > 0)
          <a href="{{ route('sales.index') }}?customer={{ $customer->id }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua →
          </a>
          @endif
        </div>

        @if($customer->sales->count() > 0)
        <div class="space-y-4">
          @foreach($customer->sales as $sale)
          <div class="border border-gray-200 rounded-xl p-4 hover:border-primary-300 transition">
            <div class="flex items-start justify-between mb-3">
              <div>
                <div class="flex items-center gap-2 mb-2">
                  <h4 class="font-semibold text-gray-800">#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h4>
                  @if($sale->payment_method == 'cash')
                  <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">💵 Cash</span>
                  @elseif($sale->payment_method == 'transfer')
                  <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">🏦 Transfer</span>
                  @else
                  <span class="px-2 py-1 bg-purple-100 text-purple-700 text-xs rounded-full font-semibold">📱 QRIS</span>
                  @endif
                </div>
                <p class="text-sm text-gray-500">{{ $sale->sale_date->format('d M Y, H:i') }}</p>
              </div>
              <p class="text-xl font-bold text-green-600">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
            </div>

            <!-- Items -->
            <div class="bg-gray-50 rounded-lg p-3">
              <p class="text-xs text-gray-500 mb-2">Item Dibeli:</p>
              <div class="flex flex-wrap gap-2">
                @foreach($sale->items as $item)
                <span class="inline-flex items-center px-2 py-1 bg-white border border-gray-200 rounded-lg text-xs">
                  <span class="font-semibold text-gray-800">{{ $item->quantity }}x</span>
                  <span class="mx-1 text-gray-400">•</span>
                  <span class="text-gray-600">{{ $item->fish->name }}</span>
                </span>
                @endforeach
              </div>
            </div>

            <div class="flex gap-2 mt-3">
              <a href="{{ route('sales.show', $sale->id) }}" class="flex-1 py-2 bg-primary-50 text-primary-700 rounded-lg text-sm font-medium hover:bg-primary-100 transition text-center">
                Detail Transaksi
              </a>
            </div>
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
          <p class="text-gray-500 font-medium mb-2">Belum Ada Transaksi</p>
          <p class="text-sm text-gray-400 mb-4">Pelanggan ini belum pernah melakukan pembelian</p>
          <a href="{{ route('sales.create') }}?customer={{ $customer->id }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-medium text-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Buat Transaksi Baru
          </a>
        </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection