@extends('layouts.app')

@section('title', 'Detail Penjualan - Toko Ikan Hias')
@section('page-title', 'Detail Penjualan')

@section('content')
<div class="max-w-4xl mx-auto pb-24 lg:pb-6">

  <!-- Header -->
  <div class="bg-white rounded-2xl shadow-soft p-5 mb-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('sales.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Detail Transaksi #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</h2>
          <p class="text-sm text-gray-500 mt-1">{{ $sale->sale_date->format('d F Y, H:i') }} WIB</p>
        </div>
      </div>
      <button onclick="window.print()" class="flex items-center px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
        </svg>
        Print Invoice
      </button>
    </div>
  </div>

  <div class="grid lg:grid-cols-3 gap-6">

    <!-- Left Column - Transaction Details -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Status Badge -->
      <div class="bg-green-50 border-l-4 border-green-500 rounded-xl p-4">
        <div class="flex items-center">
          <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div>
            <p class="text-sm font-semibold text-green-800">Transaksi Berhasil</p>
            <p class="text-xs text-green-600 mt-1">Pembayaran telah diterima</p>
          </div>
        </div>
      </div>

      <!-- Items -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
          Item Penjualan
        </h3>
        <div class="space-y-3">
          @foreach($sale->items as $item)
          <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
            <!-- Image -->
            <div class="flex-shrink-0">
              <div class="w-16 h-16 bg-gray-200 rounded-xl overflow-hidden">
                @if($item->fish->photo)
                <img src="{{ asset('storage/' . $item->fish->photo) }}" alt="{{ $item->fish->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center text-2xl">
                  🐟
                </div>
                @endif
              </div>
            </div>

            <!-- Details -->
            <div class="flex-1 min-w-0">
              <h4 class="font-semibold text-gray-800">{{ $item->fish->name }}</h4>
              <p class="text-sm text-gray-500">{{ $item->quantity }} ekor × Rp {{ number_format($item->price, 0, ',', '.') }}</p>
            </div>

            <!-- Subtotal -->
            <div class="text-right">
              <p class="font-bold text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <!-- Payment Info -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Informasi Pembayaran
        </h3>
        <div class="grid grid-cols-2 gap-5">
          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Metode Pembayaran</p>
            <div class="flex items-center gap-2">
              @if($sale->payment_method == 'cash')
              <span class="text-2xl">💵</span>
              <span class="font-bold text-gray-800">Cash</span>
              @elseif($sale->payment_method == 'transfer')
              <span class="text-2xl">🏦</span>
              <span class="font-bold text-gray-800">Transfer Bank</span>
              @else
              <span class="text-2xl">📱</span>
              <span class="font-bold text-gray-800">QRIS</span>
              @endif
            </div>
          </div>

          <div class="bg-gray-50 rounded-xl p-4">
            <p class="text-xs text-gray-500 mb-2">Status Pembayaran</p>
            <div class="flex items-center gap-2">
              <span class="px-3 py-1 bg-green-100 text-green-700 text-sm rounded-full font-semibold">
                ✓ Lunas
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Notes -->
      @if($sale->notes)
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-yellow-500 rounded-full mr-3"></span>
          Catatan
        </h3>
        <div class="bg-yellow-50 border-l-4 border-yellow-400 rounded-xl p-4">
          <p class="text-sm text-gray-700">{{ $sale->notes }}</p>
        </div>
      </div>
      @endif
    </div>

    <!-- Right Column - Summary -->
    <div class="lg:col-span-1 space-y-6">

      <!-- Customer Info -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
          Pelanggan
        </h3>
        @if($sale->customer)
        <div class="space-y-3">
          <div>
            <p class="text-xs text-gray-500 mb-1">Nama</p>
            <p class="font-semibold text-gray-800">{{ $sale->customer->name }}</p>
          </div>
          @if($sale->customer->phone)
          <div>
            <p class="text-xs text-gray-500 mb-1">Telepon</p>
            <p class="font-semibold text-gray-800">{{ $sale->customer->phone }}</p>
          </div>
          @endif
          @if($sale->customer->address)
          <div>
            <p class="text-xs text-gray-500 mb-1">Alamat</p>
            <p class="text-sm text-gray-700">{{ $sale->customer->address }}</p>
          </div>
          @endif
          <div class="pt-3 border-t border-gray-200">
            <a href="{{ route('customers.show', $sale->customer->id) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
              Lihat Profil Pelanggan →
            </a>
          </div>
        </div>
        @else
        <div class="text-center py-4">
          <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
          </div>
          <p class="text-sm font-semibold text-gray-700">Pelanggan Umum</p>
          <p class="text-xs text-gray-500 mt-1">Transaksi tanpa data pelanggan</p>
        </div>
        @endif
      </div>

      <!-- Summary -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Ringkasan
        </h3>
        <div class="space-y-3">
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Subtotal</span>
            <span class="font-semibold text-gray-800">Rp {{ number_format($sale->total_amount + $sale->discount, 0, ',', '.') }}</span>
          </div>

          @if($sale->discount > 0)
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Diskon</span>
            <span class="font-semibold text-orange-600">- Rp {{ number_format($sale->discount, 0, ',', '.') }}</span>
          </div>
          @endif

          <div class="border-t border-gray-300 pt-3">
            <div class="flex justify-between items-center mb-2">
              <span class="text-lg font-bold text-gray-800">Total</span>
              <span class="text-2xl font-bold text-green-600">Rp {{ number_format($sale->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="bg-green-50 rounded-xl p-3 mt-3">
              <p class="text-xs text-center text-green-700 font-semibold">✓ Pembayaran Lunas</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Transaction Info -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-gray-500 rounded-full mr-3"></span>
          Info Transaksi
        </h3>
        <div class="space-y-3 text-sm">
          <div class="flex justify-between">
            <span class="text-gray-600">ID Transaksi</span>
            <span class="font-semibold text-gray-800">#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Tanggal</span>
            <span class="font-semibold text-gray-800">{{ $sale->sale_date->format('d/m/Y') }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Waktu</span>
            <span class="font-semibold text-gray-800">{{ $sale->sale_date->format('H:i') }} WIB</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Dicatat</span>
            <span class="font-semibold text-gray-800">{{ $sale->created_at->diffForHumans() }}</span>
          </div>
        </div>
      </div>

      <!-- Actions -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span>
          Aksi
        </h3>
        <div class="space-y-2">
          <button onclick="window.print()" class="w-full py-3 bg-primary-50 text-primary-700 rounded-xl hover:bg-primary-100 transition font-semibold border border-primary-200">
            🖨️ Print Invoice
          </button>
          <button onclick="shareInvoice()" class="w-full py-3 bg-green-50 text-green-700 rounded-xl hover:bg-green-100 transition font-semibold border border-green-200">
            📤 Bagikan Invoice
          </button>
          <a href="{{ route('sales.index') }}" class="block w-full py-3 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 transition font-semibold text-center border border-gray-200">
            ← Kembali ke Daftar
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Print Styles -->
<style>
  @media print {
    body * {
      visibility: hidden;
    }

    .print-area,
    .print-area * {
      visibility: visible;
    }

    .print-area {
      position: absolute;
      left: 0;
      top: 0;
      width: 100%;
    }

    /* Hide non-printable elements */
    header,
    nav,
    button,
    .no-print {
      display: none !important;
    }
  }
</style>

<script>
  function shareInvoice() {
    const url = window.location.href;
    const text = `Invoice #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }} - Rp {{ number_format($sale->total_amount, 0, ',', '.') }}`;

    if (navigator.share) {
      navigator.share({
        title: 'Invoice Penjualan',
        text: text,
        url: url
      }).catch(err => console.log('Error sharing:', err));
    } else {
      // Fallback: copy to clipboard
      navigator.clipboard.writeText(`${text}\n${url}`).then(() => {
        alert('✓ Link invoice berhasil disalin!');
      });
    }
  }
</script>
@endsection