<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Menu - Modern Bakery</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --primary: #6c2924;
            --primary-dark: #54201c;
            --cream: #f7f1e8;
            --cream-light: #fcfaf7;
            --gold: #b9955a;
            --text: #2d2926;
            --muted: #77706a;
            --border: #e7dfd5;
            --white: #ffffff;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--cream-light);
            color: var(--text);
        }

        /* ================= NAVBAR ================= */

        .navbar {
            height: 76px;
            background: rgba(255, 255, 255, 0.97);
            border-bottom: 1px solid var(--border);

            display: flex;
            align-items: center;
            justify-content: space-between;

            padding: 0 6%;

            position: sticky;
            top: 0;
            z-index: 100;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;

            text-decoration: none;
            color: var(--primary);
        }

        .brand-icon {
            width: 42px;
            height: 42px;

            border-radius: 50%;

            background: var(--primary);
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-family: Georgia, serif;
            font-size: 16px;
            font-weight: bold;
        }

        .brand-text {
            line-height: 1.1;
        }

        .brand-name {
            font-family: Georgia, serif;
            font-size: 20px;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .brand-subtitle {
            font-size: 9px;
            color: var(--gold);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 5px;
        }

        .nav-link {
            color: var(--text);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;

            transition: 0.2s;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        /* ================= HEADER ================= */

        .menu-header {
            background: var(--cream);

            padding: 42px 6% 38px;

            border-bottom: 1px solid var(--border);
        }

        .menu-header-inner {
            max-width: 1200px;
            margin: auto;
        }

        .eyebrow {
            color: var(--gold);

            font-size: 11px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;

            margin-bottom: 10px;
        }

        .menu-header h1 {
            font-family: Georgia, serif;

            font-size: 40px;
            line-height: 1.15;

            color: var(--primary);

            margin: 0 0 10px;
        }

        .menu-header p {
            max-width: 620px;

            color: var(--muted);

            font-size: 14px;
            line-height: 1.7;

            margin: 0;
        }

        /* ================= MAIN ================= */

        .container {
            max-width: 1200px;

            margin: 42px auto;

            padding: 0 20px;

            display: grid;

            grid-template-columns:
                minmax(0, 1fr)
                360px;

            gap: 35px;

            align-items: start;
        }

        /* ================= SECTION TITLE ================= */

        .section-title {
            margin-bottom: 22px;

            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 25px;
        }

        .section-title h2 {
            font-family: Georgia, serif;

            color: var(--primary);

            font-size: 26px;

            margin: 0 0 5px;
        }

        .section-title p {
            margin: 0;

            color: var(--muted);

            font-size: 14px;
        }

        /* ================= SEARCH ================= */

        .search-box {
            width: 300px;
            flex-shrink: 0;
        }

        .search-box input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--white);
            color: var(--text);
            font-size: 14px;
            outline: none;
            transition: 0.2s ease;
            box-sizing: border-box;
        }

        .search-box input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(185, 149, 90, 0.10);
        }

        .search-empty {
            display: none;
            grid-column: 1 / -1;
            padding: 35px 20px;
            text-align: center;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--white);
            color: var(--muted);
            font-size: 14px;
        }

        /* ================= PRODUCT GRID ================= */

        .product-grid {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0, 1fr));

            gap: 20px;
        }

        /* ================= PRODUCT CARD ================= */

        .product {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 14px;

            overflow: hidden;

            transition: 0.25s ease;
        }

        .product:hover {
            transform: translateY(-4px);

            box-shadow:
                0 12px 30px
                rgba(76, 48, 38, 0.09);

            border-color: #d8c8b8;
        }

        /* FOTO PRODUK */

        .product-image {
            width: 100%;
            height: 190px;

            overflow: hidden;

            background: var(--cream);
        }

        .product-image img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            display: block;

            transition: transform 0.35s ease;
        }

        .product:hover .product-image img {
            transform: scale(1.04);
        }

        /* ISI PRODUK */

        .product-content {
            padding: 20px;
        }

        .product h3 {
            font-family: Georgia, serif;

            color: var(--primary);

            font-size: 19px;

            margin: 0 0 7px;
        }

        .product-description {
            color: var(--muted);

            font-size: 13px;

            line-height: 1.5;

            margin: 0 0 18px;
        }

        .product-bottom {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 12px;
        }

        .price {
            color: var(--text);

            font-size: 16px;

            font-weight: bold;
        }

        .add-button {
            border: none;

            background: var(--primary);

            color: white;

            padding: 10px 15px;

            border-radius: 7px;

            cursor: pointer;

            font-size: 13px;

            font-weight: bold;

            transition: 0.2s;
        }

        .add-button:hover {
            background: var(--primary-dark);
        }

        /* ================= CART ================= */

        .cart-section {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 24px;

            position: sticky;

            top: 100px;

            box-shadow:
                0 8px 25px
                rgba(76, 48, 38, 0.06);
        }

        .cart-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            padding-bottom: 18px;

            border-bottom: 1px solid var(--border);

            margin-bottom: 5px;
        }

        .cart-header h2 {
            font-family: Georgia, serif;

            color: var(--primary);

            font-size: 22px;

            margin: 0;
        }

        .cart-badge {
            background: var(--cream);

            color: var(--primary);

            padding: 5px 10px;

            border-radius: 20px;

            font-size: 12px;

            font-weight: bold;
        }

        /* CART ITEM */

        .cart-item {
            padding: 18px 0;

            border-bottom: 1px solid var(--border);
        }

        .cart-item h3 {
            margin: 0 0 6px;

            color: var(--text);

            font-size: 15px;
        }

        .cart-price {
            color: var(--muted);

            font-size: 13px;
        }

        /* QUANTITY */

        .quantity-control {
            display: flex;

            align-items: center;

            gap: 9px;

            margin-top: 12px;
        }

        .quantity-control form {
            margin: 0;
        }

        .quantity-control button {
            width: 30px;
            height: 30px;

            border: 1px solid var(--border);

            background: var(--cream-light);

            color: var(--primary);

            border-radius: 6px;

            cursor: pointer;

            font-size: 17px;

            line-height: 1;
        }

        .quantity-control button:hover {
            background: var(--cream);
        }

        .quantity {
            min-width: 24px;

            text-align: center;

            font-size: 14px;
        }

        .subtotal {
            margin-top: 10px;

            font-size: 14px;

            font-weight: bold;

            color: var(--text);
        }

        /* CART EMPTY */

        .empty-cart {
            text-align: center;

            color: var(--muted);

            font-size: 14px;

            padding: 35px 0;
        }

        .empty-cart-icon {
            width: 45px;
            height: 45px;

            border-radius: 50%;

            margin: 0 auto 12px;

            background: var(--cream);

            color: var(--primary);

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 18px;
        }

        /* TOTAL */

        .cart-summary {
            padding-top: 18px;
        }

        .total {
            display: flex;

            justify-content: space-between;

            align-items: center;

            font-size: 17px;

            font-weight: bold;

            color: var(--primary);
        }

        .checkout-button {
            display: block;

            width: 100%;

            margin-top: 18px;

            padding: 13px 16px;

            text-align: center;

            background: var(--primary);

            color: white;

            border-radius: 7px;

            text-decoration: none;

            font-size: 14px;

            font-weight: bold;

            transition: 0.2s;
        }

        .checkout-button:hover {
            background: var(--primary-dark);
        }

        /* ================= FOOTER ================= */

        .footer {
            margin-top: 50px;

            padding: 25px 20px;

            text-align: center;

            border-top: 1px solid var(--border);

            color: var(--muted);

            font-size: 12px;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 900px) {

            .container {
                grid-template-columns: 1fr;
            }

            .cart-section {
                position: static;
            }

            .product-grid {
                grid-template-columns:
                    repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {

            .navbar {
                padding: 0 20px;
            }

            .brand-name {
                font-size: 17px;
            }

            .brand-subtitle {
                font-size: 8px;
            }

            .menu-header {
                padding: 35px 20px;
            }

            .menu-header h1 {
                font-size: 33px;
            }

            .container {
                margin: 30px auto;

                padding: 0 15px;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .section-title {
                display: block;
            }

            .search-box {
                width: 100%;
                margin-top: 18px;
            }

            .product-image {
                height: 210px;
            }

            .cart-section {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    <!-- ================= NAVBAR ================= -->

    <nav class="navbar">

        <a
            href="{{ route('home') }}"
            class="brand"
        >

            <div class="brand-icon">
                MB
            </div>

            <div class="brand-text">

                <div class="brand-name">
                    Modern Bakery
                </div>

                <div class="brand-subtitle">
                    Freshly Baked
                </div>

            </div>

        </a>


        <a
            href="{{ route('home') }}"
            class="nav-link"
        >
            Beranda
        </a>

    </nav>


    <!-- ================= HEADER ================= -->

    <header class="menu-header">

        <div class="menu-header-inner">

            <div class="eyebrow">
                Our Selection
            </div>

            <h1>
                Menu Modern Bakery
            </h1>

            <p>
                Pilih berbagai roti dan pastry favoritmu,
                tambahkan ke keranjang, lalu lanjutkan
                pemesanan dengan mudah.
            </p>

        </div>

    </header>


    <!-- ================= MAIN ================= -->

    <main class="container">


        <!-- ================= PRODUK ================= -->

        <section class="menu-section">

            <div class="section-title">

                <div>
                    <h2>
                        Pilihan Hari Ini
                    </h2>

                    <p>
                        Freshly baked untuk menemani harimu.
                    </p>
                </div>

                <div class="search-box">
                    <input type="search" id="productSearch" placeholder="Cari produk" autocomplete="off" aria-label="Cari produk">
                </div>

            </div>

            <div class="product-grid">

                @forelse ($products as $product)

                    <div class="product" data-product-name="{{ strtolower($product->nama_produk) }}">

                        <!-- FOTO SEMENTARA -->

                        <div class="product-image">

                            <img
                                src="https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=800&q=80"
                                alt="{{ $product->nama_produk }}"
                            >

                        </div>


                        <div class="product-content">

                            <h3>
                                {{ $product->nama_produk }}
                            </h3>

                            <p class="product-description">
                                Nikmati pilihan bakery berkualitas
                                dari Modern Bakery.
                            </p>


                            <div class="product-bottom">

                                <div class="price">
                                    Rp {{ number_format($product->harga, 0, ',', '.') }}
                                </div>


                                <form
                                    action="{{ route('cart.add', $product->id_produk) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="add-button"
                                    >
                                        + Tambah
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="product">

                        <div class="product-content">

                            <h3>
                                Belum ada produk
                            </h3>

                            <p class="product-description">
                                Produk belum tersedia saat ini.
                            </p>

                        </div>

                    </div>

                @endforelse

            </div>

            <div class="search-empty" id="searchEmpty">
                Produk yang kamu cari belum ditemukan.
            </div>

        </section>


        <!-- ================= KERANJANG ================= -->

        <aside class="cart-section">

            <div class="cart-header">

                <h2>
                    Keranjang
                </h2>


                @php

                    $cart = session()->get('cart', []);

                    $cartTotal = 0;

                    $cartQuantity = 0;

                @endphp


                @foreach ($cart as $item)

                    @php

                        $cartTotal +=
                            $item['harga'] * $item['jumlah'];

                        $cartQuantity +=
                            $item['jumlah'];

                    @endphp

                @endforeach


                <span class="cart-badge">
                    {{ $cartQuantity }} item
                </span>

            </div>


            @forelse ($cart as $item)

                @php

                    $subtotal =
                        $item['harga'] * $item['jumlah'];

                @endphp


                <div class="cart-item">

                    <h3>
                        {{ $item['nama_produk'] }}
                    </h3>

                    <div class="cart-price">
                        Rp {{ number_format($item['harga'], 0, ',', '.') }}
                    </div>


                    <div class="quantity-control">

                        <!-- KURANG -->

                        <form
                            action="{{ route('cart.update', $item['id_produk']) }}"
                            method="POST"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="jumlah"
                                value="{{ $item['jumlah'] - 1 }}"
                            >

                            <button type="submit">
                                −
                            </button>

                        </form>


                        <strong class="quantity">
                            {{ $item['jumlah'] }}
                        </strong>


                        <!-- TAMBAH -->

                        <form
                            action="{{ route('cart.update', $item['id_produk']) }}"
                            method="POST"
                        >

                            @csrf

                            <input
                                type="hidden"
                                name="jumlah"
                                value="{{ $item['jumlah'] + 1 }}"
                            >

                            <button type="submit">
                                +
                            </button>

                        </form>

                    </div>


                    <div class="subtotal">
                        Rp {{ number_format($subtotal, 0, ',', '.') }}
                    </div>

                </div>

            @empty

                <div class="empty-cart">

                    <div class="empty-cart-icon">
                        🛒
                    </div>

                    Keranjang masih kosong.

                </div>

            @endforelse


            @if (count($cart) > 0)

                <div class="cart-summary">

                    <div class="total">

                        <span>
                            Total
                        </span>

                        <span>
                            Rp {{ number_format($cartTotal, 0, ',', '.') }}
                        </span>

                    </div>


                    <a
                        href="{{ route('checkout') }}"
                        class="checkout-button"
                    >
                        Lanjut ke Checkout →
                    </a>

                </div>

            @endif

        </aside>

    </main>


    <!-- ================= FOOTER ================= -->

    <footer class="footer">

        © {{ date('Y') }} Modern Bakery.
        Freshly baked with care.

    </footer>

    <script>
        const productSearch = document.getElementById('productSearch');
        const products = document.querySelectorAll('.product-grid .product');
        const searchEmpty = document.getElementById('searchEmpty');

        productSearch.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            let visibleProducts = 0;

            products.forEach(function (product) {
                const productName = product.dataset.productName || '';
                if (productName.includes(keyword)) {
                    product.style.display = '';
                    visibleProducts++;
                } else {
                    product.style.display = 'none';
                }
            });

            searchEmpty.style.display = visibleProducts === 0 && keyword !== '' ? 'block' : 'none';
        });
    </script>

</body>
</html>