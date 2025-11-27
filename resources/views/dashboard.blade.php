@extends('layouts.app')

@section('title', 'Dashboard - Toko Ikan Hias')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-6 pb-24 lg:pb-6">

  <!-- Welcome Section -->
  <div class="bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl shadow-lg p-6 text-white">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="text-2xl font-bold mb-2">Selamat Datang di Dashboard! 👋</h2>
        <p class="text-primary-100">Kelola bisnis ikan hias Anda dengan mudah</p>
      </div>
      <div class="hidden md:block">
        <div class="text-6xl">🐠</div>
      </div>
    </div>
  </div>

  <!-- Summary Cards Row 1 -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Total Penjualan -->
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-green-500 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <div class="p-3 bg-green-50 rounded-xl">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Total Penjualan</p>
      <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalSales, 0, ',', '.') }}</p>
      <div class="flex items-center gap-2 mt-2">
        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">
          Hari ini: Rp {{ number_format($todaySales, 0, ',', '.') }}
        </span>
      </div>
    </div>

    <!-- Nilai Stok -->
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-blue-500 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <div class="p-3 bg-blue-50 rounded-xl">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
      </div>
      <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Nilai Stok</p>
      <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($totalStockValue, 0, ',', '.') }}</p>
      <div class="flex items-center gap-2 mt-2">
        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">
          {{ $totalFishTypes }} jenis ikan
        </span>
      </div>
    </div>

    <!-- Profit Bulan Ini -->
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-purple-500 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <div class="p-3 bg-purple-50 rounded-xl">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
      </div>
      <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Profit Bulan Ini</p>
      <p class="text-2xl font-bold {{ $monthProfit >= 0 ? 'text-green-600' : 'text-red-600' }}">
        Rp {{ number_format($monthProfit, 0, ',', '.') }}
      </p>
      <div class="flex items-center gap-2 mt-2">
        @if($monthProfit >= 0)
        <span class="px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">
          ↑ Untung
        </span>
        @else
        <span class="px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full font-semibold">
          ↓ Rugi
        </span>
        @endif
      </div>
    </div>

    <!-- Pengeluaran Hari Ini -->
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-orange-500 hover:shadow-md transition-shadow">
      <div class="flex items-center justify-between mb-3">
        <div class="p-3 bg-orange-50 rounded-xl">
          <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
      <p class="text-xs text-gray-500 uppercase tracking-wide font-medium mb-1">Pengeluaran Hari Ini</p>
      <p class="text-2xl font-bold text-gray-800">Rp {{ number_format($todayExpenses, 0, ',', '.') }}</p>
      <div class="flex items-center gap-2 mt-2">
        <span class="px-2 py-1 bg-orange-100 text-orange-700 text-xs rounded-full font-semibold">
          {{ $todayTransactions }} transaksi
        </span>
      </div>
    </div>
  </div>

  <!-- Summary Cards Row 2 (Quick Stats) -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Low Stock Alert -->
    <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs text-gray-500 mb-1">Stok Menipis</p>
          <p class="text-3xl font-bold {{ $lowStockCount > 0 ? 'text-red-600' : 'text-green-600' }}">{{ $lowStockCount }}</p>
        </div>
        <div class="p-3 bg-red-50 rounded-xl">
          <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Customers -->
    <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs text-gray-500 mb-1">Pelanggan</p>
          <p class="text-3xl font-bold text-gray-800">{{ $totalCustomers }}</p>
        </div>
        <div class="p-3 bg-purple-50 rounded-xl">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Total Suppliers -->
    <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs text-gray-500 mb-1">Supplier</p>
          <p class="text-3xl font-bold text-gray-800">{{ $totalSuppliers }}</p>
        </div>
        <div class="p-3 bg-blue-50 rounded-xl">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Today's Transactions -->
    <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs text-gray-500 mb-1">Transaksi Hari Ini</p>
          <p class="text-3xl font-bold text-gray-800">{{ $todayTransactions }}</p>
        </div>
        <div class="p-3 bg-green-50 rounded-xl">
          <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
          </svg>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Content Grid -->
  <div class="grid lg:grid-cols-3 gap-6">

    <!-- Left Column (2/3) -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Weekly Sales Chart -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-800">Penjualan 7 Hari Terakhir</h3>
          <a href="{{ route('sales.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua →
          </a>
        </div>

        <div class="space-y-3">
          @php
          $maxAmount = collect($weeklySales)->max('amount') ?? 1;
          @endphp
          @foreach($weeklySales as $daySale)
          <div class="flex items-center gap-4">
            <div class="w-16 text-sm font-semibold text-gray-700">
              {{ $daySale['day'] }}
              <span class="block text-xs text-gray-500">{{ $daySale['date'] }}</span>
            </div>
            <div class="flex-1">
              <div class="flex items-center justify-between mb-1">
                <div class="flex-1 bg-gray-200 rounded-full h-8 mr-3 overflow-hidden">
                  <div class="bg-gradient-to-r from-green-500 to-green-600 h-8 rounded-full flex items-center justify-end pr-3 transition-all duration-500"
                    style="width: {{ $maxAmount > 0 ? ($daySale['amount'] / $maxAmount * 100) : 0 }}%">
                    @if($daySale['amount'] > 0)
                    <span class="text-xs text-white font-bold">Rp {{ number_format($daySale['amount'] / 1000, 0) }}K</span>
                    @endif
                  </div>
                </div>
                <span class="text-sm font-bold text-gray-800 min-w-[100px] text-right">
                  Rp {{ number_format($daySale['amount'], 0, ',', '.') }}
                </span>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Top Selling Fish -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-800">Ikan Terlaris</h3>
          <a href="{{ route('fish.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua →
          </a>
        </div>

        @if($topSellingFish->count() > 0)
        <div class="space-y-3">
          @foreach($topSellingFish as $fish)
          <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
            <div class="w-14 h-14 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
              @if($fish->photo)
              <img src="{{ asset('storage/' . $fish->photo) }}" alt="{{ $fish->name }}" class="w-full h-full object-cover">
              @else
              <div class="w-full h-full flex items-center justify-center text-2xl">
                🐟
              </div>
              @endif
            </div>
            <div class="flex-1 min-w-0">
              <h4 class="font-semibold text-gray-800 truncate">{{ $fish->name }}</h4>
              <p class="text-sm text-gray-500">Stok: {{ $fish->stock }} ekor</p>
            </div>
            <div class="text-right">
              <p class="text-lg font-bold text-green-600">{{ $fish->total_sold }}</p>
              <p class="text-xs text-gray-500">terjual</p>
            </div>
          </div>
          @endforeach
        </div>
        @else
        <div class="text-center py-8">
          <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
          </div>
          <p class="text-gray-500 text-sm">Belum ada data penjualan</p>
        </div>
        @endif
      </div>

      <!-- Recent Activities -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5">Aktivitas Terakhir</h3>

        @if($recentActivities->count() > 0)
        <div class="space-y-3">
          @foreach($recentActivities as $activity)
          <a href="{{ $activity['url'] }}" class="block p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
            <div class="flex items-center gap-4">
              <div class="w-10 h-10 bg-{{ $activity['color'] }}-100 rounded-xl flex items-center justify-center flex-shrink-0">
                <span class="text-xl">{{ $activity['icon'] }}</span>
              </div>
              <div class="flex-1 min-w-0">
                <div class="flex items-center justify-between mb-1">
                  <h4 class="font-semibold text-gray-800">{{ $activity['title'] }}</h4>
                  <span class="text-sm font-bold text-{{ $activity['color'] }}-600">
                    {{ $activity['type'] == 'sale' ? '+' : '-' }} Rp {{ number_format($activity['amount'], 0, ',', '.') }}
                  </span>
                </div>
                <p class="text-sm text-gray-600 truncate">{{ $activity['description'] }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $activity['date']->diffForHumans() }}</p>
              </div>
            </div>
          </a>
          @endforeach
        </div>
        @else
        <div class="text-center py-8">
          <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
          </div>
          <p class="text-gray-500 text-sm">Belum ada aktivitas</p>
        </div>
        @endif
      </div>
    </div>

    <!-- Right Column (1/3) -->
    <div class="space-y-6">

      <!-- Low Stock Alert -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-5">
          <h3 class="text-lg font-bold text-gray-800">⚠️ Stok Menipis</h3>
          <a href="{{ route('fish.index') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua →
          </a>
        </div>

        @if($lowStockFish->count() > 0)
        <div class="space-y-3">
          @foreach($lowStockFish as $fish)
          <a href="{{ route('fish.show', $fish->id) }}" class="block p-3 border-l-4 border-red-500 bg-red-50 rounded-xl hover:bg-red-100 transition">
            <div class="flex items-center gap-3">
              <div class="w-12 h-12 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                @if($fish->photo)
                <img src="{{ asset('storage/' . $fish->photo) }}" alt="{{ $fish->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-xl">
                  🐟
                </div>
                @endif
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-gray-800 truncate">{{ $fish->name }}</h4>
                <p class="text-sm text-red-600 font-bold">Sisa: {{ $fish->stock }} ekor</p>
              </div>
            </div>
          </a>
          @endforeach
        </div>
        <a href="{{ route('purchases.create') }}" class="block mt-4 w-full py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition text-center font-semibold">
          📦 Restock Sekarang
        </a>
        @else
        <div class="text-center py-8">
          <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <p class="text-green-600 font-semibold">Stok Aman! ✅</p>
          <p class="text-gray-500 text-sm mt-1">Semua ikan stok mencukupi</p>
        </div>
        @endif
      </div>

      <!-- Quick Actions -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5">⚡ Aksi Cepat</h3>
        <div class="space-y-3">
          <a href="{{ route('sales.create') }}" class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl hover:bg-green-100 transition group">
            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-gray-800">Tambah Penjualan</p>
              <p class="text-xs text-gray-500">Catat transaksi baru</p>
            </div>
          </a>

          <a href="{{ route('purchases.create') }}" class="flex items-center gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition group">
            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-gray-800">Tambah Pembelian</p>
              <p class="text-xs text-gray-500">Restock ikan dari supplier</p>
            </div>
          </a>

          <a href="{{ route('expenses.create') }}" class="flex items-center gap-3 p-4 bg-orange-50 border border-orange-200 rounded-xl hover:bg-orange-100 transition group">
            <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-gray-800">Tambah Pengeluaran</p>
              <p class="text-xs text-gray-500">Catat biaya operasional</p>
            </div>
          </a>

          <a href="{{ route('fish.create') }}" class="flex items-center gap-3 p-4 bg-purple-50 border border-purple-200 rounded-xl hover:bg-purple-100 transition group">
            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center group-hover:scale-110 transition">
              <span class="text-2xl">🐠</span>
            </div>
            <div class="flex-1">
              <p class="font-semibold text-gray-800">Tambah Ikan Baru</p>
              <p class="text-xs text-gray-500">Daftarkan jenis ikan baru</p>
            </div>
          </a>
        </div>
      </div>

      <!-- System Info -->
      <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-2xl shadow-soft p-6 border border-primary-200">
        <h3 class="text-lg font-bold text-gray-800 mb-4">💡 Tips</h3>
        <ul class="space-y-2 text-sm text-gray-700">
          <li class="flex items-start gap-2">
            <span class="text-primary-600 mt-1">•</span>
            <span>Restock ikan saat stok di bawah 10 ekor</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-primary-600 mt-1">•</span>
            <span>Pantau survival rate supplier secara berkala</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-primary-600 mt-1">•</span>
            <span>Catat semua pengeluaran untuk laporan akurat</span>
          </li>
          <li class="flex items-start gap-2">
            <span class="text-primary-600 mt-1">•</span>
            <span>Backup data secara rutin</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>
@endsection