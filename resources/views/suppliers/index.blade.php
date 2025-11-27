@extends('layouts.app')

@section('title', 'Supplier - Toko Ikan Hias')
@section('page-title', 'Supplier')

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
      <input type="text" id="searchSuppliers" placeholder="Cari nama supplier atau kontak..."
        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent sm:text-sm">
    </div>
    <a href="{{ route('suppliers.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-all hover:shadow-lg font-medium">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Supplier
    </a>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-blue-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Supplier</p>
        <div class="p-2 bg-blue-50 rounded-lg">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $totalSuppliers ?? $suppliers->count() }}</p>
      <p class="text-xs text-gray-500 mt-1">supplier terdaftar</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-green-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Supplier Aktif</p>
        <div class="p-2 bg-green-50 rounded-lg">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $activeSuppliers ?? 0 }}</p>
      <p class="text-xs text-gray-500 mt-1">pernah supply</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-purple-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Pembelian</p>
        <div class="p-2 bg-purple-50 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($suppliers->sum('purchases_sum_total_cost') ?? 0, 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">nilai pembelian</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-orange-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Avg Survival Rate</p>
        <div class="p-2 bg-orange-50 rounded-lg">
          <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
          </svg>
        </div>
      </div>
      @php
      $avgSurvival = $suppliers->where('survival_rate', '>', 0)->avg('survival_rate') ?? 0;
      @endphp
      <p class="text-3xl font-bold text-gray-800">{{ number_format($avgSurvival, 1) }}%</p>
      <p class="text-xs text-gray-500 mt-1">rata-rata kualitas</p>
    </div>
  </div>

  <!-- Suppliers List -->
  <div class="space-y-4" id="suppliersList">
    @forelse($suppliers as $supplier)
    <div class="supplier-item bg-white rounded-2xl shadow-soft p-5 border border-gray-100 hover:shadow-md transition-all"
      data-name="{{ strtolower($supplier->name) }}"
      data-contact="{{ strtolower($supplier->contact ?? '') }}">

      <div class="flex items-center gap-5">
        <!-- Icon -->
        <div class="flex-shrink-0">
          <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
          </div>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
          <div class="flex items-start justify-between mb-2">
            <div>
              <h3 class="text-lg font-bold text-gray-800">{{ $supplier->name }}</h3>
              <div class="flex flex-wrap items-center gap-3 mt-1 text-sm text-gray-600">
                @if($supplier->contact)
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                  </svg>
                  {{ $supplier->contact }}
                </span>
                @endif
                @if($supplier->address)
                <span class="flex items-center gap-1">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span class="truncate max-w-xs">{{ $supplier->address }}</span>
                </span>
                @endif
              </div>
            </div>

            <!-- Status -->
            <div class="text-right">
              @if($supplier->purchases_count > 0)
              <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-semibold">
                ✓ Aktif
              </span>
              @else
              <span class="px-3 py-1 bg-gray-100 text-gray-600 text-xs rounded-full font-semibold">
                Belum Supply
              </span>
              @endif
            </div>
          </div>

          <!-- Purchase Info & Survival Rate -->
          <div class="bg-gray-50 rounded-xl p-4 mt-3">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-6 text-sm">
                <div>
                  <p class="text-xs text-gray-500 mb-1">Total Pembelian</p>
                  <p class="text-lg font-bold text-gray-800">{{ $supplier->purchases_count }}x</p>
                </div>
                <div>
                  <p class="text-xs text-gray-500 mb-1">Nilai Transaksi</p>
                  <p class="text-lg font-bold text-blue-600">Rp {{ number_format($supplier->purchases_sum_total_cost ?? 0, 0, ',', '.') }}</p>
                </div>
                <div>
                  <p class="text-xs text-gray-500 mb-1">Survival Rate</p>
                  <div class="flex items-center gap-2">
                    <div class="w-24 bg-gray-200 rounded-full h-2">
                      <div class="bg-green-500 h-2 rounded-full" style="width: {{ $supplier->survival_rate }}%"></div>
                    </div>
                    <span class="text-sm font-bold text-green-600">{{ $supplier->survival_rate }}%</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-2">
          <a href="{{ route('suppliers.show', $supplier->id) }}"
            class="px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium hover:bg-primary-100 transition text-center border border-primary-200">
            👁️ Detail
          </a>
          <a href="{{ route('suppliers.edit', $supplier->id) }}"
            class="px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-medium hover:bg-blue-100 transition text-center border border-blue-200">
            ✏️ Edit
          </a>
        </div>
      </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-soft p-12 text-center border border-gray-100">
      <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
        </svg>
      </div>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Supplier</h3>
      <p class="text-gray-500 mb-6">Mulai tambahkan supplier untuk pembelian ikan</p>
      <a href="{{ route('suppliers.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Supplier
      </a>
    </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($suppliers->hasPages())
  <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
    {{ $suppliers->links() }}
  </div>
  @endif
</div>

<script>
  // Search functionality
  document.getElementById('searchSuppliers').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const supplierItems = document.querySelectorAll('.supplier-item');

    supplierItems.forEach(item => {
      const name = item.dataset.name || '';
      const contact = item.dataset.contact || '';
      const searchableText = name + ' ' + contact;

      if (searchableText.includes(searchTerm)) {
        item.style.display = 'flex';
      } else {
        item.style.display = 'none';
      }
    });
  });
</script>
@endsection