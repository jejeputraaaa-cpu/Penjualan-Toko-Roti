
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Produk | Modern Bakery</title>

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
            background: white;
            border-right: 1px solid var(--border);
            padding: 25px 16px;
        }

        .brand {
            font: bold 23px Georgia, serif;
            color: var(--brown);
            padding: 8px 10px 30px;
        }

        .brand small {
            display: block;
            font: 11px Arial, sans-serif;
            color: var(--muted);
            margin-top: 7px;
            letter-spacing: 1.5px;
        }

        .menu-label {
            font-size: 10px;
            font-weight: bold;
            color: #a59a91;
            padding: 10px;
            letter-spacing: 1.5px;
        }

        .menu-list {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .menu {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #6a5b52;
            padding: 13px 12px;
            border-radius: 9px;
            font-size: 14px;
        }

        .menu:hover, .menu.active {
            background: #f5eae2;
            color: var(--brown);
            font-weight: bold;
        }

        .main { flex: 1; min-width: 0; }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            background: white;
            padding: 18px 30px;
            border-bottom: 1px solid var(--border);
        }

        .topbar small { color: var(--muted); }

        .user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            display: grid;
            place-items: center;
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

        .content {
            max-width: 1050px;
            padding: 30px;
            margin: auto;
        }

        .heading { margin-bottom: 24px; }

        h1 {
            font: 30px Georgia, serif;
            margin: 0 0 8px;
        }

        .sub {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
        }

        .card-heading {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
        }

        .card-heading strong { display: block; margin-bottom: 5px; }
        .card-heading small { color: var(--muted); }

        .form-body { padding: 24px; }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }

        .field { min-width: 0; }
        .full { grid-column: 1 / -1; }

        label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 9px;
        }

        .required { color: #b42318; }

        input, select, textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #e5d9ce;
            border-radius: 8px;
            background: white;
            color: #382720;
            font: 14px Arial, sans-serif;
            outline: none;
        }

        input:focus, select:focus, textarea:focus {
            border-color: var(--brown);
            box-shadow: 0 0 0 3px #793c2c12;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
            line-height: 1.5;
        }

        .help {
            display: block;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
            margin-top: 7px;
        }

        .error {
            color: #a12b24;
            font-size: 12px;
            margin-top: 7px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            background: #fbe8e6;
            color: #a12b24;
            font-size: 13px;
        }

        .photo-preview {
            display: none;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-top: 12px;
        }

        .section-title {
            grid-column: 1 / -1;
            padding-bottom: 10px;
            margin-bottom: -2px;
            border-bottom: 1px solid var(--border);
            color: var(--brown);
            font-weight: bold;
            font-size: 14px;
        }

        .form-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            padding: 18px 24px;
            border-top: 1px solid var(--border);
            background: #fcfaf7;
        }

        .btn {
            display: inline-block;
            border: 0;
            border-radius: 8px;
            padding: 12px 16px;
            font: bold 13px Arial, sans-serif;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: var(--brown);
            color: white;
        }

        .btn-primary:hover { background: var(--brown-dark); }

        .btn-secondary {
            background: white;
            color: var(--brown);
            border: 1px solid var(--border);
        }

        @media (max-width: 850px) {
            .sidebar { width: 200px; }
            .content { padding: 22px 16px; }
        }

        @media (max-width: 600px) {
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
            }

            .menu { flex-shrink: 0; white-space: nowrap; }
            .topbar { padding: 14px; flex-wrap: wrap; }
            .form-grid { grid-template-columns: 1fr; }
            .full, .section-title { grid-column: auto; }
            .form-body { padding: 18px; }
            .form-footer { padding: 16px 18px; }
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

        <div class="menu-label">MENU UTAMA</div>

        <nav class="menu-list">
            <a class="menu" href="{{ route('admin.dashboard') }}">
                ▦ &nbsp; Dashboard
            </a>

            <a class="menu active" href="{{ route('admin.products.index') }}">
                ▣ &nbsp; Data Produk
            </a>

            <a class="menu" href="{{ route('admin.sales.create') }}">
                🛒 &nbsp; Kasir Offline
            </a>

            <a class="menu" href="{{ route('admin.sales.history') }}">
                ▤ &nbsp; Riwayat Penjualan
            </a>

            <a class="menu" href="{{ route('owner.reports') }}">
                ▥ &nbsp; Laporan Penjualan
            </a>

            <a class="menu" href="{{ route('owner.profile') }}">
                🏪 &nbsp; Profil Toko
            </a>

            <a class="menu" href="{{ route('owner.users') }}">
                ♙ &nbsp; Manajemen Pengguna
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
                <h1>Tambah Produk</h1>
                <p class="sub">
                    Tambahkan produk baru ke katalog Modern Bakery.
                    Foto, harga, dan informasi stok dapat diisi di bawah ini.
                </p>
            </div>

            @if($errors->any())
                <div class="alert">
                    <strong>Yuk, periksa kembali isianmu:</strong>
                    <ul style="margin-bottom:0; padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('admin.products.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="card"
            >
                @csrf

                <div class="card-heading">
                    <strong>Informasi Produk</strong>
                    <small>Kolom bertanda * wajib diisi.</small>
                </div>

                <div class="form-body">
                    <div class="form-grid">

                        <div class="field full">
                            <label for="nama_produk">
                                Nama Produk <span class="required">*</span>
                            </label>
                            <input
                                type="text"
                                id="nama_produk"
                                name="nama_produk"
                                value="{{ old('nama_produk') }}"
                                placeholder="Contoh: Roti Cokelat"
                                maxlength="255"
                                required
                            >
                            @error('nama_produk')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="kategori">
                                Kategori <span class="required">*</span>
                            </label>
                            <select id="kategori" name="kategori" required>
                                <option value="">-- Pilih kategori --</option>
                                @foreach(['Roti', 'Donat', 'Kue', 'Pastry', 'Lainnya'] as $kategori)
                                    <option
                                        value="{{ $kategori }}"
                                        {{ old('kategori') === $kategori ? 'selected' : '' }}
                                    >
                                        {{ $kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="harga">
                                Harga Jual (Rp) <span class="required">*</span>
                            </label>
                            <input
                                type="number"
                                id="harga"
                                name="harga"
                                value="{{ old('harga') }}"
                                min="0"
                                step="1"
                                placeholder="Contoh: 12000"
                                required
                            >
                            <small class="help">Masukkan angka saja, tanpa Rp atau titik.</small>
                            @error('harga')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field full">
                            <label for="deskripsi">Keterangan Produk</label>
                            <textarea
                                id="deskripsi"
                                name="deskripsi"
                                placeholder="Contoh: Roti lembut dengan isian cokelat."
                            >{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field full">
                            <label for="foto_produk">Foto Produk</label>
                            <input
                                type="file"
                                id="foto_produk"
                                name="foto_produk"
                                accept="image/jpeg,image/png,image/webp"
                            >
                            <small class="help">
                                Pilih foto JPG, JPEG, PNG, atau WEBP.
                                Foto akan digunakan juga di katalog kasir jika halaman kasir mengambil data produk yang sama.
                            </small>

                            <img
                                id="photoPreview"
                                class="photo-preview"
                                alt="Pratinjau foto produk"
                            >

                            @error('foto_produk')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="section-title">Informasi Stok Awal</div>

                        <div class="field">
                            <label for="jumlah_stok">Jumlah Stok</label>
                            <input
                                type="number"
                                id="jumlah_stok"
                                name="jumlah_stok"
                                min="0"
                                step="1"
                                value="{{ old('jumlah_stok', 0) }}"
                                placeholder="Contoh: 20"
                            >
                            <small class="help">
                                Isi jumlah stok awal produk. Boleh 0 jika belum ada stok.
                            </small>
                            @error('jumlah_stok')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="satuan">Satuan Stok</label>
                            <select id="satuan" name="satuan">
                                @foreach(['pcs', 'buah', 'pack', 'box', 'lusin', 'kg'] as $satuan)
                                    <option
                                        value="{{ $satuan }}"
                                        {{ old('satuan', 'pcs') === $satuan ? 'selected' : '' }}
                                    >
                                        {{ ucfirst($satuan) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('satuan')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="field full">
                            <label for="keterangan_stok">Keterangan Stok</label>
                            <textarea
                                id="keterangan_stok"
                                name="keterangan_stok"
                                placeholder="Contoh: Stok awal produk"
                            >{{ old('keterangan_stok', 'Stok awal produk') }}</textarea>
                            @error('keterangan_stok')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="form-footer">
                    <a
                        class="btn btn-secondary"
                        href="{{ route('admin.products.index') }}"
                    >
                        Batal
                    </a>

                    <button class="btn btn-primary" type="submit">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </section>
    </main>
</div>

<script>
    const photoInput = document.getElementById('foto_produk');
    const photoPreview = document.getElementById('photoPreview');

    photoInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            photoPreview.removeAttribute('src');
            photoPreview.style.display = 'none';
            return;
        }

        if (!file.type.startsWith('image/')) {
            alert('Pilih file berupa gambar ya.');
            this.value = '';
            photoPreview.style.display = 'none';
            return;
        }

        photoPreview.src = URL.createObjectURL(file);
        photoPreview.style.display = 'block';
    });
</script>
</body>
</html>
