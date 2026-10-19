<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pesanan Dikirim - Modern Bakery</title>

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
            --success-bg: #f3f8f1;
            --success-border: #cbdcc4;
            --success-text: #4e7046;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: var(--cream-light);
            color: var(--text);
        }

        .navbar {
            height: 76px;
            background: rgba(255,255,255,.97);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 6%;
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
            letter-spacing: .5px;
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

        .container {
            max-width: 800px;
            margin: 45px auto;
            padding: 0 20px;
        }

        .waiting-box {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 35px;
            box-shadow: 0 8px 25px rgba(76,48,38,.05);
            text-align: center;
        }

        .success-icon {
            width: 72px;
            height: 72px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: var(--success-bg);
            border: 2px solid var(--success-border);
            color: var(--success-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            font-weight: bold;
        }

        .waiting-box h2 {
            margin: 0 0 10px;
            font-family: Georgia, serif;
            color: var(--primary);
            font-size: 28px;
        }

        .description {
            max-width: 600px;
            margin: 0 auto;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .status-box {
            margin: 28px auto 0;
            padding: 18px;
            max-width: 600px;
            background: var(--cream);
            border: 1px solid var(--border);
            border-radius: 10px;
        }

        .status-label {
            color: var(--muted);
            font-size: 12px;
            margin-bottom: 6px;
        }

        .status {
            color: var(--primary);
            font-size: 18px;
            font-weight: bold;
        }

        .order-info {
            margin-top: 25px;
            padding: 20px;
            background: var(--cream-light);
            border: 1px solid var(--border);
            border-radius: 10px;
            text-align: left;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            padding: 9px 0;
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
            margin-top: 10px;
            padding-top: 15px;
            border-top: 1px solid var(--border);
            color: var(--primary);
            font-size: 17px;
            font-weight: bold;
        }

        .info-note {
            margin-top: 22px;
            padding: 15px;
            background: #fff8ed;
            border: 1px solid #ead9bd;
            border-radius: 8px;
            color: #806b4c;
            font-size: 12px;
            line-height: 1.6;
            text-align: left;
        }

        .button-area {
            margin-top: 25px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 13px 18px;
            border-radius: 7px;
            background: var(--primary);
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            transition: .2s;
        }

        .btn:hover {
            background: var(--primary-dark);
        }

        .footer {
            margin-top: 50px;
            padding: 25px 20px;
            text-align: center;
            border-top: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
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

            .waiting-box {
                padding: 25px 20px;
            }

            .info-row {
                flex-direction: column;
                gap: 4px;
            }

            .value {
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <a href="{{ route('home') }}" class="brand">

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

        <a href="{{ route('menu') }}" class="nav-link">
            Menu
        </a>

    </nav>


    <header class="page-header">

        <div class="page-header-inner">

            <div class="eyebrow">
                Order Submitted
            </div>

            <h1>
                Pesanan Berhasil Dikirim
            </h1>

            <p>
                Terima kasih. Pesananmu sedang menunggu konfirmasi dari kasir.
            </p>

        </div>

    </header>


    <main class="container">

        <div class="waiting-box">

            <div class="success-icon">
                ✓
            </div>


            <h2>
                Pembayaran Berhasil Dikirim
            </h2>

            <p class="description">
                Informasi pembayaranmu sudah diterima oleh sistem.
                Silakan tunggu kasir Modern Bakery melakukan verifikasi
                pembayaran.
            </p>


            <div class="status-box">

                <div class="status-label">
                    Status Pesanan
                </div>

                <div class="status">
                    {{ $order->status }}
                </div>

            </div>


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


                <div class="info-row">

                    <span class="label">
                        Metode Pembayaran
                    </span>

                    <span class="value">
                        {{ $order->metode_bayar }}
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


            <div class="info-note">

                <strong>Selanjutnya:</strong>
                Tunjukkan bukti pembayaran kepada kasir jika diperlukan.
                Kasir akan melakukan pengecekan dan mengonfirmasi pesananmu.

            </div>


            <div class="button-area">

                <a href="{{ route('home') }}" class="btn">
                    Kembali ke Beranda
                </a>

            </div>

        </div>

    </main>


    <footer class="footer">

        © {{ date('Y') }} Modern Bakery.
        Freshly baked with care.

    </footer>

</body>
</html>