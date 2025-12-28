<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Toko Ikan Hias')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: {
              50: '#eff6ff',
              100: '#dbeafe',
              200: '#bfdbfe',
              300: '#93c5fd',
              400: '#60a5fa',
              500: '#3b82f6',
              600: '#2563eb',
              700: '#1d4ed8',
              800: '#1e40af',
              900: '#1e3a8a',
            }
          }
        }
      }
    }
  </script>
  <style>
    [x-cloak] {
      display: none !important;
    }

    .scrollbar-hide::-webkit-scrollbar {
      display: none;
    }

    .scrollbar-hide {
      -ms-overflow-style: none;
      scrollbar-width: none;
    }

    .shadow-soft {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    * {
      transition: all 0.2s ease;
    }

    .menu-active {
      background-color: #dbeafe;
      color: #1e40af;
      font-weight: 600;
    }
  </style>
</head>

<body class="bg-gray-50 font-sans antialiased">

  <!-- Top Header -->
  <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="px-4 py-3">
      <div class="flex items-center justify-between">
        <!-- Left: Menu Toggle & Title -->
        <div class="flex items-center space-x-3">
          <button id="menuToggle" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
          <div>
            <h1 class="text-lg font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
            <p class="text-xs text-gray-500">Toko Ikan Hias</p>
          </div>
        </div>

        <!-- Right: User & Logout -->
        <div class="flex items-center space-x-2">
          <!-- User Profile -->
          <div class="flex items-center space-x-2 px-3 py-2 rounded-lg bg-gray-50">
            <div class="w-8 h-8 rounded-full bg-primary-500 flex items-center justify-center text-white font-semibold">
              {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div class="hidden sm:block">
              <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
              <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
            </div>
          </div>

          <!-- Logout -->
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="p-2 rounded-lg text-red-600" title="Logout">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
              </svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  </header>

  <div class="flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 lg:static lg:inset-auto transition-transform duration-300 ease-in-out w-64 bg-white border-r border-gray-200 z-40 mt-[57px] lg:mt-0 shadow-lg lg:shadow-none">
      <div class="h-full overflow-y-auto pb-20 lg:pb-4">
        <!-- Logo Section (Desktop Only) -->
        <div class="hidden lg:block p-6 border-b border-gray-200">
          <div class="flex items-center space-x-3">
            <div class="w-10 h-10 bg-primary-500 rounded-lg flex items-center justify-center">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
              </svg>
            </div>
            <div>
              <h2 class="text-sm font-bold text-gray-800">Toko Ikan Hias</h2>
              <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
            </div>
          </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="p-4 space-y-1">
          <!-- Dashboard - All roles -->
          <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span class="text-sm">Dashboard</span>
          </a>

          <!-- Stok Ikan - Kasir, Admin, Superadmin -->
          <a href="{{ route('fish.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('fish.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <span class="text-sm">Stok Ikan</span>
          </a>

          <!-- Penjualan - Kasir, Admin, Superadmin -->
          <a href="{{ route('sales.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('sales.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-sm">Penjualan</span>
          </a>

          <!-- Pelanggan - Kasir, Admin, Superadmin -->
          <a href="{{ route('customers.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('customers.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-sm">Pelanggan</span>
          </a>

          @if(auth()->user()->hasRole(['admin', 'superadmin']))
          <!-- Divider -->
          <div class="py-2">
            <div class="border-t border-gray-200"></div>
          </div>

          <!-- Pembelian - Admin, Superadmin -->
          <a href="{{ route('purchases.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('purchases.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
            </svg>
            <span class="text-sm">Pembelian</span>
          </a>

          <!-- Pengeluaran - Admin, Superadmin -->
          <a href="{{ route('expenses.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('expenses.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <span class="text-sm">Pengeluaran</span>
          </a>

          <!-- Supplier - Admin, Superadmin -->
          <a href="{{ route('suppliers.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('suppliers.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
            <span class="text-sm">Supplier</span>
          </a>

          <!-- Divider -->
          <div class="py-2">
            <div class="border-t border-gray-200"></div>
          </div>

          <!-- Kematian Ikan - Admin, Superadmin -->
          <a href="{{ route('mortality.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('mortality.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span class="text-sm">Kematian Ikan</span>
          </a>

          <!-- Karantina - Admin, Superadmin -->
          <a href="{{ route('quarantine.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('quarantine.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-sm">Karantina</span>
          </a>

          <!-- Divider -->
          <div class="py-2">
            <div class="border-t border-gray-200"></div>
          </div>

          <!-- Laporan - Admin, Superadmin -->
          <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('reports.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <span class="text-sm">Laporan</span>
          </a>
          @endif

          @if(auth()->user()->isSuperAdmin())
          <!-- Divider -->
          <div class="py-2">
            <div class="border-t border-gray-200"></div>
          </div>

          <!-- Manajemen User - Superadmin only -->
          <a href="{{ route('users.index') }}" class="flex items-center px-4 py-3 rounded-xl text-gray-700 hover:bg-gray-50 {{ request()->routeIs('users.*') ? 'menu-active' : '' }}">
            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span class="text-sm">Manajemen User</span>
          </a>
          @endif
        </nav>
      </div>
    </aside>

    <!-- Overlay for mobile -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden hidden"></div>

    <!-- Main Content -->
    <main class="flex-1 p-4 lg:p-6 min-h-screen">
      <!-- Flash Messages -->
      @if(session('success'))
      <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg">
        <div class="flex items-center">
          <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          <p class="text-sm text-green-800">{{ session('success') }}</p>
        </div>
      </div>
      @endif

      @if(session('error') || $errors->any())
      <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
        <div class="flex items-start">
          <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
          <div class="flex-1">
            @if(session('error'))
            <p class="text-sm text-red-800">{{ session('error') }}</p>
            @endif
            @if($errors->any())
            @foreach($errors->all() as $error)
            <p class="text-sm text-red-800">{{ $error }}</p>
            @endforeach
            @endif
          </div>
        </div>
      </div>
      @endif

      @yield('content')
    </main>
  </div>

  <!-- Bottom Navigation for Mobile -->
  <nav class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50 shadow-lg">
    <div class="flex justify-around items-center h-16">
      <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-600' }} hover:text-primary-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="text-xs mt-1 font-medium">Home</span>
      </a>

      <a href="{{ route('fish.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('fish.*') ? 'text-primary-600' : 'text-gray-600' }} hover:text-primary-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
        <span class="text-xs mt-1 font-medium">Stok</span>
      </a>

      <a href="{{ route('sales.create') }}" class="flex flex-col items-center justify-center flex-1 h-full -mt-8">
        <div class="bg-primary-600 text-white rounded-2xl p-4 shadow-lg hover:bg-primary-700">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
          </svg>
        </div>
        <span class="text-xs mt-2 text-primary-600 font-semibold">Jual</span>
      </a>

      <a href="{{ route('customers.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('customers.*') ? 'text-primary-600' : 'text-gray-600' }} hover:text-primary-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span class="text-xs mt-1 font-medium">Customer</span>
      </a>

      @if(auth()->user()->hasRole(['admin', 'superadmin']))
      <a href="{{ route('reports.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('reports.*') ? 'text-primary-600' : 'text-gray-600' }} hover:text-primary-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <span class="text-xs mt-1 font-medium">Laporan</span>
      </a>
      @else
      <!-- Untuk Kasir, tampilkan menu lain atau kosongkan -->
      <a href="{{ route('sales.index') }}" class="flex flex-col items-center justify-center flex-1 h-full {{ request()->routeIs('sales.index') ? 'text-primary-600' : 'text-gray-600' }} hover:text-primary-600">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
        <span class="text-xs mt-1 font-medium">Riwayat</span>
      </a>
      @endif
    </div>
  </nav>

  <script>
    // Mobile menu toggle
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    menuToggle.addEventListener('click', () => {
      sidebar.classList.toggle('-translate-x-full');
      overlay.classList.toggle('hidden');
    });

    overlay.addEventListener('click', () => {
      sidebar.classList.add('-translate-x-full');
      overlay.classList.add('hidden');
    });

    // Format currency
    function formatRupiah(angka) {
      return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
      }).format(angka);
    }

    // Auto hide flash messages
    // setTimeout(() => {
    //   const alerts = document.querySelectorAll('.mb-4.bg-green-50, .mb-4.bg-red-50');
    //   alerts.forEach(alert => {
    //     alert.style.opacity = '0';
    //     setTimeout(() => alert.remove(), 300);
    //   });
    // }, 5000);
  </script>
</body>

</html>