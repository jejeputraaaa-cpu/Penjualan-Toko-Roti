
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Produk | Modern Bakery</title>

    <style>
        * { box-sizing: border-box; }

        :root {
            --brown: #793c2c;
            --brown-dark: #54291f;
            --cream: #faf7f2;
            --border: #eee5dc;
            --muted: #81766e;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--cream);
            color: #382720;
        }

        .layout { display: flex; min-height: 100vh; }

        .sidebar {
            width: 245px;
            flex-shrink: 0;
            padding: 25px 16px;
            background: #4A2D23;
            border-right: 1px solid var(--border);
        }

        .brand {
            font-family: Georgia, serif;
            font-size: 23px;
            font-weight: bold;
            color: #FFFFFF;
            padding: 8px 10px 30px;
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

        .menu:hover {
            background: #654332;
            color: #FFFFFF;
            font-weight: bold;
        }

        .menu.active,
        .menu.active:hover {
            background: #F3E6D6;
            color: #4A2D23;
            font-weight: bold;
        }

        .menu-disabled {
            color: #a59a91;
            cursor: not-allowed;
        }

        .menu-badge {
            margin-left: auto;
            font-size: 9px;
            background: #f4eee8;
            color: #8b7768;
            border-radius: 10px;
            padding: 4px 6px;
        }

        .main { flex: 1; min-width: 0; }

        .topbar {
            background: #fff;
            padding: 18px 30px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .topbar small { color: var(--muted); }

        .user {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #f0dfd1;
            color: var(--brown);
            display: grid;
            place-items: center;
            font-weight: bold;
            flex-shrink: 0;
        }

        .logout {
            border: 1px solid var(--border);
            background: white;
            color: var(--brown);
            padding: 9px 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .logout:hover { background: #f5eae2; }

        .content {
            padding: 30px;
            max-width: 1500px;
            margin: auto;
        }

        .heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        h1 {
            font-family: Georgia, serif;
            font-size: 30px;
            margin: 0 0 8px;
        }

        .sub {
            color: var(--muted);
            margin: 0;
            font-size: 14px;
        }

        .btn {
            display: inline-block;
            border: 0;
            border-radius: 8px;
            padding: 12px 16px;
            text-decoration: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 13px;
            font-family: Arial, sans-serif;
        }

        .btn-primary { background: var(--brown); color: white; }
        .btn-primary:hover { background: var(--brown-dark); }
        .btn-edit { background: #f4e8dd; color: var(--brown); }
        .btn-delete { background: #fbe8e6; color: #a12b24; }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 25px;
        }

        .stat, .table-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
        }

        .stat { padding: 20px; }
        .stat-label { color: var(--muted); font-size: 13px; }
        .stat-number { font-size: 27px; font-weight: bold; margin-top: 12px; }
        .stat-note { color: var(--muted); font-size: 12px; margin-top: 6px; }

        .notice {
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        .success { background: #e7f6e9; color: #276738; }
        .error { background: #f9e1df; color: #a12b24; }

        .table-card { overflow: hidden; }

        .table-heading {
            padding: 20px;
            border-bottom: 1px solid var(--border);
        }

        .table-heading strong { display: block; margin-bottom: 5px; }
        .table-heading small { color: var(--muted); }

        .table-scroll { overflow-x: auto; }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        th {
            text-align: left;
            background: #fcfaf7;
            color: #76665c;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        th, td {
            padding: 15px 18px;
            border-bottom: 1px solid #f0eae4;
        }

        td { font-size: 13px; }
        tbody tr:hover { background: #fdfbf8; }
        tbody tr:last-child td { border-bottom: 0; }

        .product-cell {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 200px;
        }

        .product-image {
            width: 58px;
            height: 58px;
            flex-shrink: 0;
            border-radius: 9px;
            object-fit: cover;
            background: #f2e9df;
        }

        .no-image {
            display: grid;
            place-items: center;
            color: #9b7863;
            font-size: 10px;
            text-align: center;
        }

        .product-name { font-weight: bold; margin-bottom: 5px; }
        .product-desc { color: var(--muted); font-size: 11px; }

        .category {
            display: inline-block;
            background: #f5eee7;
            color: #76503d;
            border-radius: 20px;
            padding: 6px 9px;
        }

        .price {
            font-weight: bold;
            color: var(--brown);
            white-space: nowrap;
        }

        .stock-badge {
            display: inline-block;
            border-radius: 20px;
            padding: 6px 9px;
            background: #e7f5e9;
            color: #276738;
            white-space: nowrap;
        }

        .stock-low { background: #fff0d9; color: #925b0a; }
        .stock-empty { background: #fbe8e6; color: #a12b24; }

        .actions { display: flex; align-items: center; gap: 7px; }
        .actions .btn { padding: 8px 10px; }
        .actions form { margin: 0; }

        .empty {
            padding: 55px 20px;
            text-align: center;
            color: var(--muted);
        }

        @media (max-width: 900px) {
            .sidebar { width: 210px; }
            .content { padding: 22px 18px; }
            .topbar { padding: 16px 20px; }
            .stats { gap: 10px; }
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
                overflow-x: auto;
                gap: 5px;
                padding-bottom: 5px;
            }

            .menu {
                flex-shrink: 0;
                white-space: nowrap;
                padding: 10px;
            }

            .heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .stats { grid-template-columns: 1fr; }

            .topbar {
                padding: 14px;
                flex-wrap: wrap;
            }

            .user { gap: 8px; }
            .content { padding: 20px 12px; }
            h1 { font-size: 26px; }
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

        <a class="menu {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
           href="{{ url('/admin/pesanan-online') }}">
            🔔 Notifikasi Pesanan Online
        </a>

        <a class="menu {{ request()->routeIs('admin.sales.history', 'admin.sales.show', 'admin.sales.receipt') ? 'active' : '' }}"
           href="{{ route('admin.sales.history') }}">
            🧾 Riwayat Penjualan
        </a>

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
                <small>Kelola toko bakery kamu</small>
            </div>

            <div class="user">
                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->nama ?? 'A', 0, 1)) }}
                </div>

                <div>
                    <strong>{{ auth()->user()->nama ?? 'Admin' }}</strong><br>
                    <small>Administrator</small>
                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="logout" type="submit">Keluar</button>
                </form>
            </div>
        </header>

        <section class="content">
            <div class="heading">
                <div>
                    <h1>Data Produk</h1>
                    <p class="sub">
                        Kelola produk, foto, harga, kategori, dan stok bakery.
                    </p>
                </div>

                <a class="btn btn-primary" href="{{ route('admin.products.create') }}">
                    + Tambah Produk
                </a>
            </div>

            @if(session('success'))
                <div class="notice success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="notice error">{{ session('error') }}</div>
            @endif

            <div class="stats">
                <div class="stat">
                    <div class="stat-label">Total Jenis Produk</div>
                    <div class="stat-number">{{ $products->count() }}</div>
                    <div class="stat-note">Produk yang terdaftar</div>
                </div>

                <div class="stat">
                    <div class="stat-label">Stok Tersedia</div>
                    <div class="stat-number">
                        {{ $products->sum(fn ($p) => (int) ($p->stock?->jumlah ?? 0)) }}
                    </div>
                    <div class="stat-note">
                        Total unit menurut satuan masing-masing
                    </div>
                </div>

                <div class="stat">
                    <div class="stat-label">Stok Habis</div>
                    <div class="stat-number">
                        {{ $products->filter(fn ($p) => (int) ($p->stock?->jumlah ?? 0) === 0)->count() }}
                    </div>
                    <div class="stat-note">Produk yang perlu diisi ulang</div>
                </div>
            </div>

            <div class="table-card">
                <div class="table-heading">
                    <strong>Daftar Produk Bakery</strong>
                    <small>Foto, harga jual, kategori, dan ketersediaan stok.</small>
                </div>

                <div class="table-scroll">
                    @if($products->isNotEmpty())
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Produk</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($products as $product)
                                    @php
                                        $jumlah = (int) ($product->stock?->jumlah ?? 0);
                                        $satuan = $product->stock?->satuan ?? 'pcs';
                                    @endphp

                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <div class="product-cell">
                                                @if($product->foto_produk)
                                                    <img
                                                        class="product-image"
                                                        src="{{ asset('storage/' . $product->foto_produk) }}"
                                                        alt="{{ $product->nama_produk }}"
                                                    >
                                                @else
                                                    <div class="product-image no-image">
                                                        Belum ada foto
                                                    </div>
                                                @endif

                                                <div>
                                                    <div class="product-name">
                                                        {{ $product->nama_produk }}
                                                    </div>

                                                    <div class="product-desc">
                                                        {{ \Illuminate\Support\Str::limit($product->deskripsi ?? 'Tanpa deskripsi', 45) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td>
                                            <span class="category">
                                                {{ $product->kategori }}
                                            </span>
                                        </td>

                                        <td class="price">
                                            Rp{{ number_format($product->harga, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            <span class="stock-badge {{ $jumlah === 0 ? 'stock-empty' : ($jumlah <= 5 ? 'stock-low' : '') }}">
                                                {{ $jumlah }} {{ $satuan }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="actions">
                                                <a
                                                    class="btn btn-edit"
                                                    href="{{ route('admin.products.edit', $product) }}"
                                                >
                                                    Edit
                                                </a>

                                                <form
                                                    action="{{ route('admin.products.destroy', $product) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                                >
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-delete" type="submit">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty">
                            <h3>Belum ada produk 🍞</h3>
                            <p>Tambahkan produk pertama Modern Bakery.</p>

                            <a
                                class="btn btn-primary"
                                href="{{ route('admin.products.create') }}"
                            >
                                + Tambah Produk
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </main>
</div>
</body>
</html>
