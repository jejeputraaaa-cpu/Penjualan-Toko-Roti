<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Produk - Modern Bakery</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f7f4ee;
            color: #3b2721;
        }

        /* ── Navbar ── */
        .navbar {
            background: white;
            border-bottom: 1px solid #ddd6cc;
            padding: 22px 55px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand {
            font-family: Georgia, serif;
            font-size: 28px;
            font-weight: bold;
            color: #7d3028;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 16px;
        }

        .logout-button {
            border: 1px solid #ddd;
            background: white;
            padding: 10px 18px;
            border-radius: 7px;
            cursor: pointer;
            font-size: 15px;
        }

        .logout-button:hover {
            background: #f5eae2;
        }

        /* ── Layout ── */
        .container {
            width: 90%;
            max-width: 900px;
            margin: 45px auto;
        }

        /* ── Page Header ── */
        .page-header {
            margin-bottom: 25px;
        }

        .page-header h1 {
            margin: 0;
            font-family: Georgia, serif;
            font-size: 36px;
        }

        .page-header p {
            margin-top: 8px;
            color: #756861;
            font-size: 16px;
        }

        /* ── Breadcrumb ── */
        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 14px;
            color: #81766f;
        }

        .breadcrumb a {
            color: #7d3028;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        /* ── Card ── */
        .card {
            background: white;
            border: 1px solid #e2ddd5;
            border-radius: 12px;
            padding: 32px 36px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .03);
        }

        /* ── Foto + Info utama ── */
        .product-top {
            display: flex;
            gap: 32px;
            align-items: flex-start;
            margin-bottom: 32px;
        }

        .product-photo {
            flex-shrink: 0;
        }

        .product-photo img {
            width: 220px;
            height: 190px;
            object-fit: cover;
            border-radius: 12px;
            border: 1px solid #e2ddd5;
            display: block;
        }

        .no-photo {
            width: 220px;
            height: 190px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #f7f4ee;
            border: 2px dashed #c9bdb0;
            border-radius: 12px;
            color: #81766f;
            font-size: 14px;
            text-align: center;
        }

        .no-photo span {
            font-size: 36px;
        }

        .product-info {
            flex: 1;
        }

        .product-name {
            font-family: Georgia, serif;
            font-size: 28px;
            font-weight: bold;
            margin: 0 0 10px;
            color: #3b2721;
        }

        .product-category {
            display: inline-block;
            background: #f4e8dd;
            color: #793c2c;
            font-size: 13px;
            font-weight: bold;
            padding: 5px 12px;
            border-radius: 20px;
            margin-bottom: 18px;
        }

        .product-price {
            font-size: 30px;
            font-weight: bold;
            color: #7d3028;
            margin-bottom: 18px;
        }

        .product-desc {
            color: #5a4a43;
            font-size: 15px;
            line-height: 1.7;
            margin: 0;
        }

        .product-desc.empty {
            color: #81766f;
            font-style: italic;
        }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid #eee9e2;
            margin: 0 0 28px;
        }

        /* ── Stok Section ── */
        .section-title {
            font-family: Georgia, serif;
            font-size: 22px;
            margin: 0 0 20px;
            color: #3b2721;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .info-box {
            background: #faf7f2;
            border: 1px solid #e8e1d8;
            border-radius: 10px;
            padding: 18px 20px;
        }

        .info-box-label {
            font-size: 12px;
            font-weight: bold;
            color: #81766f;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }

        .info-box-value {
            font-size: 22px;
            font-weight: bold;
            color: #3b2721;
        }

        .info-box-unit {
            font-size: 13px;
            color: #81766f;
            margin-top: 3px;
        }

        .stock-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .stock-ok   { background: #e3f5e9; color: #2e7d32; }
        .stock-low  { background: #fff3cd; color: #856404; }
        .stock-empty { background: #fbe8e6; color: #a12b24; }

        /* ── Keterangan stok ── */
        .keterangan-box {
            background: #faf7f2;
            border: 1px solid #e8e1d8;
            border-radius: 10px;
            padding: 16px 20px;
            font-size: 14px;
            color: #5a4a43;
            line-height: 1.6;
            margin-bottom: 28px;
        }

        .keterangan-box.empty {
            color: #81766f;
            font-style: italic;
        }

        /* ── Meta info ── */
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 28px;
        }

        .meta-item {
            font-size: 13px;
            color: #81766f;
        }

        .meta-item strong {
            color: #3b2721;
            display: block;
            margin-top: 2px;
            font-size: 14px;
        }

        /* ── Tombol aksi ── */
        .action-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 24px;
            border-top: 1px solid #eee9e2;
            gap: 12px;
        }

        .back-button {
            display: inline-block;
            padding: 12px 20px;
            border: 1px solid #d7d0c8;
            border-radius: 8px;
            color: #5a4a43;
            text-decoration: none;
            font-size: 14px;
            background: white;
        }

        .back-button:hover {
            background: #f5eae2;
            border-color: #c9bdb0;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .edit-button {
            display: inline-block;
            padding: 12px 22px;
            background: #f4e8dd;
            color: #793c2c;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
        }

        .edit-button:hover {
            background: #ebddd2;
        }

        .delete-button {
            padding: 12px 22px;
            background: #fbe8e6;
            color: #a12b24;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            font-family: Arial, Helvetica, sans-serif;
        }

        .delete-button:hover {
            background: #f5d0cd;
        }

        /* ── Alert ── */
        .alert-success {
            background: #e3f5e9;
            color: #2e7d32;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
        }

        .alert-error {
            background: #fbe8e6;
            color: #a12b24;
            border: 1px solid #edc3bf;
            border-radius: 8px;
            padding: 14px 18px;
            margin-bottom: 22px;
            font-size: 14px;
        }
    </style>
</head>

<body>

    {{-- ── Navbar ── --}}
    <nav class="navbar">
        <div class="brand">Modern Bakery</div>

        <div class="user-area">
            <span>{{ auth()->user()->nama }}</span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-button">Keluar</button>
            </form>
        </div>
    </nav>

    {{-- ── Main Content ── --}}
    <div class="container">

        {{-- Breadcrumb --}}
        <div class="breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
            <span>›</span>
            <a href="{{ route('admin.products.index') }}">Data Produk</a>
            <span>›</span>
            <span>{{ $product->nama_produk }}</span>
        </div>

        {{-- Page Header --}}
        <div class="page-header">
            <h1>Detail Produk</h1>
            <p>Informasi lengkap produk dan stok saat ini.</p>
        </div>

        {{-- Flash Messages --}}
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        {{-- Card --}}
        <div class="card">

            {{-- ── Foto + Info Utama ── --}}
            <div class="product-top">

                {{-- Foto --}}
                <div class="product-photo">
                    @if ($product->foto_produk)
                        <img
                            src="{{ asset('storage/' . $product->foto_produk) }}"
                            alt="Foto {{ $product->nama_produk }}"
                        >
                    @else
                        <div class="no-photo">
                            <span>🍞</span>
                            Belum ada foto produk
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="product-info">
                    <h2 class="product-name">{{ $product->nama_produk }}</h2>

                    <span class="product-category">{{ $product->kategori }}</span>

                    <div class="product-price">
                        Rp{{ number_format($product->harga, 0, ',', '.') }}
                    </div>

                    @if ($product->deskripsi)
                        <p class="product-desc">{{ $product->deskripsi }}</p>
                    @else
                        <p class="product-desc empty">Tidak ada deskripsi produk.</p>
                    @endif
                </div>
            </div>

            {{-- ── Informasi Stok ── --}}
            <hr class="divider">

            <h3 class="section-title">Stok Produk</h3>

            @php
                $jumlah = $product->stock?->jumlah ?? 0;
                $satuan = $product->stock?->satuan ?? 'pcs';
                $stockClass = $jumlah === 0 ? 'stock-empty' : ($jumlah <= 5 ? 'stock-low' : 'stock-ok');
                $stockLabel = $jumlah === 0 ? 'Habis' : ($jumlah <= 5 ? 'Stok Menipis' : 'Tersedia');
            @endphp

            <div class="info-grid">
                <div class="info-box">
                    <div class="info-box-label">Jumlah Stok</div>
                    <div class="info-box-value">{{ number_format($jumlah, 0, ',', '.') }}</div>
                    <div class="info-box-unit">{{ $satuan }}</div>
                </div>

                <div class="info-box">
                    <div class="info-box-label">Satuan</div>
                    <div class="info-box-value" style="font-size: 20px;">{{ $satuan }}</div>
                </div>

                <div class="info-box">
                    <div class="info-box-label">Status Stok</div>
                    <div style="margin-top: 6px;">
                        <span class="stock-badge {{ $stockClass }}">{{ $stockLabel }}</span>
                    </div>
                </div>
            </div>

            {{-- Keterangan Stok --}}
            @if ($product->stock?->keterangan)
                <div style="margin-bottom: 8px; font-size: 13px; font-weight: bold; color: #81766f; text-transform: uppercase; letter-spacing: 0.8px;">
                    Keterangan Stok
                </div>
                <div class="keterangan-box">
                    {{ $product->stock->keterangan }}
                </div>
            @endif

            {{-- ── Meta Info ── --}}
            <hr class="divider">

            <div class="meta-grid">
                <div class="meta-item">
                    Harga Satuan
                    <strong>Rp{{ number_format($product->harga, 0, ',', '.') }}</strong>
                </div>

                <div class="meta-item">
                    Kategori
                    <strong>{{ $product->kategori }}</strong>
                </div>

                @if ($product->created_at)
                    <div class="meta-item">
                        Ditambahkan
                        <strong>{{ $product->created_at->translatedFormat('d F Y') }}</strong>
                    </div>
                @endif

                @if ($product->updated_at && $product->updated_at->ne($product->created_at))
                    <div class="meta-item">
                        Terakhir Diperbarui
                        <strong>{{ $product->updated_at->translatedFormat('d F Y, H:i') }}</strong>
                    </div>
                @endif
            </div>

            {{-- ── Tombol Aksi ── --}}
            <div class="action-bar">
                <a href="{{ route('admin.products.index') }}" class="back-button">
                    ← Kembali ke Daftar Produk
                </a>

                <div class="action-buttons">
                    <a
                        href="{{ route('admin.products.edit', $product) }}"
                        class="edit-button"
                    >
                        ✏️ Edit Produk
                    </a>

                    @if (! $product->saleDetails()->exists())
                        <form
                            action="{{ route('admin.products.destroy', $product) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus produk ini? Tindakan tidak dapat dibatalkan.')"
                        >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button">
                                🗑️ Hapus Produk
                            </button>
                        </form>
                    @endif
                </div>
            </div>

        </div>{{-- /card --}}
    </div>{{-- /container --}}

</body>
</html>
