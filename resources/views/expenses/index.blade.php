@extends('layouts.app')

@section('title', 'Pengeluaran - Toko Ikan Hias')
@section('page-title', 'Pengeluaran')

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
      <input type="text" id="searchExpenses" placeholder="Cari deskripsi pengeluaran..."
        class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent sm:text-sm">
    </div>
    <a href="{{ route('expenses.create') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition-all hover:shadow-lg font-medium">
      <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
      </svg>
      Tambah Pengeluaran
    </a>
  </div>

  <!-- Filter Tabs -->
  <div class="flex space-x-2 overflow-x-auto pb-2 scrollbar-hide">
    <button class="filter-btn px-4 py-2 bg-primary-600 text-white rounded-xl whitespace-nowrap text-sm font-medium shadow-sm" data-filter="all">
      Semua ({{ $expenses->total() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="pakan">
      🥘 Pakan ({{ $expenses->where('category', 'pakan')->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="listrik">
      ⚡ Listrik ({{ $expenses->where('category', 'listrik')->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="gaji">
      👤 Gaji ({{ $expenses->where('category', 'gaji')->count() }})
    </button>
    <button class="filter-btn px-4 py-2 bg-white text-gray-700 border border-gray-200 rounded-xl hover:bg-gray-50 whitespace-nowrap text-sm font-medium" data-filter="sewa">
      🏠 Sewa ({{ $expenses->where('category', 'sewa')->count() }})
    </button>
  </div>

  <!-- Summary Cards -->
  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-orange-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Pengeluaran</p>
        <div class="p-2 bg-orange-50 rounded-lg">
          <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($expenses->sum('amount'), 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">dari {{ $expenses->count() }} transaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-red-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Bulan Ini</p>
        <div class="p-2 bg-red-50 rounded-lg">
          <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
      </div>
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($monthlyTotal ?? 0, 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">pengeluaran bulan ini</p>
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
      $avgExpense = $expenses->count() > 0 ? $expenses->sum('amount') / $expenses->count() : 0;
      @endphp
      <p class="text-3xl font-bold text-gray-800">Rp {{ number_format($avgExpense, 0, ',', '.') }}</p>
      <p class="text-xs text-gray-500 mt-1">per transaksi</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft p-5 border-l-4 border-blue-500">
      <div class="flex items-center justify-between mb-2">
        <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Kategori Terbanyak</p>
        <div class="p-2 bg-blue-50 rounded-lg">
          <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
          </svg>
        </div>
      </div>
      @php
      $topCategory = $expenses->groupBy('category')->sortByDesc(function($group) {
      return $group->sum('amount');
      })->first();
      $topCategoryName = $topCategory ? \App\Models\Expense::$categories[$topCategory->first()->category] : '-';
      @endphp
      <p class="text-2xl font-bold text-gray-800">{{ $topCategoryName }}</p>
      <p class="text-xs text-gray-500 mt-1">kategori terbesar</p>
    </div>
  </div>

  <!-- Expenses by Category -->
  <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-5">Pengeluaran per Kategori (Bulan Ini)</h3>
    <div class="space-y-3">
      @php
      $categoriesData = $expenses->filter(function($e) {
      return $e->expense_date->isCurrentMonth();
      })->groupBy('category')->map(function($group) {
      return [
      'total' => $group->sum('amount'),
      'count' => $group->count(),
      ];
      })->sortByDesc('total');

      $maxAmount = $categoriesData->max('total') ?? 1;
      @endphp

      @forelse($categoriesData as $category => $data)
      <div class="flex items-center gap-4">
        <span class="text-2xl w-10">{{ ['pakan' => '🥘', 'listrik' => '⚡', 'air_treatment' => '💧', 'gaji' => '👤', 'sewa' => '🏠', 'peralatan' => '🔧', 'maintenance' => '🛠️', 'lainnya' => '📝'][$category] ?? '📝' }}</span>
        <div class="flex-1">
          <div class="flex items-center justify-between mb-1">
            <span class="text-sm font-medium text-gray-700">{{ \App\Models\Expense::$categories[$category] ?? $category }}</span>
            <span class="text-sm font-bold text-gray-800">Rp {{ number_format($data['total'], 0, ',', '.') }}</span>
          </div>
          <div class="flex items-center gap-2">
            <div class="flex-1 bg-gray-200 rounded-full h-2">
              <div class="bg-orange-500 h-2 rounded-full transition-all duration-500" style="width: {{ ($data['total'] / $maxAmount) * 100 }}%"></div>
            </div>
            <span class="text-xs text-gray-500">{{ $data['count'] }}x</span>
          </div>
        </div>
      </div>
      @empty
      <div class="text-center py-8">
        <p class="text-gray-500">Belum ada pengeluaran bulan ini</p>
      </div>
      @endforelse
    </div>
  </div>

  <!-- Expenses List -->
  <div class="space-y-4" id="expensesList">
    @forelse($expenses as $expense)
    <div class="expense-item bg-white rounded-2xl shadow-soft p-5 border border-gray-100 hover:shadow-md transition-all"
      data-category="{{ $expense->category }}"
      data-description="{{ strtolower($expense->description) }}">

      <div class="flex items-center gap-4">
        <!-- Icon -->
        <div class="flex-shrink-0">
          <div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-2xl">
            {{ ['pakan' => '🥘', 'listrik' => '⚡', 'air_treatment' => '💧', 'gaji' => '👤', 'sewa' => '🏠', 'peralatan' => '🔧', 'maintenance' => '🛠️', 'lainnya' => '📝'][$expense->category] ?? '📝' }}
          </div>
        </div>

        <!-- Content -->
        <div class="flex-1 min-w-0">
          <div class="flex items-start justify-between mb-2">
            <div>
              <h3 class="text-lg font-bold text-gray-800">{{ $expense->description }}</h3>
              <div class="flex items-center gap-2 mt-1">
                <span class="px-3 py-1 bg-orange-100 text-orange-700 text-xs rounded-full font-semibold">
                  {{ $expense->category_label }}
                </span>
                <span class="text-sm text-gray-500">{{ $expense->expense_date->format('d M Y, H:i') }}</span>
              </div>
            </div>
            <div class="text-right">
              <p class="text-2xl font-bold text-orange-600">Rp {{ number_format($expense->amount, 0, ',', '.') }}</p>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-2">
          <a href="{{ route('expenses.edit', $expense->id) }}"
            class="px-4 py-2 bg-primary-50 text-primary-700 rounded-xl text-sm font-medium hover:bg-primary-100 transition border border-primary-200">
            ✏️ Edit
          </a>
          <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" onsubmit="return confirm('Hapus pengeluaran ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-50 text-red-700 rounded-xl text-sm font-medium hover:bg-red-100 transition border border-red-200">
              🗑️
            </button>
          </form>
        </div>
      </div>
    </div>
    @empty
    <div class="bg-white rounded-2xl shadow-soft p-12 text-center border border-gray-100">
      <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
      </div>
      <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Data Pengeluaran</h3>
      <p class="text-gray-500 mb-6">Mulai catat pengeluaran operasional toko Anda</p>
      <a href="{{ route('expenses.create') }}" class="inline-flex items-center px-6 py-3 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Pengeluaran
      </a>
    </div>
    @endforelse
  </div>

  <!-- Pagination -->
  @if($expenses->hasPages())
  <div class="bg-white rounded-2xl shadow-soft p-4 border border-gray-100">
    {{ $expenses->links() }}
  </div>
  @endif
</div>

<script>
  // Search functionality
  document.getElementById('searchExpenses').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const expenseItems = document.querySelectorAll('.expense-item');

    expenseItems.forEach(item => {
      const description = item.dataset.description || '';

      if (description.includes(searchTerm)) {
        item.style.display = 'flex';
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
      const expenseItems = document.querySelectorAll('.expense-item');

      expenseItems.forEach(item => {
        if (filter === 'all') {
          item.style.display = 'flex';
        } else if (item.dataset.category === filter) {
          item.style.display = 'flex';
        } else {
          item.style.display = 'none';
        }
      });
    });
  });
</script>
@endsection