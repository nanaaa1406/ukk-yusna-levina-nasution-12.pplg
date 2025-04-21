<?php
require_once __DIR__ . '/vendor/autoload.php';

$conn = new mysqli("localhost", "root", "", "nama_database");
$data = $conn->query("SELECT * FROM barang");

$html = '<h3>Data Inventaris Barang</h3>';
$html .= '<table border="1" cellpadding="10" cellspacing="0" width="100%">
            <tr>
              <th>Nama</th>
              <th>Jumlah</th>
              <th>Lokasi</th>
              <th>Kategori</th>
            </tr>';

while ($row = $data->fetch_assoc()) {
  $html .= '<tr>
              <td>' . $row['nama'] . '</td>
              <td>' . $row['jumlah'] . '</td>
              <td>' . $row['lokasi'] . '</td>
              <td>' . $row['kategori'] . '</td>
            </tr>';
}
$html .= '</table>';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($html);
$mpdf->Output('data_barang.pdf', 'I');
?>
