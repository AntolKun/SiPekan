@extends('layouts.app')

@section('title', 'Detail Pembelian - Toko Ikan Hias')
@section('page-title', 'Detail Pembelian')

@section('content')
<div class="max-w-4xl mx-auto pb-24 lg:pb-6">

  <!-- Header -->
  <div class="bg-white rounded-2xl shadow-soft p-5 mb-6 border border-gray-100">
    <div class="flex items-center justify-between">
      <div class="flex items-center">
        <a href="{{ route('purchases.index') }}" class="mr-4 p-2 hover:bg-gray-100 rounded-xl transition">
          <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
          </svg>
        </a>
        <div>
          <h2 class="text-2xl font-bold text-gray-800">Detail Pembelian #{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</h2>
          <p class="text-sm text-gray-500 mt-1">{{ $purchase->purchase_date->format('d F Y, H:i') }} WIB</p>
        </div>
      </div>
      <a href="{{ route('purchases.edit', $purchase->id) }}" class="flex items-center px-5 py-2.5 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
        Edit
      </a>
    </div>
  </div>

  <div class="grid lg:grid-cols-3 gap-6">

    <!-- Left Column - Purchase Details -->
    <div class="lg:col-span-2 space-y-6">

      <!-- Status Badge -->
      <div class="bg-blue-50 border-l-4 border-blue-500 rounded-xl p-4">
        <div class="flex items-center">
          <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <div>
            <p class="text-sm font-semibold text-blue-800">Pembelian Tercatat</p>
            <p class="text-xs text-blue-600 mt-1">Stok telah diperbarui</p>
          </div>
        </div>
      </div>

      <!-- Fish Detail -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-blue-500 rounded-full mr-3"></span>
          Detail Ikan
        </h3>

        <div class="flex gap-5">
          <!-- Image -->
          <div class="flex-shrink-0">
            <div class="w-32 h-32 bg-gray-100 rounded-2xl overflow-hidden">
              @if($purchase->fish->photo)
              <img src="{{ asset('storage/' . $purchase->fish->photo) }}" alt="{{ $purchase->fish->name }}" class="w-full h-full object-cover">
              @else
              <div class="w-full h-full flex items-center justify-center text-5xl">
                🐟
              </div>
              @endif
            </div>
          </div>

          <!-- Info -->
          <div class="flex-1">
            <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $purchase->fish->name }}</h4>
            <div class="space-y-2 text-sm">
              <div class="flex items-center gap-2">
                <span class="text-gray-500">Jenis:</span>
                <span class="font-medium text-gray-800">{{ $purchase->fish->type ?? '-' }}</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-gray-500">Warna:</span>
                <span class="font-medium text-gray-800">{{ $purchase->fish->color ?? '-' }}</span>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-gray-500">Stok Saat Ini:</span>
                <span class="font-bold text-blue-600">{{ $purchase->fish->stock }} ekor</span>
              </div>
            </div>
            <a href="{{ route('fish.show', $purchase->fish->id) }}" class="inline-block mt-4 text-sm text-primary-600 hover:text-primary-700 font-medium">
              Lihat Detail Ikan →
            </a>
          </div>
        </div>
      </div>

      <!-- Purchase Info -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Informasi Pembelian
        </h3>

        <div class="grid grid-cols-2 gap-5">
          <div class="bg-blue-50 rounded-xl p-4">
            <p class="text-xs text-gray-600 mb-2">Jumlah Dibeli</p>
            <p class="text-3xl font-bold text-blue-600">{{ $purchase->quantity }}</p>
            <p class="text-xs text-gray-500 mt-1">ekor</p>
          </div>

          <div class="bg-green-50 rounded-xl p-4">
            <p class="text-xs text-gray-600 mb-2">Harga per Ekor</p>
            <p class="text-xl font-bold text-green-600">Rp {{ number_format($purchase->price_per_unit, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">per ekor</p>
          </div>

          <div class="bg-purple-50 rounded-xl p-4">
            <p class="text-xs text-gray-600 mb-2">Subtotal Ikan</p>
            <p class="text-xl font-bold text-purple-600">Rp {{ number_format($purchase->quantity * $purchase->price_per_unit, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">total harga ikan</p>
          </div>

          <div class="bg-orange-50 rounded-xl p-4">
            <p class="text-xs text-gray-600 mb-2">Biaya Transport</p>
            <p class="text-xl font-bold text-orange-600">Rp {{ number_format($purchase->transport_cost, 0, ',', '.') }}</p>
            <p class="text-xs text-gray-500 mt-1">ongkir</p>
          </div>
        </div>
      </div>

      <!-- Cost Calculation -->
      <div class="bg-white rounded-2xl shadow-soft p-6 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-5 flex items-center">
          <span class="w-2 h-8 bg-purple-500 rounded-full mr-3"></span>
          Perhitungan Biaya
        </h3>

        <div class="space-y-3">
          <div class="flex justify-between text-sm">
            <span class="text-gray-600">{{ $purchase->quantity }} ekor × Rp {{ number_format($purchase->price_per_unit, 0, ',', '.') }}</span>
            <span class="font-semibold text-gray-800">Rp {{ number_format($purchase->quantity * $purchase->price_per_unit, 0, ',', '.') }}</span>
          </div>

          <div class="flex justify-between text-sm">
            <span class="text-gray-600">Biaya Transport</span>
            <span class="font-semibold text-gray-800">Rp {{ number_format($purchase->transport_cost, 0, ',', '.') }}</span>
          </div>

          <div class="border-t border-gray-300 pt-3">
            <div class="flex justify-between items-center mb-2">
              <span class="text-lg font-bold text-gray-800">Total Biaya</span>
              <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($purchase->total_cost, 0, ',', '.') }}</span>
            </div>
            <div class="bg-blue-50 rounded-xl p-3 mt-3">
              <p class="text-xs text-center text-blue-700">
                <span class="font-semibold">Biaya per ekor:</span>
                Rp {{ number_format($purchase->unit_cost, 0, ',', '.') }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Right Column - Supplier & Summary -->
    <div class="lg:col-span-1 space-y-6">

      <!-- Supplier Info -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-orange-500 rounded-full mr-3"></span>
          Supplier
        </h3>
        <div class="space-y-3">
          <div>
            <p class="text-xs text-gray-500 mb-1">Nama Supplier</p>
            <p class="font-semibold text-gray-800">{{ $purchase->supplier->name }}</p>
          </div>
          @if($purchase->supplier->contact)
          <div>
            <p class="text-xs text-gray-500 mb-1">Kontak</p>
            <p class="font-semibold text-gray-800">{{ $purchase->supplier->contact }}</p>
          </div>
          @endif
          @if($purchase->supplier->address)
          <div>
            <p class="text-xs text-gray-500 mb-1">Alamat</p>
            <p class="text-sm text-gray-700">{{ $purchase->supplier->address }}</p>
          </div>
          @endif
          @if($purchase->supplier->survival_rate > 0)
          <div>
            <p class="text-xs text-gray-500 mb-1">Survival Rate</p>
            <div class="flex items-center gap-2">
              <div class="flex-1 bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $purchase->supplier->survival_rate }}%"></div>
              </div>
              <span class="text-sm font-bold text-green-600">{{ $purchase->supplier->survival_rate }}%</span>
            </div>
          </div>
          @endif
          <div class="pt-3 border-t border-gray-200">
            <a href="{{ route('suppliers.show', $purchase->supplier->id) }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
              Lihat Profil Supplier →
            </a>
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
            <span class="text-gray-600">ID Pembelian</span>
            <span class="font-semibold text-gray-800">#{{ str_pad($purchase->id, 5, '0', STR_PAD_LEFT) }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Tanggal</span>
            <span class="font-semibold text-gray-800">{{ $purchase->purchase_date->format('d/m/Y') }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Waktu</span>
            <span class="font-semibold text-gray-800">{{ $purchase->purchase_date->format('H:i') }} WIB</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-600">Dicatat</span>
            <span class="font-semibold text-gray-800">{{ $purchase->created_at->diffForHumans() }}</span>
          </div>
          @if($purchase->updated_at != $purchase->created_at)
          <div class="flex justify-between">
            <span class="text-gray-600">Terakhir Update</span>
            <span class="font-semibold text-gray-800">{{ $purchase->updated_at->diffForHumans() }}</span>
          </div>
          @endif
        </div>
      </div>

      <!-- Stock Impact -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-green-500 rounded-full mr-3"></span>
          Dampak Stok
        </h3>
        <div class="bg-green-50 border-2 border-green-200 rounded-xl p-4">
          <div class="flex items-center justify-center mb-3">
            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
            </svg>
          </div>
          <p class="text-center text-sm text-gray-700 mb-2">
            Stok <span class="font-bold">{{ $purchase->fish->name }}</span> bertambah
          </p>
          <p class="text-center">
            <span class="text-3xl font-bold text-green-600">+{{ $purchase->quantity }}</span>
            <span class="text-sm text-gray-600 ml-1">ekor</span>
          </p>
        </div>
      </div>

      <!-- Actions -->
      <div class="bg-white rounded-2xl shadow-soft p-5 border border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
          <span class="w-2 h-8 bg-red-500 rounded-full mr-3"></span>
          Aksi
        </h3>
        <div class="space-y-2">
          <a href="{{ route('purchases.edit', $purchase->id) }}" class="block w-full py-3 bg-primary-50 text-primary-700 rounded-xl hover:bg-primary-100 transition font-semibold text-center border border-primary-200">
            ✏️ Edit Data
          </a>
          <form action="{{ route('purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('⚠️ PERHATIAN!\n\nMenghapus pembelian akan mengurangi stok ikan sebanyak {{ $purchase->quantity }} ekor.\n\nApakah Anda yakin?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="w-full py-3 bg-red-50 text-red-700 rounded-xl hover:bg-red-100 transition font-semibold border border-red-200">
              🗑️ Hapus Pembelian
            </button>
          </form>
          <a href="{{ route('purchases.index') }}" class="block w-full py-3 bg-gray-50 text-gray-700 rounded-xl hover:bg-gray-100 transition font-semibold text-center border border-gray-200">
            ← Kembali ke Daftar
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection