<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - Modern Bakery</title>

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
        }

        .nav-link:hover {
            color: var(--primary);
        }

        /* ================= HEADER ================= */

        .page-header {
            background: var(--cream);

            padding: 38px 6%;

            border-bottom: 1px solid var(--border);
        }

        .page-header-inner {
            max-width: 1000px;
            margin: auto;
        }

        .eyebrow {
            color: var(--gold);

            font-size: 11px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;

            margin-bottom: 8px;
        }

        .page-header h1 {
            font-family: Georgia, serif;

            font-size: 38px;

            color: var(--primary);

            margin: 0 0 8px;
        }

        .page-header p {
            color: var(--muted);

            font-size: 14px;

            margin: 0;
        }

        /* ================= MAIN ================= */

        .container {
            max-width: 1000px;

            margin: 40px auto;

            padding: 0 20px;
        }

        .checkout-grid {
            display: grid;

            grid-template-columns:
                minmax(0, 1.3fr)
                minmax(300px, 0.7fr);

            gap: 25px;

            align-items: start;
        }

        .card {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 25px;

            box-shadow:
                0 8px 25px
                rgba(76, 48, 38, 0.05);
        }

        .card h2 {
            font-family: Georgia, serif;

            color: var(--primary);

            font-size: 22px;

            margin: 0 0 20px;
        }

        /* ================= ORDER ITEMS ================= */

        .item {
            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 20px;

            padding: 16px 0;

            border-bottom: 1px solid var(--border);
        }

        .item:first-of-type {
            padding-top: 0;
        }

        .item-name {
            color: var(--text);

            font-size: 15px;

            font-weight: bold;

            margin-bottom: 5px;
        }

        .item-quantity {
            color: var(--muted);

            font-size: 13px;
        }

        .item-price {
            color: var(--text);

            font-size: 14px;

            font-weight: bold;

            white-space: nowrap;
        }

        /* ================= TOTAL ================= */

        .total {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-top: 18px;

            padding-top: 18px;

            border-top: 2px solid var(--primary);

            color: var(--primary);

            font-size: 18px;

            font-weight: bold;
        }

        /* ================= CUSTOMER ================= */

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            margin-bottom: 8px;

            color: var(--text);

            font-size: 14px;

            font-weight: bold;
        }

        .required {
            color: var(--primary);
        }

        input {
            width: 100%;

            padding: 13px 14px;

            border: 1px solid var(--border);

            border-radius: 7px;

            background: #fff;

            color: var(--text);

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }

        input:focus {
            border-color: var(--primary);

            box-shadow:
                0 0 0 3px
                rgba(108, 41, 36, 0.08);
        }

        .helper-text {
            margin-top: 8px;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.5;
        }

        .error {
            margin-top: 8px;

            color: #b3261e;

            font-size: 13px;
        }

        /* ================= BUTTON ================= */

        .button-area {
            margin-top: 25px;

            display: flex;

            flex-direction: column;

            gap: 12px;
        }

        .btn {
            width: 100%;

            padding: 13px 18px;

            border: none;

            border-radius: 7px;

            background: var(--primary);

            color: white;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: 0.2s;
        }

        .btn:hover {
            background: var(--primary-dark);
        }

        .back {
            display: block;

            width: 100%;

            padding: 12px 18px;

            text-align: center;

            border: 1px solid var(--border);

            border-radius: 7px;

            color: var(--primary);

            background: var(--cream-light);

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;

            transition: 0.2s;
        }

        .back:hover {
            background: var(--cream);
        }

        /* ================= INFO ================= */

        .info-box {
            margin-top: 20px;

            padding: 15px;

            border-radius: 8px;

            background: var(--cream);

            color: var(--muted);

            font-size: 12px;

            line-height: 1.6;
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

        @media (max-width: 800px) {

            .checkout-grid {
                grid-template-columns: 1fr;
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

            .page-header {
                padding: 32px 20px;
            }

            .page-header h1 {
                font-size: 32px;
            }

            .container {
                margin: 25px auto;

                padding: 0 15px;
            }

            .card {
                padding: 20px;
            }

            .item {
                align-items: flex-start;
            }

            .item-price {
                font-size: 13px;
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
            href="{{ route('menu') }}"
            class="nav-link"
        >
            Menu
        </a>

    </nav>


    <!-- ================= HEADER ================= -->

    <header class="page-header">

        <div class="page-header-inner">

            <div class="eyebrow">
                Order Summary
            </div>

            <h1>
                Checkout
            </h1>

            <p>
                Periksa kembali pesananmu sebelum melanjutkan
                ke proses pembayaran.
            </p>

        </div>

    </header>


    <!-- ================= MAIN ================= -->

    <main class="container">

        <div class="checkout-grid">


            <!-- ================= RINGKASAN PESANAN ================= -->

            <section class="card">

                <h2>
                    Ringkasan Pesanan
                </h2>


                @foreach ($cart as $item)

                    <div class="item">

                        <div>

                            <div class="item-name">
                                {{ $item['nama_produk'] }}
                            </div>

                            <div class="item-quantity">
                                {{ $item['jumlah'] }} ×
                                Rp {{ number_format($item['harga'], 0, ',', '.') }}
                            </div>

                        </div>


                        <div class="item-price">

                            Rp
                            {{ number_format(
                                $item['harga'] * $item['jumlah'],
                                0,
                                ',',
                                '.'
                            ) }}

                        </div>

                    </div>

                @endforeach


                <div class="total">

                    <span>
                        Total
                    </span>

                    <span>
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>

                </div>

            </section>


            <!-- ================= DATA PEMBELI ================= -->

            <section class="card">

                <h2>
                    Data Pembeli
                </h2>


                <form
                    action="{{ route('checkout.process') }}"
                    method="POST"
                >

                    @csrf


                    <div class="form-group">

                        <label for="email">

                            Email Pembeli
                            <span class="required">*</span>

                        </label>


                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="contoh@email.com"
                            required
                        >


                        @error('email')

                            <div class="error">
                                {{ $message }}
                            </div>

                        @enderror


                        <div class="helper-text">

                            Email digunakan untuk mengirim
                            informasi dan bukti pesanan.

                        </div>

                    </div>


                    <div class="button-area">

                        <button
                            type="submit"
                            class="btn"
                        >
                            Lanjutkan Pembayaran →
                        </button>


                        <a
                            href="{{ route('menu') }}"
                            class="back"
                        >
                            ← Kembali ke Menu
                        </a>

                    </div>

                </form>


                <div class="info-box">

                    Pastikan jumlah produk dan total pesanan
                    sudah sesuai sebelum melanjutkan.

                </div>

            </section>

        </div>

    </main>


    <!-- ================= FOOTER ================= -->

    <footer class="footer">

        © {{ date('Y') }} Modern Bakery.
        Freshly baked with care.

    </footer>

</body>
</html>