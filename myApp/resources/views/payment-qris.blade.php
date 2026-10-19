<!DOCTYPE html>

<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <title>Bayar QRIS - Modern Bakery</title>



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

            max-width: 900px;

            margin: 40px auto;

            padding: 0 20px;

        }



        .payment-box {

            background: var(--white);

            border: 1px solid var(--border);

            border-radius: 14px;

            padding: 28px;

            box-shadow: 0 8px 25px rgba(76,48,38,.05);

        }



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



        .qris-section {

            margin-top: 30px;

            text-align: center;

        }



        .qris-section h2 {

            font-family: Georgia, serif;

            color: var(--primary);

            font-size: 22px;

            margin: 0 0 8px;

        }



        .qris-description {

            color: var(--muted);

            font-size: 13px;

            line-height: 1.6;

            margin: 0 auto 22px;

            max-width: 600px;

        }



        .qris-card {

            display: inline-block;

            background: white;

            border: 1px solid var(--border);

            border-radius: 12px;

            padding: 20px;

            box-shadow: 0 5px 18px rgba(76,48,38,.06);

        }



        .qris-image {

            width: 260px;

            height: 260px;

            object-fit: cover;

            display: block;

            border-radius: 6px;

        }



        .qris-label {

            margin-top: 14px;

            font-size: 13px;

            color: var(--muted);

            font-weight: bold;

        }



        .amount-box {

            margin: 25px auto 0;

            max-width: 450px;

            padding: 18px;

            background: var(--cream);

            border: 1px solid var(--border);

            border-radius: 10px;

        }



        .amount-label {

            font-size: 12px;

            color: var(--muted);

            margin-bottom: 5px;

        }



        .amount {

            color: var(--primary);

            font-size: 26px;

            font-weight: bold;

        }



        .instruction {

            margin-top: 25px;

            padding: 18px;

            background: var(--cream-light);

            border: 1px solid var(--border);

            border-radius: 10px;

            text-align: left;

        }



        .instruction h3 {

            margin: 0 0 12px;

            color: var(--primary);

            font-family: Georgia, serif;

            font-size: 17px;

        }



        .instruction ol {

            margin: 0;

            padding-left: 20px;

            color: var(--muted);

            font-size: 13px;

            line-height: 1.8;

        }



        .warning {

            margin-top: 18px;

            padding: 15px;

            background: #fff8ed;

            border: 1px solid #ead9bd;

            border-radius: 8px;

            color: #806b4c;

            font-size: 12px;

            line-height: 1.6;

            text-align: left;

        }



        .btn {

            display: block;

            width: 100%;

            margin-top: 25px;

            padding: 14px 18px;

            border: none;

            border-radius: 7px;

            background: var(--primary);

            color: white;

            font-size: 14px;

            font-weight: bold;

            cursor: pointer;

            transition: .2s;

        }



        .btn:hover {

            background: var(--primary-dark);

        }



        
        .whatsapp-btn {
            display: block;
            width: 100%;
            margin-top: 14px;
            padding: 14px 18px;
            border: 1px solid var(--primary);
            border-radius: 7px;
            background: var(--white);
            color: var(--primary);
            text-align: center;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: .2s;
        }

        .whatsapp-btn:hover {
            background: var(--cream);
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



            .qris-image {

                width: 220px;

                height: 220px;

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

                QRIS Payment

            </div>



            <h1>

                Pembayaran QRIS

            </h1>



            <p>

                Silakan lakukan pembayaran sesuai nominal yang tertera.

            </p>



        </div>



    </header>





    <main class="container">



        <div class="payment-box">



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





            <section class="qris-section">



                <h2>

                    Scan QRIS

                </h2>



                <p class="qris-description">

                    Scan QRIS di bawah menggunakan aplikasi pembayaran

                    yang mendukung QRIS.

                </p>





                <div class="qris-card">



                    <img

                        src="https\://placehold.co/260x260?text=QRIS+MODERN+BAKERY"

                        alt="QRIS Modern Bakery"

                        class="qris-image"

                    >



                    <div class="qris-label">

                        QRIS Modern Bakery

                    </div>



                </div>





                <div class="amount-box">



                    <div class="amount-label">

                        Bayar Tepat Sebesar

                    </div>



                    <div class="amount">

                        Rp {{ number_format($order->total, 0, ',', '.') }}

                    </div>



                </div>





                <div class="instruction">



                    <h3>

                        Cara Pembayaran

                    </h3>



                    <ol>



                        <li>

                            Buka aplikasi pembayaran yang mendukung QRIS.

                        </li>



                        <li>

                            Scan QRIS Modern Bakery di atas.

                        </li>



                        <li>

                            Pastikan nominal sesuai dengan total pembayaran.

                        </li>



                        <li>

                            Selesaikan pembayaran.

                        </li>



                        <li>

                            Simpan bukti pembayaran untuk ditunjukkan kepada kasir.

                        </li>



                    </ol>



                </div>





                <div class="warning">



                    <strong>Perhatian:</strong>

                    Pastikan nominal pembayaran sesuai dengan total pesanan.

                    Setelah melakukan pembayaran, tunjukkan bukti pembayaran

                    kepada kasir Modern Bakery untuk proses konfirmasi.



                </div>





                <!-- KONFIRMASI VIA WHATSAPP -->
                @php
                    $whatsappNumber = '6282126531440';
                    $whatsappMessage = "Halo Admin Modern Bakery, saya ingin mengonfirmasi pembayaran.\n\nNomor Pesanan: {$order->nomor_pesanan}\nTotal Pembayaran: Rp " . number_format($order->total, 0, ',', '.') . "\nMetode Pembayaran: QRIS\n\nSaya sudah melakukan pembayaran dan akan mengirimkan bukti pembayaran melalui WhatsApp.";
                    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($whatsappMessage);
                @endphp

                <a href="{{ $whatsappUrl }}" class="whatsapp-btn" target="_blank" rel="noopener noreferrer">
                    Konfirmasi Pembayaran via WhatsApp
                </a>

                <!-- FORM KONFIRMASI PEMBAYARAN -->



                <form

                    action="{{ route('payment.submitted', $order) }}"

                    method="POST"

                >



                    @csrf



                    <button type="submit" class="btn">

                        Saya Sudah Bayar

                    </button>



                </form>





                <a href="{{ route('payment', $order) }}" class="back">

                    ← Kembali ke Metode Pembayaran

                </a>



            </section>



        </div>



    </main>





    <footer class="footer">



        © {{ date('Y') }} Modern Bakery.

        Freshly baked with care.



    </footer>



</body>

</html>