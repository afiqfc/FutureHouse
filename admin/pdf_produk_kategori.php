<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once('koneksi.php');

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// Ambil ID kategori dari parameter URL dengan validasi
$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : null;

if (!$id_kategori) {
    die("ID Kategori tidak ditemukan.");
}

// Amankan input dari user
$id_kategori = mysqli_real_escape_string($koneksi, $id_kategori);

// Query berdasarkan kategori (pastikan tanda kutip karena id_kategori berupa string seperti 'k001')
$data = query("SELECT tb_produk.id_produk, tb_produk.nm_produk, tb_produk.harga, tb_produk.stok,
                    tb_produk.desk, tb_produk.gambar, tb_kategori.nm_kategori
             FROM tb_produk
             JOIN tb_kategori ON tb_produk.id_kategori = tb_kategori.id_kategori
             WHERE tb_produk.id_kategori = '$id_kategori'");

// Buat instance MPDF
$mpdf = new \Mpdf\Mpdf();
$html = '<html>
<head>
    <title>Laporan Data Produk Per Kategori</title>
    <link rel="shortcut icon" href="../../../assets/images/logos/logo-makmur.ico" type="image/x-icon">
    <style>
        h1 {
            color: #262626;
        }
        table {
            max-width: 960px;
            margin: 10px auto;
            border-collapse: collapse;
        }
        thead th {
            font-weight: 400;
            background: #8a97a0;
            color: #FFF;
        }
        tr {
            background: #f4f7f8;
            border-bottom: 1px solid #FFF;
            margin-bottom: 5px;
        }
        tr:nth-child(even) {
            background: #e8eeef;
        }
        th, td {
            text-align: center;
            padding: 15px 13px;
            font-weight: 300;
            border: 1px solid #ccc;
        }
        img {
            width: 100px;
            height: 50px;
        }
    </style>
</head>
<body>
    <h1 align="center">FutureHouse</h1>
    <hr>
    <h1 align="center">LAPORAN PRODUK BERDASARKAN KATEGORI</h1>

    <table align="center" cellspacing="0">
        <thead>
            <tr>
                <th>ID Produk</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>'; // Penutup thead dan pembuka tbody akan digabung di loop

foreach ($data as $row) {
    $formatted_harga = "Rp " . number_format($row["harga"], 0, ',', '.'); // Format harga

    $html .= '<tbody>
            <tr align="center">
                <td>' . $row["id_produk"] . '</td>
                <td><img src="produk_img/' . $row["gambar"] . '" alt="Gambar"></td>
                <td>' . $row["nm_produk"] . '</td>
                <td>' . $row["nm_kategori"] . '</td>
                <td>' . $row["desk"] . '</td>
                <td>' . $formatted_harga . '</td>
                <td>' . $row["stok"] . '</td>
            </tr>';
}

$html .= '</tbody>
    </table>
</body>
</html>';

// Tampilkan PDF
$mpdf->WriteHTML($html);
$mpdf->Output();