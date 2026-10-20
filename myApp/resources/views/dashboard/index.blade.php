@php
    $todaySales = \App\Models\Sale::whereDate('tanggal', today())->get();

    $todayRevenue = $todaySales
        ->where('status', 'Selesai')
        ->sum('total');

    $productCount = \App\Models\Product::count();

    $lowStockCount = \App\Models\Stock::where('jumlah', '<=', 5)->count();

    $recentSales = \App\Models\Sale::with(['user', 'saleDetails.product'])
        ->latest('tanggal')
        ->take(5)
        ->get();

    $products = \App\Models\Product::with('stock')
        ->orderBy('nama_produk')
        ->take(4)
        ->get();

    $rupiah = fn ($angka) => 'Rp ' . number_format((float) $angka, 0, ',', '.');

    $namaPengguna = auth()->user()->nama
        ?? auth()->user()->username
        ?? 'Admin';

    $rolePengguna = auth()->user()->role;
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin | Modern Bakery</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --brown: #793c2c;
            --dark: #54291f;
            --cream: #faf7f2;
            --border: #eee5dc;
            --muted: #81766e;
            --text: #382720;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--cream);
            color: var(--text);
        }

        a { color: inherit; }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 245px;
            flex-shrink: 0;
            padding: 25px 16px;
            background: #4A2D23;
            border-right: 1px solid var(--border);
        }

        .brand {
            padding: 8px 10px 30px;
            color: #FFFFFF;
            font: bold 23px Georgia, serif;
        }

        .brand small {
            display: block;
            margin-top: 7px;
            color: #E2CFC0;
            font: 11px Arial, sans-serif;
            letter-spacing: 1.5px;
        }

        .menu-label {
            padding: 10px;
            color: #D0B9A8;
            font-size: 10px;
            font-weight: bold;
            letter-spacing: 1.5px;
        }

        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 12px;
            border-radius: 9px;
            color: #FFFFFF;
            text-decoration: none;
            font-size: 13px;
            transition: background .2s ease, color .2s ease;
        }

       /* Saat kursor diarahkan ke menu */
        .menu:hover {
            background: #654332;
            color: #FFFFFF;
            font-weight: bold;
        }

/* Menu yang sedang aktif */
        .menu.active {
            background: #F3E6D6;
            color: #4A2D23;
            font-weight: bold;
        }

/* Saat kursor diarahkan ke menu aktif */
        .menu.active:hover {
            background: #EAD6C0;
            color: #4A2D23;
            font-weight: bold;
        }

        .main { flex: 1; min-width: 0; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            padding: 18px 30px;
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .topbar small { color: var(--muted); }

        .user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #f0dfd1;
            color: var(--brown);
            font-weight: bold;
        }

        .logout {
            padding: 9px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: white;
            color: var(--brown);
            cursor: pointer;
        }

        .logout:hover { background: #f5eae2; }

        .content {
            max-width: 1500px;
            margin: auto;
            padding: 30px;
        }

        .heading { margin-bottom: 25px; }

        h1 {
            margin: 0 0 8px;
            color: var(--dark);
            font: bold 30px Georgia, serif;
        }

        .sub {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 25px;
        }

        .stat, .panel {
            border: 1px solid var(--border);
            border-radius: 14px;
            background: white;
            box-shadow: 0 4px 14px rgba(72, 48, 30, .035);
        }

        .stat { padding: 22px; min-width: 0; }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            margin-bottom: 17px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .stat-icon {
            display: grid;
            place-items: center;
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #f5eae2;
            font-size: 21px;
        }

        .stat-number {
            color: var(--dark);
            font-size: 24px;
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .stat-note {
            margin-top: 8px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .panel {
            margin-bottom: 25px;
            overflow: hidden;
        }

        .panel-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            padding: 21px 22px;
            border-bottom: 1px solid var(--border);
        }

        .panel-heading h2 {
            margin: 0 0 6px;
            color: var(--dark);
            font-size: 17px;
        }

        .panel-heading p {
            margin: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .text-link {
            color: var(--brown);
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
        }

        .text-link:hover { text-decoration: underline; }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 17px;
            padding: 22px;
        }

        .product-card {
            min-width: 0;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .product-image, .product-placeholder {
            display: block;
            width: 100%;
            height: 155px;
            object-fit: cover;
            background: #f5eae2;
        }

        .product-placeholder {
            display: grid;
            place-items: center;
            color: #9b7863;
            font-size: 36px;
        }

        .product-body { padding: 14px; }

        .product-name {
            margin: 0 0 7px;
            color: var(--dark);
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .product-category, .product-stock {
            color: var(--muted);
            font-size: 11px;
        }

        .product-price {
            color: var(--brown);
            font-size: 14px;
            font-weight: bold;
        }

        .table-scroll { overflow-x: auto; }

        table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
        }

        th {
            padding: 14px 18px;
            background: #fcfaf7;
            color: #76665c;
            text-align: left;
            font-size: 10px;
            white-space: nowrap;
        }

        td {
            padding: 15px 18px;
            border-bottom: 1px solid #f0eae4;
            color: #574537;
            font-size: 12px;
        }

        tbody tr:last-child td { border-bottom: 0; }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #e7f6e9;
            color: #276738;
            font-size: 10px;
            font-weight: bold;
        }

        .status-pending {
            background: #fff0d9;
            color: #925b0a;
        }

        .status-cancelled {
            background: #fbe8e6;
            color: #a12b24;
        }

        .empty {
            padding: 30px 20px;
            color: var(--muted);
            text-align: center;
            font-size: 13px;
        }

        @media (max-width: 1150px) {
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .product-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 650px) {
            .layout { display: block; }

            .sidebar {
                width: 100%;
                padding: 12px;
                border-right: 0;
                border-bottom: 1px solid var(--border);
            }

            .brand { padding: 8px; }
            .menu-label { display: none; }

            .menu-list {
                flex-direction: row;
                gap: 5px;
                overflow-x: auto;
            }

            .menu { flex-shrink: 0; white-space: nowrap; padding: 10px; }

            .topbar { flex-wrap: wrap; padding: 14px; }
            .user { flex-wrap: wrap; gap: 8px; }
            .content { padding: 20px 12px; }
            h1 { font-size: 26px; }
            .stats { gap: 10px; }
            .stat { padding: 15px; }
            .stat-number { font-size: 20px; }
            .product-grid { gap: 10px; padding: 13px; }
            .product-image, .product-placeholder { height: 120px; }
            .product-body { padding: 10px; }
        }

        @media (max-width: 380px) {
            .stats, .product-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <div class="brand">
            Modern Bakery
            <small>ADMIN PANEL</small>
        </div>

        <div class="menu-label">MENU ADMIN</div>

        <nav class="menu-list">
            <a class="menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                ▦ Dashboard
            </a>

            <a class="menu {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
               href="{{ route('admin.products.index') }}">
                🥐 Data Produk
            </a>

            <a class="menu {{ request()->routeIs('admin.sales.create', 'admin.sales.store') ? 'active' : '' }}"
               href="{{ route('admin.sales.create') }}">
                🛒 Kasir Offline
            </a>

            <a class="menu {{ request()->routeIs('admin.sales.history', 'admin.sales.show', 'admin.sales.receipt') ? 'active' : '' }}"
               href="{{ route('admin.sales.history') }}">
                🧾 Riwayat Penjualan
            </a>

            <a class="menu {{ request()->routeIs('admin.orders*') ? 'active' : '' }}"
                href="{{ url('/admin/pesanan-online') }}">
                🔔 Notifikasi Pesanan Online
            </a>

            {{-- Laporan admin memakai URL /admin/laporan-penjualan --}}
            <a class="menu {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
               href="{{ route('admin.reports') }}">
                📊 Laporan Penjualan
            </a>

            <a class="menu {{ request()->routeIs('admin.profile') ? 'active' : '' }}"
               href="{{ route('admin.profile') }}">
                👤 Profil Saya
            </a>
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <strong>Panel Admin</strong><br>
                <small>Kelola transaksi dan produk toko</small>
            </div>

            <div class="user">
                <div class="avatar">
                    {{ strtoupper(substr($namaPengguna, 0, 1)) }}
                </div>

                <div>
                    <strong>{{ $namaPengguna }}</strong><br>
                    <small>{{ ucfirst(str_replace('_', ' ', $rolePengguna)) }}</small>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout" type="submit">Keluar</button>
                </form>
            </div>
        </header>

        <section class="content">
            <div class="heading">
                <h1>Dashboard Admin</h1>
                <p class="sub">
                    Selamat datang di Sistem Kasir Modern Bakery Menganto Jombang.
                </p>
            </div>

            <div class="stats">
                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Pendapatan Hari Ini</div>
                        <div class="stat-icon">💰</div>
                    </div>
                    <div class="stat-number">{{ $rupiah($todayRevenue) }}</div>
                    <div class="stat-note">Transaksi berstatus Selesai hari ini</div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Transaksi Hari Ini</div>
                        <div class="stat-icon">🧾</div>
                    </div>
                    <div class="stat-number">{{ $todaySales->count() }}</div>
                    <div class="stat-note">Jumlah transaksi hari ini</div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Jumlah Produk</div>
                        <div class="stat-icon">🥐</div>
                    </div>
                    <div class="stat-number">{{ $productCount }}</div>
                    <div class="stat-note">Produk terdaftar di sistem</div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Stok Menipis</div>
                        <div class="stat-icon">📦</div>
                    </div>
                    <div class="stat-number">{{ $lowStockCount }}</div>
                    <div class="stat-note">Stok berjumlah 5 atau kurang</div>
                </div>
            </div>

            <section class="panel">
                <div class="panel-heading">
                    <div>
                        <h2>🥐 Produk Bakery</h2>
                        <p>Empat produk yang tersedia di toko.</p>
                    </div>

                    <a class="text-link" href="{{ route('admin.products.index') }}">
                        Lihat Semua Produk →
                    </a>
                </div>

                @if ($products->isNotEmpty())
                    <div class="product-grid">
                        @foreach ($products as $product)
                            <article class="product-card">
                                @if ($product->foto_produk)
                                    <img
                                        class="product-image"
                                        src="{{ asset('storage/' . $product->foto_produk) }}"
                                        alt="{{ $product->nama_produk }}"
                                        onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                                    >
                                    <div class="product-placeholder" style="display:none">🥐</div>
                                @else
                                    <div class="product-placeholder">🥐</div>
                                @endif

                                <div class="product-body">
                                    <h3 class="product-name">{{ $product->nama_produk }}</h3>
                                    <p class="product-category">
                                        {{ $product->kategori ?: 'Kategori belum diisi' }}
                                    </p>
                                    <p class="product-price">{{ $rupiah($product->harga) }}</p>
                                    <p class="product-stock">
                                        Stok: {{ $product->stock?->jumlah ?? 0 }}
                                        {{ $product->stock?->satuan ?? 'pcs' }}
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty">
                        Belum ada produk yang terdaftar.
                        <br><br>
                        <a class="text-link" href="{{ route('admin.products.create') }}">
                            + Tambah Produk
                        </a>
                    </div>
                @endif
            </section>

            <section class="panel">
                <div class="panel-heading">
                    <div>
                        <h2>🧾 Riwayat Penjualan Terbaru</h2>
                        <p>Lima transaksi terakhir yang tercatat.</p>
                    </div>

                    <a class="text-link" href="{{ route('admin.sales.history') }}">
                        Lihat Semua Transaksi →
                    </a>
                </div>

                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Kasir</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentSales as $sale)
                                @php
                                    $status = strtolower(trim((string) $sale->status));
                                    $pending = in_array($status, ['pending', 'menunggu']);
                                    $cancelled = in_array($status, ['dibatalkan', 'batal', 'cancelled']);
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        {{ $sale->tanggal
                                            ? \Illuminate\Support\Carbon::parse($sale->tanggal)->format('d/m/Y H:i')
                                            : '-' }}
                                    </td>
                                    <td>
                                        {{ $sale->user?->nama ?? $sale->user?->username ?? 'Kasir' }}
                                    </td>
                                    <td>{{ $rupiah($sale->total) }}</td>
                                    <td>
                                        <span class="status {{ $pending ? 'status-pending' : '' }} {{ $cancelled ? 'status-cancelled' : '' }}">
                                            {{ $sale->status ?: 'Belum ada status' }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <div class="empty">Belum ada riwayat penjualan.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </section>
    </main>
</div>
</body>
</html>
