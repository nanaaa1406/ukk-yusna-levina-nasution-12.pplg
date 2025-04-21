<?php
include 'koneksi.php';
include 'header.php';

// Tambah kategori
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_kategori'];
    $koneksi->query("INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
}

// Hapus kategori
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];

    // Cek apakah kategori digunakan di tabel barang
    $cek = $koneksi->query("SELECT * FROM barang WHERE id_kategori = $id");
    if ($cek->num_rows > 0) {
        echo "<script>alert('Kategori tidak bisa dihapus karena masih digunakan oleh barang!');</script>";
    } else {
        $koneksi->query("DELETE FROM kategori WHERE id_kategori = $id");
        echo "<script>alert('Kategori berhasil dihapus!');</script>";
    }
}

$kategori = $koneksi->query("SELECT * FROM kategori");
?>

<h2>Manajemen Kategori</h2>

<form method="POST" class="row g-3 mb-4">
    <div class="col-md-8">
        <input type="text" name="nama_kategori" class="form-control" placeholder="Nama Kategori" required>
    </div>
    <div class="col-md-4">
        <button type="submit" name="tambah" class="btn btn-primary">Tambah Kategori</button>
    </div>
</form>

<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $kategori->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id_kategori'] ?></td>
            <td><?= $row['nama_kategori'] ?></td>
            <td>
                <a href="?hapus=<?= $row['id_kategori'] ?>" onclick="return confirm('Hapus kategori ini?')" class="btn btn-danger btn-sm">Hapus</a>
            </td>
        </tr>
    <?php } ?>
</table>

<?php include 'footer.php'; ?>
