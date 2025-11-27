@extends('layouts.app')

@push('styles')
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
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-6">
  <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Laporan Keuangan</h1>
  <p class="text-gray-600 mb-4">Periode: {{ $start->format('d M Y') }} s/d {{ $end->format('d M Y') }}</p>

  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-600">Pendapatan</div>
      <div class="text-xl font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-600">Biaya Pembelian</div>
      <div class="text-xl font-bold text-orange-600">Rp {{ number_format($totalPurchases, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-600">Pengeluaran</div>
      <div class="text-xl font-bold text-red-600">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <div class="text-sm text-gray-600">Laba Bersih</div>
      <div class="text-xl font-bold text-blue-600">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold text-gray-800 mb-3">Trend Penjualan vs Pengeluaran</h3>
      <div class="chart-box"><canvas id="trendChart"></canvas></div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold text-gray-800 mb-3">Ringkasan Keuangan</h3>
      <div class="chart-box"><canvas id="summaryChart"></canvas></div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold text-gray-800 mb-3">Top 5 Ikan Terlaris</h3>
      <div class="chart-box"><canvas id="topFishChart"></canvas></div>
    </div>
    <div class="bg-white p-4 rounded shadow">
      <h3 class="font-semibold text-gray-800 mb-3">Breakdown Pengeluaran</h3>
      <div class="chart-box"><canvas id="expenseChart"></canvas></div>
    </div>
  </div>

  <div class="flex gap-3">
    <button onclick="window.print()" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">🖨️ Cetak</button>
    <a href="{{ route('reports.export', ['start_date' => $start->format('Y-m-d'), 'end_date' => $end->format('Y-m-d')]) }}" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">📥 Export Excel</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
  }

  const trendCtx = document.getElementById('trendChart').getContext('2d');
  new Chart(trendCtx, {
    type: 'line',
    data: {
      labels: @json(array_column($trendData, 'date')),
      datasets: [{
        label: 'Penjualan',
        data: @json(array_column($trendData, 'sales')),
        borderColor: 'rgb(34, 197, 94)',
        backgroundColor: 'rgba(34, 197, 94, 0.1)',
        tension: 0.3,
        fill: true
      }, {
        label: 'Pengeluaran',
        data: @json(array_column($trendData, 'expenses')),
        borderColor: 'rgb(239, 68, 68)',
        backgroundColor: 'rgba(239, 68, 68, 0.1)',
        tension: 0.3,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        tooltip: {
          callbacks: {
            label: ctx => ctx.dataset.label + ': ' + formatRupiah(ctx.parsed.y)
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: v => 'Rp ' + (v / 1000000).toFixed(1) + 'jt'
          }
        }
      }
    }
  });

  const summaryCtx = document.getElementById('summaryChart').getContext('2d');
  new Chart(summaryCtx, {
    type: 'bar',
    data: {
      labels: ['Pendapatan', 'Biaya Pembelian', 'Pengeluaran', 'Laba Bersih'],
      datasets: [{
        data: @json(array_values($summaryData)),
        backgroundColor: ['rgba(34, 197, 94, 0.8)', 'rgba(251, 146, 60, 0.8)', 'rgba(239, 68, 68, 0.8)', 'rgba(59, 130, 246, 0.8)'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: ctx => formatRupiah(ctx.parsed.y)
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: v => 'Rp ' + (v / 1000000).toFixed(1) + 'jt'
          }
        }
      }
    }
  });

  const topCtx = document.getElementById('topFishChart').getContext('2d');
  new Chart(topCtx, {
    type: 'bar',
    data: {
      labels: @json(array_column($topFish -> toArray(), 'name')),
      datasets: [{
        data: @json(array_column($topFish -> toArray(), 'revenue')),
        backgroundColor: 'rgba(147, 51, 234, 0.8)',
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y',
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: ctx => formatRupiah(ctx.parsed.x)
          }
        }
      },
      scales: {
        x: {
          beginAtZero: true,
          ticks: {
            callback: v => 'Rp ' + (v / 1000000).toFixed(1) + 'jt'
          }
        }
      }
    }
  });

  const expenseCtx = document.getElementById('expenseChart').getContext('2d');
  new Chart(expenseCtx, {
    type: 'doughnut',
    data: {
      labels: @json(array_keys($expenseBreakdown)),
      datasets: [{
        data: @json(array_values($expenseBreakdown)),
        backgroundColor: ['rgba(239,68,68,0.8)', 'rgba(251,146,60,0.8)', 'rgba(34,197,94,0.8)', 'rgba(59,130,246,0.8)', 'rgba(147,51,234,0.8)', 'rgba(251,191,36,0.8)'],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom'
        },
        tooltip: {
          callbacks: {
            label: ctx => {
              const label = ctx.label || '';
              const value = ctx.parsed;
              const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
              const pct = ((value / total) * 100).toFixed(1);
              return label + ': ' + formatRupiah(value) + ' (' + pct + '%)';
            }
          }
        }
      }
    }
  });
</script>
@endsection