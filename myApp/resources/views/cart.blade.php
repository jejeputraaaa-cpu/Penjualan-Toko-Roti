<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - Modern Bakery</title>
</head>
<body>

    <h1>Keranjang Belanja</h1>

    @forelse ($cart as $item)
        <div>
            <h2>{{ $item['nama_produk'] }}</h2>

            <p>
                Harga:
                Rp {{ number_format($item['harga'], 0, ',', '.') }}
            </p>

            <p>
                Jumlah: {{ $item['jumlah'] }}
            </p>

            <p>
                Subtotal:
                Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}
            </p>
        </div>

        <hr>
    @empty
        <p>Keranjang masih kosong.</p>
    @endforelse

    <h2>
        Total:
        Rp {{ number_format($total, 0, ',', '.') }}
    </h2>

    <a href="{{ route('menu') }}">
        Kembali ke Menu
    </a>

</body>
</html>