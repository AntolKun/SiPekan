@extends('layouts.app')

@section('title', 'Penjualan - Toko Ikan Hias')
@section('page-title', 'Penjualan')

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
      <input type="text" id="searchSales" placeholder="Cari pelanggan atau catatan..."
        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent sm:text-sm">
    </div>
    <a href="{{ route('sales.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all hover:shadow-lg font-medium">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Penjualan
    </a>
  </div>

  <!-- Filter Tabs -->
  <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
    <button class="filter-btn px-4 py-2 bg-primary-600 text-white rounded-xl whitespace-nowrap text-sm font-medium shadow-sm" data-filter="all">
      Semua ({{ $sales->total() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="cash">
      Cash ({{ $sales->where('payment_method', 'cash')->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="transfer">
      Transfer ({{ $sales->where('payment_method', 'transfer')->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="qris">
      QRIS ({{ $sales->where('payment_method', 'qris')->count() }})
    </button>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-green-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Penjualan</p>
        <div class="p-2 bg-green-50 rounded-lg">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($sales->sum('total_amount'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">dari {{ $sales->count() }} transaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-blue-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Hari Ini</p>
        <div class="p-2 bg-blue-50 rounded-lg">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>
      @php
      $todaySales = $sales->filter(function($sale) {
      return $sale->sale_date->isToday();
      });
      @endphp
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($todaySales->sum('total_amount'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">{{ $todaySales->count() }} transaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-purple-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Rata-rata</p>
        <div class="p-2 bg-purple-50 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
          </svg>
        </div>
      </div>
      @php
      $avgSale = $sales->count() > 0 ? $sales->sum('total_amount') / $sales->count() : 0;
      @endphp
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($avgSale, 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">per transaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-orange-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Diskon</p>
        <div class="p-2 bg-orange-50 rounded-lg">
          <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($sales->sum('discount'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">potongan harga</p>
    </div>
  </div>

  <!-- Sales List -->
  <div class="space-y-4" id="salesList">
    @forelse($sales as $sale)
    <div class="sale-item bg-white rounded-2xl shadow-soft p-5 border border-gray-100 hover:shadow-md transition-all"
      data-payment="{{ $sale->payment_method }}"
      data-customer="{{ strtolower($sale->customer ? $sale->customer->name : 'pelanggan umum') }}"
      data-notes="{{ strtolower($sale->notes ?? '') }}">

      <div class="flex flex-col lg:flex-row lg:items-center gap-4">
        <!-- Left: Transaction Info -->
        <div class="flex-1 min-w-0">
          <div class="flex items-start justify-between mb-3">
            <div>
              <div class="flex items-center gap-3 mb-2">
                <h3 class="text-lg font-bold text-gray-800">#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h3>
                @if($sale->payment_method == 'cash')
                <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">💵 Cash</span>
                @elseif($sale->payment_method == 'transfer')
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">🏦 Transfer</span>
                @else
                <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs rounded-full font-semibold">📱 QRIS</span>
                @endif
              </div>
              <p class="text-sm text-gray-600">
                <span class="font-medium">{{ $sale->customer ? $sale->customer->name : 'Pelanggan Umum' }}</span>
                <span class="mx-2">•</span>
                <span>{{ $sale->sale_date->format('d M Y, H:i') }}</span>
              </p>
            </div>
            <div class="text-right">
              <p class="text-2xl font-bold text-green-600">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</p>
              @if($sale->discount > 0)
              <p class="text-xs text-orange-600">Diskon: Rp {{ number_format($sale->discount, 0, ',', '.') }}</p>
              @endif
            </div>
          </div>

          <!-- Items -->
          <div class="bg-gray-50 rounded-xl p-3 mb-3">
            <p class="text-xs text-gray-500 mb-2 font-medium">Item Dibeli:</p>
            <div class="flex flex-wrap gap-2">
              @foreach($sale->items as $item)
              <span class="inline-flex items-center px-3 py-1 bg-white border border-gray-200 rounded-lg text-sm">
                <span class="font-semibold text-gray-800">{{ $item->quantity }}x</span>
                <span class="mx-1 text-gray-400">•</span>
                <span class="text-gray-600">{{ $item->fish->name }}</span>
              </span>
              @endforeach
            </div>
          </div>

          @if($sale->notes)
          <div class="flex items-start gap-2 text-sm text-gray-600 bg-blue-50 p-3 rounded-xl">
            <svg class="w-4 h-4 mt-0.5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="flex-1">{{ $sale->notes }}</p>
          </div>
          @endif
        </div>

        <!-- Right: Actions -->
        <div class="flex lg:flex-col gap-2">
          <a href="{{ route('sales.show', $sale->id) }}"
            class="flex-1 lg:flex-none px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium hover:bg-primary-100 transition text-center border border-primary-200">
            👁️ Detail
          </a>
          <button onclick="printInvoice({{ $sale->id }})"
            class="flex-1 lg:flex-none px-4 py-2 bg-gray-50 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-100 transition border border-gray-200">
            🖨️ Print
          </button>
        </div>
      </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-soft p-12 text-center border border-gray-100">
      <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Transaksi Penjualan</h3>
      <p class="text-gray-500 mb-6">Mulai catat penjualan pertama Anda</p>
      <a href="{{ route('sales.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Penjualan
      </a>
    </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($sales->hasPages())
  <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
    {{ $sales->links() }}
  </div>
  @endif
</div>

<script>
  // Search functionality
  document.getElementById('searchSales').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const salesItems = document.querySelectorAll('.sale-item');

    salesItems.forEach(item => {
      const customer = item.dataset.customer || '';
      const notes = item.dataset.notes || '';
      const searchableText = customer + ' ' + notes;

      if (searchableText.includes(searchTerm)) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  });

  // Filter functionality
  const filterButtons = document.querySelectorAll('.filter-btn');
  filterButtons.forEach(btn => {
    btn.addEventListener('click', function() {
      // Update active button
      filterButtons.forEach(b => {
        b.classList.remove('bg-primary-600', 'text-white', 'shadow-sm');
        b.classList.add('bg-white', 'text-gray-700', 'border', 'border-gray-200');
      });
      this.classList.add('bg-primary-600', 'text-white', 'shadow-sm');
      this.classList.remove('bg-white', 'text-gray-700', 'border', 'border-gray-200');

      // Filter items
      const filter = this.dataset.filter;
      const salesItems = document.querySelectorAll('.sale-item');

      salesItems.forEach(item => {
        if (filter === 'all') {
          item.style.display = 'block';
        } else if (item.dataset.payment === filter) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });

  // Print invoice function
  function printInvoice(saleId) {
    window.open(`/sales/${saleId}/print`, '_blank');
  }
</script>
@endsection