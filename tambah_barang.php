<?php
include 'koneksi.php';
include 'header.php';

// Ambil data kategori
$kategori = $koneksi->query("SELECT * FROM kategori");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama_barang'];
    $kategori_id = $_POST['id_kategori'];
    $stok = $_POST['jumlah_stok'];
    $harga = $_POST['harga_barang'];
    $tanggal = $_POST['tanggal_masuk'];

    // Validasi sederhana
    if ($nama && $stok >= 0 && $harga >= 0) {
        $stmt = $koneksi->prepare("INSERT INTO barang (nama_barang, id_kategori, jumlah_stok, harga_barang, tanggal_masuk) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siids", $nama, $kategori_id, $stok, $harga, $tanggal);
        $stmt->execute();

        echo "<div class='alert alert-success'>Barang berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger'>Data tidak valid!</div>";
    }
}
?>

<h2>Tambah Barang</h2>
<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label>Nama Barang</label>
        <input type="text" name="nama_barang" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label>Kategori</label>
        <select name="id_kategori" class="form-select" required>
            <option value="">Pilih Kategori</option>
            <?php while ($row = $kategori->fetch_assoc()) {
                echo "<option value='{$row['id_kategori']}'>{$row['nama_kategori']}</option>";
            } ?>
        </select>
    </div>
    <div class="col-md-4">
        <label>Jumlah Stok</label>
        <input type="number" name="jumlah_stok" class="form-control" required min = "0">
    </div>
    <div class="col-md-4">
        <label>Harga Barang</label>
        <input type="number" name="harga_barang" class="form-control" step="0.01" required min = "0">>
    </div>
    <div class="col-md-4">
        <label>Tanggal Masuk</label>
        <input type="date" name="tanggal_masuk" class="form-control" required min = "0">>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Kembali</a>
    </div>
</form>

<?php include 'footer.php'; ?>