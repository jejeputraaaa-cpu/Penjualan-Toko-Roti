<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - Modern Bakery</title>

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
            max-width: 900px;
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
            max-width: 900px;

            margin: 40px auto;

            padding: 0 20px;
        }

        .payment-box {
            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 28px;

            box-shadow:
                0 8px 25px
                rgba(76, 48, 38, 0.05);
        }

        /* ================= DETAIL PESANAN ================= */

        .section-title {
            font-family: Georgia, serif;

            color: var(--primary);

            font-size: 22px;

            margin: 0 0 20px;
        }

        .order-info {
            background: var(--cream);

            border-radius: 10px;

            padding: 20px;

            border: 1px solid var(--border);
        }

        .info-row {
            display: flex;

            justify-content: space-between;

            gap: 20px;

            padding: 8px 0;

            font-size: 14px;
        }

        .label {
            color: var(--muted);
        }

        .value {
            color: var(--text);

            font-weight: bold;

            text-align: right;
        }

        .total {
            margin-top: 12px;

            padding-top: 15px;

            border-top: 1px solid var(--border);

            font-size: 18px;

            font-weight: bold;

            color: var(--primary);
        }

        /* ================= PAYMENT ================= */

        .payment-section {
            margin-top: 30px;
        }

        .payment-section h2 {
            font-family: Georgia, serif;

            color: var(--primary);

            font-size: 22px;

            margin: 0 0 8px;
        }

        .payment-description {
            color: var(--muted);

            font-size: 13px;

            margin: 0 0 20px;

            line-height: 1.6;
        }

        .payment-option {
            display: block;

            position: relative;

            border: 1px solid var(--border);

            border-radius: 10px;

            padding: 18px;

            margin-bottom: 12px;

            cursor: pointer;

            transition: 0.2s;

            background: var(--white);
        }

        .payment-option:hover {
            border-color: var(--primary);

            background: #fffdfb;
        }

        .payment-option input {
            position: absolute;

            opacity: 0;
        }

        .option-content {
            display: flex;

            align-items: flex-start;

            gap: 14px;
        }

        .radio-circle {
            width: 20px;
            height: 20px;

            border: 2px solid #c8beb4;

            border-radius: 50%;

            flex-shrink: 0;

            margin-top: 1px;

            position: relative;
        }

        .payment-option input:checked + .option-content .radio-circle {
            border-color: var(--primary);
        }

        .payment-option input:checked + .option-content .radio-circle::after {
            content: "";

            position: absolute;

            width: 10px;
            height: 10px;

            border-radius: 50%;

            background: var(--primary);

            top: 3px;
            left: 3px;
        }

        .payment-option input:checked + .option-content {
            color: var(--primary);
        }

        .option-text strong {
            display: block;

            color: var(--text);

            font-size: 15px;

            margin-bottom: 5px;
        }

        .option-text small {
            display: block;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.5;
        }

        /* ================= NOTE ================= */

        .payment-note {
            margin-top: 20px;

            padding: 15px;

            border-radius: 8px;

            background: var(--cream);

            color: var(--muted);

            font-size: 12px;

            line-height: 1.6;
        }

        /* ================= ERROR ================= */

        .error-box {
            margin-bottom: 20px;

            padding: 12px 15px;

            border-radius: 8px;

            background: #fdf0ef;

            border: 1px solid #e7c4c0;

            color: #9b3028;

            font-size: 13px;
        }

        /* ================= BUTTON ================= */

        .btn {
            width: 100%;

            margin-top: 22px;

            padding: 14px 18px;

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

            margin-top: 12px;

            padding: 12px 18px;

            text-align: center;

            border: 1px solid var(--border);

            border-radius: 7px;

            color: var(--primary);

            background: var(--cream-light);

            text-decoration: none;

            font-size: 14px;

            font-weight: 600;
        }

        .back:hover {
            background: var(--cream);
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

            .payment-box {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;

                gap: 4px;
            }

            .value {
                text-align: left;
            }

            .total {
                flex-direction: row;
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
                Payment
            </div>

            <h1>
                Pembayaran
            </h1>

            <p>
                Pilih metode pembayaran untuk menyelesaikan
                pesananmu di Modern Bakery.
            </p>

        </div>

    </header>


    <!-- ================= MAIN ================= -->

    <main class="container">

        <div class="payment-box">

            <!-- ================= DETAIL PESANAN ================= -->

            <h2 class="section-title">
                Detail Pesanan
            </h2>

            <div class="order-info">

                <div class="info-row">

                    <span class="label">
                        Nomor Pesanan
                    </span>

                    <span class="value">
                        {{ $order->nomor_pesanan }}
                    </span>

                </div>


                <div class="info-row">

                    <span class="label">
                        Email Pembeli
                    </span>

                    <span class="value">
                        {{ $order->email_pembeli }}
                    </span>

                </div>


                <div class="info-row total">

                    <span>
                        Total Pembayaran
                    </span>

                    <span>
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </span>

                </div>

            </div>


            <!-- ================= PILIH METODE ================= -->

            <section class="payment-section">

                <h2>
                    Pilih Metode Pembayaran
                </h2>

                <p class="payment-description">
                    Pilih salah satu metode pembayaran
                    yang tersedia.
                </p>


                @if ($errors->any())

                    <div class="error-box">

                        Silakan pilih metode pembayaran
                        terlebih dahulu.

                    </div>

                @endif


                <form
                    action="{{ route('payment.process', $order) }}"
                    method="POST"
                >

                    @csrf


                    <!-- QRIS -->

                    <label class="payment-option">

                        <input
                            type="radio"
                            name="metode_bayar"
                            value="QRIS"
                            required
                        >

                        <div class="option-content">

                            <div class="radio-circle"></div>

                            <div class="option-text">

                                <strong>
                                    QRIS
                                </strong>

                                <small>
                                    Bayar menggunakan QRIS
                                    Modern Bakery.
                                </small>

                            </div>

                        </div>

                    </label>


                    <!-- TUNAI -->

                    <label class="payment-option">

                        <input
                            type="radio"
                            name="metode_bayar"
                            value="Tunai"
                        >

                        <div class="option-content">

                            <div class="radio-circle"></div>

                            <div class="option-text">

                                <strong>
                                    Tunai
                                </strong>

                                <small>
                                    Bayar langsung kepada
                                    kasir Modern Bakery.
                                </small>

                            </div>

                        </div>

                    </label>


                    <div class="payment-note">

                        <strong>
                            Catatan:
                        </strong>

                        Setelah memilih metode pembayaran,
                        ikuti instruksi pembayaran yang
                        ditampilkan.

                    </div>


                    <button
                        type="submit"
                        class="btn"
                    >
                        Lanjutkan Pembayaran →
                    </button>

                </form>


                <a
                    href="{{ route('menu') }}"
                    class="back"
                >
                    ← Kembali ke Menu
                </a>

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