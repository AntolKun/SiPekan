@extends('layouts.app')

@section('title', 'Pelanggan - Toko Ikan Hias')
@section('page-title', 'Pelanggan')

@section('content')
<div class="space-y-6 pb-24 lg:pb-6">

  <!-- Header Actions -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div class="relative flex-1 max-w-md">
      <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input type="text" id="searchCustomers" placeholder="Cari nama atau telepon..."
        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent sm:text-sm">
    </div>
    <a href="{{ route('customers.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition-all hover:shadow-lg font-medium">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Pelanggan
    </a>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-purple-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Pelanggan</p>
        <div class="p-2 bg-purple-50 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $totalCustomers ?? $customers->count() }}</p>
      <p class="text-xs text-gray-500 mt-1">pelanggan terdaftar</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-green-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Pelanggan Aktif</p>
        <div class="p-2 bg-green-50 rounded-lg">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $activeCustomers ?? 0 }}</p>
      <p class="text-xs text-gray-500 mt-1">pernah bertransaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-blue-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Transaksi</p>
        <div class="p-2 bg-blue-50 rounded-lg">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $customers->sum('purchase_count') }}</p>
      <p class="text-xs text-gray-500 mt-1">total pembelian</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-orange-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Rata-rata</p>
        <div class="p-2 bg-orange-50 rounded-lg">
          <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </div>
      </div>
      @php
      $avgPurchase = $activeCustomers > 0 ? $customers->sum('purchase_count') / $activeCustomers : 0;
      @endphp
      <p class="text-3xl font-bold text-gray-800">{{ number_format($avgPurchase, 1) }}</p>
      <p class="text-xs text-gray-500 mt-1">transaksi per pelanggan</p>
    </div>
  </div>

  <!-- Customers List -->
  <div class="space-y-4" id="customersList">
    @forelse($customers as $customer)
    <div class="customer-item bg-white rounded-2xl shadow-soft p-5 border border-gray-100 hover:shadow-md transition-all"
      data-name="{{ strtolower($customer->name) }}"
      data-phone="{{ strtolower($customer->phone ?? '') }}">

      <div class="flex items-center gap-5">
        <!-- Avatar -->
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center">
            <span class="text-2xl font-bold text-purple-600">
              {{ strtoupper(substr($customer->name, 0, 1)) }}
            </span>
          </div>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
          <div class="flex items-start justify-between mb-2">
            <div>
              <h3 class="text-lg font-bold text-gray-800">{{ $customer->name }}</h3>
              <div class="flex flex-wrap items-center gap-3 mt-1 text-sm text-gray-600">
                @if($customer->phone)
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  {{ $customer->phone }}
                </span>
                @endif
                @if($customer->address)
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span class="truncate max-w-xs">{{ $customer->address }}</span>
                </span>
                @endif
              </div>
            </div>

            <!-- Stats -->
            <div class="text-right">
              @if($customer->purchase_count > 0)
              <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">
                ✓ Aktif
              </span>
              @else
              <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-semibold">
                Belum Transaksi
              </span>
              @endif
            </div>
          </div>

          <!-- Purchase Info -->
          <div class="bg-gray-50 rounded-xl p-3 mt-3">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-6 text-sm">
                <div>
                  <p class="text-xs text-gray-500 mb-1">Total Transaksi</p>
                  <p class="text-lg font-bold text-gray-800">{{ $customer->purchase_count }}x</p>
                </div>
                <div>
                  <p class="text-xs text-gray-500 mb-1">Total Pembelian</p>
                  <p class="text-lg font-bold text-green-600">Rp {{ number_format($customer->total_purchase_amount, 0, ',', '.') }}</p>
                </div>
                @if($customer->last_purchase_date)
                <div>
                  <p class="text-xs text-gray-500 mb-1">Terakhir Beli</p>
                  <p class="text-sm font-semibold text-gray-700">{{ $customer->last_purchase_date->diffForHumans() }}</p>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-2">
          <a href="{{ route('customers.show', $customer->id) }}"
            class="px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium hover:bg-primary-100 transition text-center border border-primary-200">
            👁️ Detail
          </a>
          <a href="{{ route('customers.edit', $customer->id) }}"
            class="px-4 py-2 bg-purple-50 text-purple-700 rounded-xl text-sm font-medium hover:bg-purple-100 transition text-center border border-purple-200">
            ✏️ Edit
          </a>
        </div>
      </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-soft p-12 text-center border border-gray-100">
      <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Pelanggan</h3>
      <p class="text-gray-500 mb-6">Mulai tambahkan data pelanggan Anda</p>
      <a href="{{ route('customers.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Pelanggan
      </a>
    </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($customers->hasPages())
  <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
    {{ $customers->links() }}
  </div>
  @endif
</div>

<script>
  // Search functionality
  document.getElementById('searchCustomers').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const customerItems = document.querySelectorAll('.customer-item');

    customerItems.forEach(item => {
      const name = item.dataset.name || '';
      const phone = item.dataset.phone || '';
      const searchableText = name + ' ' + phone;

      if (searchableText.includes(searchTerm)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  });
</script>
@endsection