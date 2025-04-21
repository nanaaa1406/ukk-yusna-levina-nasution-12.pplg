<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_barang.xls");

// Koneksi database
$conn = new mysqli("localhost", "root", "", "nama_database");

$sql = "SELECT * FROM barang"; // ganti nama tabel sesuai kebutuhan
$result = $conn->query($sql);

echo "<table border='1'>";
echo "<tr><th>Nama</th><th>Jumlah</th><th>Lokasi</th><th>Kategori</th></tr>";
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['nama']}</td>
            <td>{$row['jumlah']}</td>
            <td>{$row['lokasi']}</td>
            <td>{$row['kategori']}</td>
          </tr>";
}
echo "</table>";

$conn->close();
?>
