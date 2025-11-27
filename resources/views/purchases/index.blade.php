@extends('layouts.app')

@section('title', 'Pembelian - Toko Ikan Hias')
@section('page-title', 'Pembelian')

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
      <input type="text" id="searchPurchases" placeholder="Cari supplier atau ikan..."
        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent sm:text-sm">
    </div>
    <a href="{{ route('purchases.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all hover:shadow-lg font-medium">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Pembelian
    </a>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-blue-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Pembelian</p>
        <div class="p-2 bg-blue-50 rounded-lg">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($purchases->sum('total_cost'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">dari {{ $purchases->count() }} transaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-green-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Bulan Ini</p>
        <div class="p-2 bg-green-50 rounded-lg">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>
      @php
      $thisMonthPurchases = $purchases->filter(function($p) {
      return $p->purchase_date->isCurrentMonth();
      });
      @endphp
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($thisMonthPurchases->sum('total_cost'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">{{ $thisMonthPurchases->count() }} transaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-purple-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Ikan</p>
        <div class="p-2 bg-purple-50 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ number_format($purchases->sum('quantity'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">ekor dibeli</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-orange-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Biaya Transport</p>
        <div class="p-2 bg-orange-50 rounded-lg">
          <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($purchases->sum('transport_cost'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">total transport</p>
    </div>
  </div>

  <!-- Purchases List -->
  <div class="space-y-4" id="purchasesList">
    @forelse($purchases as $purchase)
    <div class="purchase-item bg-white rounded-2xl shadow-soft p-5 border border-gray-100 hover:shadow-md transition-all"
      data-supplier="{{ strtolower($purchase->supplier->name) }}"
      data-fish="{{ strtolower($purchase->fish->name) }}">

      <div class="flex flex-col lg:flex-row lg:items-center gap-4">
        <!-- Left: Purchase Info -->
        <div class="flex-1 min-w-0">
          <div class="flex items-start justify-between mb-3">
            <div>
              <div class="flex items-center gap-3 mb-2">
                <h3 class="text-lg font-bold text-gray-800">#{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</h3>
                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs rounded-full font-semibold">
                  📦 Pembelian
                </span>
              </div>
              <p class="text-sm text-gray-600">
                <span class="font-medium">{{ $purchase->supplier->name }}</span>
                <span class="mx-2">•</span>
                <span>{{ $purchase->purchase_date->format('d M Y') }}</span>
              </p>
            </div>
            <div class="text-right">
              <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($purchase->total_cost, 0, ',', '.') }}</p>
              @if($purchase->transport_cost > 0)
              <p class="text-xs text-gray-500">+ Transport: Rp {{ number_format($purchase->transport_cost, 0, ',', '.') }}</p>
              @endif
            </div>
          </div>

          <!-- Fish Info -->
          <div class="bg-gray-50 rounded-xl p-4">
            <div class="flex items-center gap-4">
              <div class="w-16 h-16 bg-gray-200 rounded-xl overflow-hidden flex-shrink-0">
                @if($purchase->fish->photo)
                <img src="{{ asset('storage/' . $purchase->fish->photo) }}" alt="{{ $purchase->fish->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-2xl">
                  🐟
                </div>
                @endif
              </div>
              <div class="flex-1 min-w-0">
                <h4 class="font-semibold text-gray-800">{{ $purchase->fish->name }}</h4>
                <div class="flex flex-wrap gap-3 mt-2 text-sm">
                  <span class="text-gray-600">
                    <span class="font-semibold text-gray-800">{{ $purchase->quantity }}</span> ekor
                  </span>
                  <span class="text-gray-400">•</span>
                  <span class="text-gray-600">
                    @ Rp {{ number_format($purchase->price_per_unit, 0, ',', '.') }}
                  </span>
                  <span class="text-gray-400">•</span>
                  <span class="text-green-600 font-semibold">
                    = Rp {{ number_format($purchase->quantity * $purchase->price_per_unit, 0, ',', '.') }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Actions -->
        <div class="flex lg:flex-col gap-2">
          <a href="{{ route('purchases.show', $purchase->id) }}"
            class="flex-1 lg:flex-none px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium hover:bg-primary-100 transition text-center border border-primary-200">
            👁️ Detail
          </a>
          <a href="{{ route('purchases.edit', $purchase->id) }}"
            class="flex-1 lg:flex-none px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-medium hover:bg-blue-100 transition text-center border border-blue-200">
            ✏️ Edit
          </a>
        </div>
      </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-soft p-12 text-center border border-gray-100">
      <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
        </svg>
      </div>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Pembelian</h3>
      <p class="text-gray-500 mb-6">Mulai catat pembelian ikan dari supplier</p>
      <a href="{{ route('purchases.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Pembelian
      </a>
    </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($purchases->hasPages())
  <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
    {{ $purchases->links() }}
  </div>
  @endif
</div>

<script>
  // Search functionality
  document.getElementById('searchPurchases').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const purchaseItems = document.querySelectorAll('.purchase-item');

    purchaseItems.forEach(item => {
      const supplier = item.dataset.supplier || '';
      const fish = item.dataset.fish || '';
      const searchableText = supplier + ' ' + fish;

      if (searchableText.includes(searchTerm)) {
        item.style.display = 'block';
      } else {
        item.style.display = 'none';
      }
    });
  });
</script>
@endsection