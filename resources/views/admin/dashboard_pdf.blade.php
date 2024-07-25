<!DOCTYPE html>
<html>
<head>
    <title>Dashboard PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid black; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Pendapatan</h2>
    <p>Rp. {{ number_format($pendapatan->penghasilan, 2, ',', '.') }}</p>

    <h2>Transaksi</h2>
    <p>{{ $transaksi->total_order }}</p>

    <h2>Pelanggan</h2>
    <p>{{ $pelanggan->total_user }}</p>

    <h2>10 Transaksi Terbaru</h2>
    <table>
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Pemesan</th>
                <th>Subtotal</th>
                <th>Status Pesanan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order_baru as $order)
                <tr>
                    <td>{{ $order->invoice }}</td>
                    <td>{{ $order->nama_pemesan }}</td>
                    <td>{{ $order->subtotal + $order->biaya_cod }}</td>
                    <td>{{ $order->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Pertanyaan Terbanyak Sebulan</h2>
    <table>
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questionsCount as $question)
                <tr>
                    <td>{{ $question->text_input }}</td>
                    <td>{{ $question->count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Data Persentase</h2>
    <table>
        <thead>
            <tr>
                <th>Pertanyaan</th>
                <th>Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($percentageData as $data)
                <tr>
                    <td>{{ $data->text_input }}</td>
                    <td>{{ number_format($data->percentage, 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
