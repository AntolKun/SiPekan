@extends('layouts.app')

@section('title', 'Stok Ikan - Toko Ikan Hias')
@section('page-title', 'Stok Ikan')

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
      <input type="text" id="searchFish" placeholder="Cari nama ikan, warna, atau lokasi..."
        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent sm:text-sm">
    </div>
    <a href="{{ route('fish.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-all hover:shadow-lg font-medium">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Ikan
    </a>
  </div>

  <!-- Filter Tabs -->
  <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
    <button class="filter-btn px-4 py-2 bg-primary-600 text-white rounded-xl whitespace-nowrap text-sm font-medium shadow-sm" data-filter="all">
      Semua ({{ $fish->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="low-stock">
      Stok Rendah ({{ $fish->where('stock', '<', 'minimum_stock')->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="karantina">
      Karantina ({{ $fish->where('health_status', 'karantina')->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="sakit">
      Sakit ({{ $fish->where('health_status', 'sakit')->count() }})
    </button>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-blue-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Stok</p>
        <div class="p-2 bg-blue-50 rounded-lg">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $fish->sum('stock') }}</p>
      <p class="text-xs text-gray-500 mt-1">ekor</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-green-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Jenis Ikan</p>
        <div class="p-2 bg-green-50 rounded-lg">
          <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $fish->count() }}</p>
      <p class="text-xs text-gray-500 mt-1">jenis</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-yellow-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Stok Rendah</p>
        <div class="p-2 bg-yellow-50 rounded-lg">
          <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">{{ $fish->filter(function($f) { return $f->stock < $f->minimum_stock; })->count() }}</p>
      <p class="text-xs text-gray-500 mt-1">jenis</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-purple-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Nilai Stok</p>
        <div class="p-2 bg-purple-50 rounded-lg">
          <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      @php
      $totalValue = $fish->sum(function($f) { return $f->stock * $f->purchase_price; });
      @endphp
      <p class="text-3xl font-bold text-gray-800">{{ number_format($totalValue/1000000, 1) }}jt</p>
      <p class="text-xs text-gray-500 mt-1">rupiah</p>
    </div>
  </div>

  <!-- Fish List -->
  <div class="space-y-4" id="fishList">
    @forelse($fish as $item)
    <div class="fish-item bg-white rounded-2xl shadow-soft p-5 border border-gray-100 hover:shadow-md transition-all {{ $item->stock < $item->minimum_stock ? 'border-l-4 border-l-yellow-500' : '' }}"
      data-status="{{ $item->health_status }}"
      data-stock="{{ $item->stock < $item->minimum_stock ? 'low' : 'normal' }}"
      data-name="{{ strtolower($item->name) }}"
      data-color="{{ strtolower($item->color ?? '') }}"
      data-location="{{ strtolower($item->tank_location ?? '') }}">

      <div class="flex gap-5">
        <!-- Image -->
        <div class="flex-shrink-0">
          <div class="w-24 h-24 bg-gray-100 rounded-2xl overflow-hidden">
            @if($item->photo)
            <img src="{{ asset('storage/' . $item->photo) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
            @else
            <div class="w-full h-full flex items-center justify-center text-4xl">
              🐟
            </div>
            @endif
          </div>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
          <!-- Header -->
          <div class="flex items-start justify-between mb-3">
            <div>
              <h3 class="text-lg font-bold text-gray-800">{{ $item->name }}</h3>
              <p class="text-sm text-gray-500">
                {{ $item->color ?? '-' }}
                @if($item->size)
                • {{ $item->size }}
                @endif
              </p>
            </div>
            <div class="flex gap-2">
              @if($item->health_status == 'sehat')
              <span class="px-3 py-1 bg-green-100 text-green-700 text-xs rounded-full font-medium">✓ Sehat</span>
              @elseif($item->health_status == 'karantina')
              <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs rounded-full font-medium">⚠ Karantina</span>
              @else
              <span class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded-full font-medium">✕ Sakit</span>
              @endif

              @if($item->stock < $item->minimum_stock)
                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs rounded-full font-medium">⚠ Stok Rendah</span>
                @endif
            </div>
          </div>

          <!-- Details Grid -->
          <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <div class="bg-gray-50 rounded-xl p-3">
              <p class="text-xs text-gray-500 mb-1">Stok</p>
              <p class="text-lg font-bold {{ $item->stock < $item->minimum_stock ? 'text-yellow-600' : 'text-gray-800' }}">
                {{ $item->stock }} ekor
              </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-3">
              <p class="text-xs text-gray-500 mb-1">Lokasi</p>
              <p class="text-lg font-bold text-gray-800">{{ $item->tank_location ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-3">
              <p class="text-xs text-gray-500 mb-1">Harga Beli</p>
              <p class="text-lg font-bold text-gray-800">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-xl p-3">
              <p class="text-xs text-gray-500 mb-1">Harga Jual</p>
              <p class="text-lg font-bold text-green-600">Rp {{ number_format($item->selling_price, 0, ',', '.') }}</p>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex gap-2">
            @if($item->stock < $item->minimum_stock)
              <a href="{{ route('purchases.create', ['fish_id' => $item->id]) }}"
                class="flex-1 px-4 py-2 bg-yellow-50 text-yellow-700 rounded-xl text-sm font-medium hover:bg-yellow-100 transition text-center border border-yellow-200">
                📦 Restock
              </a>
              @endif
              <a href="{{ route('fish.edit', $item->id) }}"
                class="flex-1 px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium hover:bg-primary-100 transition text-center border border-primary-200">
                ✏️ Edit
              </a>
              <a href="{{ route('fish.show', $item->id) }}"
                class="px-4 py-2 bg-gray-50 text-gray-700 rounded-xl text-sm font-medium hover:bg-gray-100 transition border border-gray-200">
                Detail →
              </a>
          </div>
        </div>
      </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-soft p-12 text-center border border-gray-100">
      <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
        </svg>
      </div>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Ikan</h3>
      <p class="text-gray-500 mb-6">Mulai tambahkan ikan pertama Anda untuk mengelola stok</p>
      <a href="{{ route('fish.create') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Ikan Pertama
      </a>
    </div>
    @endforelse
  </div>
</div>

<script>
  // Search functionality
  document.getElementById('searchFish').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const fishItems = document.querySelectorAll('.fish-item');

    fishItems.forEach(item => {
      const name = item.dataset.name || '';
      const color = item.dataset.color || '';
      const location = item.dataset.location || '';
      const searchableText = name + ' ' + color + ' ' + location;

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
      const fishItems = document.querySelectorAll('.fish-item');

      fishItems.forEach(item => {
        if (filter === 'all') {
          item.style.display = 'block';
        } else if (filter === 'low-stock' && item.dataset.stock === 'low') {
          item.style.display = 'block';
        } else if (item.dataset.status === filter) {
          item.style.display = 'block';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });
</script>
@endsection