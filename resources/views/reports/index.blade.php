@extends('layouts.app')

@section('title', 'Laporan Keuangan')
@section('page-title', 'Laporan Keuangan')

@section('content')
{{-- Inline Styles --}}
<style>
  .chart-box {
    position: relative;
    height: 280px;
    width: 100%;
  }

  @media (min-width: 1024px) {
    .chart-box {
      height: 320px;
    }
  }

  .period-btn {
    cursor: pointer;
  }

  .period-btn.active {
    background-color: #2563eb !important;
    color: white !important;
    border-color: #2563eb !important;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
  }

  @media print {
    .no-print {
      display: none !important;
    }
  }
</style>

<div class="space-y-6">

  <!-- Header -->
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
    <div>
      <h2 class="text-2xl font-bold text-gray-800">📊 Laporan Keuangan</h2>
      <p class="text-sm text-gray-600 mt-1">Analisis keuangan toko ikan hias Anda</p>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-2 no-print">
      <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-xl hover:bg-gray-700 shadow">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Cetak
      </button>
      <a href="{{ route('reports.export', ['start_date' => $start->format('Y-m-d'), 'end_date' => $end->format('Y-m-d')]) }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-xl hover:bg-green-700 shadow">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        Export Excel
      </a>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="bg-white rounded-2xl shadow-lg p-5 no-print">
    <div class="flex flex-col space-y-4">
      <!-- Quick Period Buttons -->
      <div class="flex flex-wrap gap-2">
        <span class="text-sm font-medium text-gray-600 self-center mr-2">Periode Cepat:</span>
        <button type="button" class="period-btn px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 {{ request('period') == 'today' ? 'active' : '' }}" data-period="today">
          Hari Ini
        </button>
        <button type="button" class="period-btn px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 {{ request('period') == 'yesterday' ? 'active' : '' }}" data-period="yesterday">
          Kemarin
        </button>
        <button type="button" class="period-btn px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 {{ request('period') == 'week' ? 'active' : '' }}" data-period="week">
          Minggu Ini
        </button>
        <button type="button" class="period-btn px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 {{ request('period') == 'month' || (!request('period') && !request('start_date')) ? 'active' : '' }}" data-period="month">
          Bulan Ini
        </button>
        <button type="button" class="period-btn px-3 py-1.5 text-sm border border-gray-300 rounded-lg hover:bg-gray-100 {{ request('period') == 'year' ? 'active' : '' }}" data-period="year">
          Tahun Ini
        </button>
      </div>

      <!-- Custom Date Range -->
      <form id="filterForm" action="{{ route('reports.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-end">
        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
          <input type="date" name="start_date" id="startDate" value="{{ $start->format('Y-m-d') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
        </div>

        <div class="flex-1 min-w-0">
          <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
          <input type="date" name="end_date" id="endDate" value="{{ $end->format('Y-m-d') }}" class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
        </div>

        <input type="hidden" name="period" id="periodInput" value="{{ request('period', '') }}">

        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-xl hover:bg-blue-700 shadow flex items-center whitespace-nowrap">
          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
          </svg>
          Terapkan Filter
        </button>
      </form>

      <!-- Current Period Display -->
      <div class="flex items-center text-sm text-gray-600 bg-blue-50 rounded-lg px-4 py-2">
        <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        Menampilkan data periode: <span class="font-semibold ml-1">{{ $start->format('d M Y') }} - {{ $end->format('d M Y') }}</span>
        <span class="ml-2 text-gray-500">({{ $start->diffInDays($end) + 1 }} hari)</span>
      </div>
    </div>
  </div>

  <!-- Summary Stats Cards -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <!-- Pendapatan -->
    <div class="stat-card bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-5 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-green-100 text-sm font-medium">Total Pendapatan</p>
          <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <div class="mt-3 flex items-center text-green-100 text-xs">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
        </svg>
        Dari penjualan ikan
      </div>
    </div>

    <!-- Biaya Pembelian -->
    <div class="stat-card bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl shadow-lg p-5 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-orange-100 text-sm font-medium">Biaya Pembelian</p>
          <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</p>
        </div>
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
      <div class="mt-3 flex items-center text-orange-100 text-xs">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
        Pembelian stok ikan
      </div>
    </div>

    <!-- Pengeluaran -->
    <div class="stat-card bg-gradient-to-br from-red-500 to-red-600 rounded-2xl shadow-lg p-5 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-red-100 text-sm font-medium">Total Pengeluaran</p>
          <p class="text-2xl font-bold mt-1">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
        </div>
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </div>
      </div>
      <div class="mt-3 flex items-center text-red-100 text-xs">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
        </svg>
        Operasional & lainnya
      </div>
    </div>

    <!-- Laba Bersih -->
    <div class="stat-card bg-gradient-to-br {{ $netProfit >= 0 ? 'from-blue-500 to-blue-600' : 'from-gray-500 to-gray-600' }} rounded-2xl shadow-lg p-5 text-white">
      <div class="flex items-center justify-between">
        <div>
          <p class="{{ $netProfit >= 0 ? 'text-blue-100' : 'text-gray-100' }} text-sm font-medium">Laba Bersih</p>
          <p class="text-2xl font-bold mt-1">Rp {{ number_format($netProfit, 0, ',', '.') }}</p>
        </div>
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
          @if($netProfit >= 0)
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          @else
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          @endif
        </div>
      </div>
      <div class="mt-3 flex items-center {{ $netProfit >= 0 ? 'text-blue-100' : 'text-gray-100' }} text-xs">
        @if($netProfit >= 0)
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        Keuntungan periode ini
        @else
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        Rugi periode ini
        @endif
      </div>
    </div>
  </div>

  <!-- Charts Row 1 -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Trend Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">📈 Trend Penjualan vs Pengeluaran</h3>
        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Line Chart</span>
      </div>
      <div class="chart-box">
        <canvas id="trendChart"></canvas>
      </div>
    </div>

    <!-- Summary Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">📊 Ringkasan Keuangan</h3>
        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Bar Chart</span>
      </div>
      <div class="chart-box">
        <canvas id="summaryChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Charts Row 2 -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Top Fish Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">🐟 Top 5 Ikan Terlaris</h3>
        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Horizontal Bar</span>
      </div>
      @if(count($topFish) > 0)
      <div class="chart-box">
        <canvas id="topFishChart"></canvas>
      </div>
      @else
      <div class="chart-box flex items-center justify-center">
        <div class="text-center text-gray-500">
          <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
          </svg>
          <p class="font-medium">Tidak ada data penjualan</p>
          <p class="text-sm">pada periode ini</p>
        </div>
      </div>
      @endif
    </div>

    <!-- Expense Breakdown Chart -->
    <div class="bg-white rounded-2xl shadow-lg p-5">
      <div class="flex items-center justify-between mb-4">
        <h3 class="font-bold text-gray-800">💰 Breakdown Pengeluaran</h3>
        <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">Doughnut</span>
      </div>
      @if(count($expenseBreakdown) > 0)
      <div class="chart-box">
        <canvas id="expenseChart"></canvas>
      </div>
      @else
      <div class="chart-box flex items-center justify-center">
        <div class="text-center text-gray-500">
          <svg class="w-16 h-16 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
          </svg>
          <p class="font-medium">Tidak ada data pengeluaran</p>
          <p class="text-sm">pada periode ini</p>
        </div>
      </div>
      @endif
    </div>
  </div>

  <!-- Detail Tables -->
  <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-200 bg-gray-50">
      <h3 class="font-bold text-gray-800">📋 Ringkasan Detail</h3>
    </div>
    <div class="p-5">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Revenue Breakdown -->
        <div>
          <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
            <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
            Pendapatan
          </h4>
          <div class="space-y-2">
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Penjualan Ikan</span>
              <span class="font-medium">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>

        <!-- Cost Breakdown -->
        <div>
          <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
            <span class="w-3 h-3 bg-orange-500 rounded-full mr-2"></span>
            Biaya Pembelian
          </h4>
          <div class="space-y-2">
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">Pembelian Stok</span>
              <span class="font-medium">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</span>
            </div>
          </div>
        </div>

        <!-- Expense Breakdown -->
        <div>
          <h4 class="text-sm font-semibold text-gray-700 mb-3 flex items-center">
            <span class="w-3 h-3 bg-red-500 rounded-full mr-2"></span>
            Pengeluaran
          </h4>
          <div class="space-y-2">
            @forelse($expenseBreakdown as $category => $amount)
            <div class="flex justify-between text-sm">
              <span class="text-gray-600">{{ $category }}</span>
              <span class="font-medium">Rp {{ number_format($amount, 0, ',', '.') }}</span>
            </div>
            @empty
            <p class="text-sm text-gray-500">Tidak ada pengeluaran</p>
            @endforelse
          </div>
        </div>
      </div>

      <!-- Profit Calculation -->
      <div class="mt-6 pt-4 border-t border-gray-200">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
          <div class="text-sm text-gray-600">
            <span class="font-medium">Perhitungan:</span>
            Rp {{ number_format($totalRevenue, 0, ',', '.') }} - Rp {{ number_format($totalPurchases, 0, ',', '.') }} - Rp {{ number_format($totalExpenses, 0, ',', '.') }}
          </div>
          <div class="text-lg font-bold {{ $netProfit >= 0 ? 'text-blue-600' : 'text-red-600' }}">
            = Rp {{ number_format($netProfit, 0, ',', '.') }}
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- Hidden Data Container for JavaScript --}}
<div id="reportData" style="display:none;"
  data-trend-labels="{{ json_encode(array_column($trendData, 'date')) }}"
  data-trend-sales="{{ json_encode(array_column($trendData, 'sales')) }}"
  data-trend-expenses="{{ json_encode(array_column($trendData, 'expenses')) }}"
  data-summary="{{ json_encode(array_values($summaryData)) }}"
  data-net-profit="{{ $netProfit }}"
  data-top-fish-has-data="{{ count($topFish) > 0 ? '1' : '0' }}"
  data-top-fish-labels="{{ json_encode(count($topFish) > 0 ? array_column($topFish->toArray(), 'name') : []) }}"
  data-top-fish-data="{{ json_encode(count($topFish) > 0 ? array_column($topFish->toArray(), 'revenue') : []) }}"
  data-expense-has-data="{{ count($expenseBreakdown) > 0 ? '1' : '0' }}"
  data-expense-labels="{{ json_encode(array_keys($expenseBreakdown)) }}"
  data-expense-data="{{ json_encode(array_values($expenseBreakdown)) }}">
</div>

{{-- Chart.js Library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

{{-- Report Scripts --}}
<script src="{{ asset('js/reports.js') }}"></script>
@endsection