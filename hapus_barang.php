<?php
include 'koneksi.php';

// Tampilkan semua error biar gampang debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Cek apakah parameter ID dikirim via URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // konversi ke integer untuk keamanan

    // GANTI nama tabel di sini
    $query = mysqli_query($koneksi, "DELETE FROM barang WHERE id_barang = $id");

    if ($query) {
        echo "<script>
            alert('Data berhasil dihapus!');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
            window.location.href = 'index.php';
        </script>";
    }
} else {
    echo "<script>
        alert('ID tidak ditemukan!');
        window.location.href = 'index.php';
    </script>";
}
?>
