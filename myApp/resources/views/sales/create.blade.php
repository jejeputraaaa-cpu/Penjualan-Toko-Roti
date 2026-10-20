
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Modern Bakery Menganto</title>

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f7f4ee;
            color: #3d2b1f;
        }

        .container {
            width: 94%;
            max-width: 1400px;
            margin: 30px auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .header h1 {
            margin: 0;
            font-size: 30px;
        }

        .header p {
            color: #777;
            margin: 8px 0 0;
        }

        .back-btn {
            text-decoration: none;
            background: white;
            color: #5a3825;
            padding: 12px 18px;
            border-radius: 8px;
            border: 1px solid #ddd;
            white-space: nowrap;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(0,0,0,.05);
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .section-heading h2 {
            margin: 0;
            font-size: 21px;
        }

        .product-count {
            background: #f4eee6;
            color: #6b442f;
            border-radius: 20px;
            padding: 8px 13px;
            font-size: 13px;
        }

        .search-box {
            width: 100%;
            padding: 13px 15px;
            margin-bottom: 20px;
            border: 1px solid #ddd2c6;
            border-radius: 9px;
            font-size: 15px;
            outline-color: #8b6046;
        }

        /* KATALOG PRODUK */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .product-card {
            border: 1px solid #eee4da;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
            min-width: 0;
            transition: transform .2s, box-shadow .2s;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 18px rgba(75, 48, 32, .10);
        }

        .product-photo {
            width: 100%;
            height: 165px;
            object-fit: cover;
            background: #f4eee6;
            display: block;
        }

        .photo-placeholder {
            height: 165px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f4eee6;
            font-size: 48px;
        }

        .product-info {
            padding: 15px;
            display: flex;
            flex-direction: column;
            flex: 1;
        }

        .product-category {
            font-size: 11px;
            color: #8b6046;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: .5px;
            margin-bottom: 7px;
        }

        .product-name {
            font-size: 16px;
            line-height: 1.4;
            margin: 0 0 8px;
            overflow-wrap: anywhere;
        }

        .product-description {
            color: #777;
            font-size: 13px;
            line-height: 1.5;
            margin: 0 0 12px;
            overflow-wrap: anywhere;
            flex: 1;
        }

        .product-price {
            color: #6b2d1c;
            font-size: 17px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .product-stock {
            color: #777;
            font-size: 12px;
            margin-bottom: 13px;
        }

        button {
            border: none;
            cursor: pointer;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-add {
            width: 100%;
            background: #6b442f;
            color: white;
            margin-top: auto;
        }

        .btn-add:hover { background: #563624; }

        .btn-add:disabled {
            background: #bbb;
            cursor: not-allowed;
        }

        .no-products {
            display: none;
            padding: 30px;
            text-align: center;
            color: #888;
            background: #faf8f5;
            border-radius: 10px;
        }

        /* KERANJANG */
        .table-wrapper {
            overflow-x: auto;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        .cart-table th {
            background: #f4eee6;
            padding: 14px;
            text-align: left;
            white-space: nowrap;
        }

        .cart-table td {
            padding: 14px;
            border-bottom: 1px solid #eee;
        }

        .qty-control {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .qty-btn {
            width: 32px;
            height: 32px;
            padding: 0;
            background: #eee5dc;
            color: #4b3020;
            font-size: 18px;
        }

        .qty-number {
            min-width: 20px;
            text-align: center;
            font-weight: bold;
        }

        .btn-remove {
            background: #f7dddd;
            color: #a32929;
            padding: 9px 12px;
        }

        .empty-cart {
            text-align: center;
            color: #888;
            padding: 30px !important;
        }

        /* PEMBAYARAN */
        .summary {
            display: flex;
            justify-content: flex-end;
        }

        .summary-box {
            width: 440px;
            max-width: 100%;
        }

        .total-box {
            background: #f4eee6;
            padding: 22px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .total-label {
            color: #777;
            margin-bottom: 7px;
        }

        .total-value {
            font-size: 32px;
            font-weight: bold;
            color: #6b2d1c;
            overflow-wrap: anywhere;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            font-size: 14px;
        }

        select, input {
            width: 100%;
            padding: 13px;
            border: 1px solid #d8d1c8;
            border-radius: 8px;
            font-size: 15px;
            background: white;
        }

        input:read-only {
            background: #f2f2f2;
        }

        .change-box {
            margin-top: 15px;
            background: #edf7ee;
            border-radius: 10px;
            padding: 18px;
        }

        .change-label { color: #666; }

        .change-value {
            font-size: 25px;
            font-weight: bold;
            color: #2f7d32;
            margin-top: 5px;
        }

        .btn-payment {
            width: 100%;
            margin-top: 20px;
            background: #6b442f;
            color: white;
            font-size: 16px;
            padding: 16px;
        }

        .btn-payment:hover { background: #563624; }

        .error-box {
            background: #fdecec;
            color: #a32929;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        @media (max-width: 1100px) {
            .product-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 750px) {
            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 12px;
            }

            .product-photo, .photo-placeholder {
                height: 135px;
            }

            .card { padding: 16px; }

            .header h1 { font-size: 24px; }

            .payment-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 380px) {
            .product-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
<div class="container">

    <div class="header">
        <div>
            <h1>Transaksi Penjualan</h1>
            <p>Pilih roti favorit pelanggan, lalu proses pembayarannya.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="back-btn">
            ← Dashboard
        </a>
    </div>

    @if ($errors->any())
        <div class="error-box">
            <strong>Transaksi gagal:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.sales.store') }}" method="POST" id="cashierForm">
        @csrf

        <!-- KATALOG PRODUK -->
        <div class="card">
            <div class="section-heading">
                <h2>🍞 Pilih Produk</h2>
                <span class="product-count">
                    {{ $products->count() }} produk tersedia
                </span>
            </div>

            <input
                type="search"
                id="productSearch"
                class="search-box"
                placeholder="Cari nama roti atau kategori..."
                autocomplete="off"
            >

            <div class="product-grid" id="productGrid">
                @forelse ($products as $product)
                    <div
                        class="product-card"
                        data-search="{{ strtolower($product->nama_produk . ' ' . ($product->kategori ?? '')) }}"
                    >
                        @if ($product->foto_produk)
                            <img
                                class="product-photo"
                                src="{{ asset('storage/' . $product->foto_produk) }}"
                                alt="{{ $product->nama_produk }}"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                            >
                            <div class="photo-placeholder" style="display:none;">
                                🥐
                            </div>
                        @else
                            <div class="photo-placeholder">🥐</div>
                        @endif

                        <div class="product-info">
                            <div class="product-category">
                                {{ $product->kategori ?: 'Produk Bakery' }}
                            </div>

                            <h3 class="product-name">
                                {{ $product->nama_produk }}
                            </h3>

                            <p class="product-description">
                                {{ $product->deskripsi ?: 'Roti lezat dari Modern Bakery Menganto.' }}
                            </p>

                            <div class="product-price">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </div>

                            <div class="product-stock">
                                Stok: {{ $product->stock?->jumlah ?? 0 }}
                                {{ $product->stock?->satuan ?? 'pcs' }}
                            </div>

                            <button
                                type="button"
                                class="btn-add"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->nama_produk }}"
                                data-price="{{ $product->harga }}"
                                data-stock="{{ $product->stock?->jumlah ?? 0 }}"
                                onclick="addProduct(this)"
                                @disabled(($product->stock?->jumlah ?? 0) <= 0)
                            >
                                {{ ($product->stock?->jumlah ?? 0) <= 0 ? 'Stok Habis' : '+ Tambah ke Keranjang' }}
                            </button>
                        </div>
                    </div>
                @empty
                    <p>Belum ada produk. Silakan tambahkan produk terlebih dahulu.</p>
                @endforelse
            </div>

            <div id="noProducts" class="no-products">
                Produk yang kamu cari tidak ditemukan.
            </div>
        </div>

        <!-- KERANJANG -->
        <div class="card">
            <div class="section-heading">
                <h2>🛒 Keranjang Belanja</h2>
            </div>

            <div class="table-wrapper">
                <table class="cart-table">
                    <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>

                    <tbody id="cartBody">
                    <tr>
                        <td colspan="5" class="empty-cart">
                            Belum ada produk yang dipilih.
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PEMBAYARAN -->
        <div class="card">
            <div class="section-heading">
                <h2>💳 Pembayaran</h2>
            </div>

            <div class="summary">
                <div class="summary-box">
                    <div class="total-box">
                        <div class="total-label">Total Belanja</div>
                        <div class="total-value" id="totalDisplay">Rp 0</div>
                    </div>

                    <div class="payment-grid">
                        <div>
                            <label for="metode_bayar">Metode Pembayaran</label>
                            <select
                                name="metode_bayar"
                                id="metode_bayar"
                                onchange="paymentMethodChanged()"
                            >
                                <option value="Cash">Cash</option>
                                <option value="QRIS">QRIS</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>

                        <div>
                            <label for="jumlah_bayar">Uang Dibayar</label>
                            <input
                                type="number"
                                name="jumlah_bayar"
                                id="jumlah_bayar"
                                value="0"
                                min="0"
                                oninput="calculateChange()"
                            >
                        </div>
                    </div>

                    <div class="change-box">
                        <div class="change-label">Kembalian</div>
                        <div class="change-value" id="changeDisplay">Rp 0</div>
                    </div>

                    <button type="submit" class="btn-payment">
                        PROSES PEMBAYARAN
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    let cart = [];

    function rupiah(number) {
        return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    // Biar nama produk aman saat ditampilkan lewat HTML JavaScript.
    function escapeHTML(value) {
        return String(value).replace(/[&<>"']/g, function (character) {
            const entities = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return entities[character];
        });
    }

    // TAMBAH PRODUK DARI KARTU
    function addProduct(button) {
        const id = Number(button.dataset.id);
        const name = button.dataset.name;
        const price = Number(button.dataset.price);
        const stock = Number(button.dataset.stock);

        if (stock <= 0) {
            alert('Stok produk ini habis.');
            return;
        }

        const existing = cart.find(item => item.id === id);

        if (existing) {
            if (existing.qty >= stock) {
                alert('Jumlah melebihi stok yang tersedia.');
                return;
            }

            existing.qty++;
        } else {
            cart.push({
                id: id,
                name: name,
                price: price,
                stock: stock,
                qty: 1
            });
        }

        renderCart();
    }

    // TAMPILKAN KERANJANG
    function renderCart() {
        const body = document.getElementById('cartBody');
        body.innerHTML = '';

        if (cart.length === 0) {
            body.innerHTML = `
                <tr>
                    <td colspan="5" class="empty-cart">
                        Belum ada produk yang dipilih.
                    </td>
                </tr>
            `;
        } else {
            cart.forEach((item, index) => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>
                        <strong>${escapeHTML(item.name)}</strong>
                        <input type="hidden" name="product_id[]" value="${item.id}">
                    </td>

                    <td>${rupiah(item.price)}</td>

                    <td>
                        <div class="qty-control">
                            <button type="button" class="qty-btn"
                                onclick="decreaseQty(${index})">−</button>

                            <span class="qty-number">${item.qty}</span>

                            <button type="button" class="qty-btn"
                                onclick="increaseQty(${index})">+</button>
                        </div>

                        <input type="hidden" name="jumlah[]" value="${item.qty}">
                    </td>

                    <td><strong>${rupiah(item.price * item.qty)}</strong></td>

                    <td>
                        <button type="button" class="btn-remove"
                            onclick="removeProduct(${index})">Hapus</button>
                    </td>
                `;

                body.appendChild(row);
            });
        }

        calculateTotal();
    }

    function increaseQty(index) {
        const item = cart[index];

        if (item.qty >= item.stock) {
            alert('Jumlah melebihi stok yang tersedia.');
            return;
        }

        item.qty++;
        renderCart();
    }

    function decreaseQty(index) {
        if (cart[index].qty > 1) {
            cart[index].qty--;
        } else {
            cart.splice(index, 1);
        }

        renderCart();
    }

    function removeProduct(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function getTotal() {
        return cart.reduce((total, item) => {
            return total + item.price * item.qty;
        }, 0);
    }

    function calculateTotal() {
        const total = getTotal();

        document.getElementById('totalDisplay').innerText = rupiah(total);

        // QRIS dan Transfer otomatis dibayar sebesar total belanja.
        const method = document.getElementById('metode_bayar').value;
        const paymentInput = document.getElementById('jumlah_bayar');

        if (method !== 'Cash') {
            paymentInput.value = total;
            paymentInput.readOnly = true;
        }

        calculateChange();
    }

    function paymentMethodChanged() {
        const method = document.getElementById('metode_bayar').value;
        const paymentInput = document.getElementById('jumlah_bayar');

        if (method === 'Cash') {
            paymentInput.value = '';
            paymentInput.readOnly = false;
        } else {
            paymentInput.value = getTotal();
            paymentInput.readOnly = true;
        }

        calculateChange();
    }

    function calculateChange() {
        const total = getTotal();
        const paid = Number(document.getElementById('jumlah_bayar').value) || 0;
        const change = Math.max(0, paid - total);

        document.getElementById('changeDisplay').innerText = rupiah(change);
    }

    // CARI PRODUK
    document.getElementById('productSearch').addEventListener('input', function () {
        const keyword = this.value.toLowerCase().trim();
        const cards = document.querySelectorAll('.product-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const matches = card.dataset.search.includes(keyword);

            card.style.display = matches ? 'flex' : 'none';

            if (matches) visibleCount++;
        });

        document.getElementById('noProducts').style.display =
            visibleCount === 0 ? 'block' : 'none';
    });

    // CEGAH TRANSAKSI KOSONG ATAU PEMBAYARAN CASH KURANG
    document.getElementById('cashierForm').addEventListener('submit', function (event) {
        if (cart.length === 0) {
            event.preventDefault();
            alert('Silakan pilih minimal satu produk.');
            return;
        }

        const total = getTotal();
        const paid = Number(document.getElementById('jumlah_bayar').value) || 0;
        const method = document.getElementById('metode_bayar').value;

        if (method === 'Cash' && paid < total) {
            event.preventDefault();
            alert('Uang pembayaran masih kurang.');
        }
    });
</script>
</body>
</html>
