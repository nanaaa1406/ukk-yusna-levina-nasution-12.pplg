<?php 
include 'koneksi.php'; 
include 'header.php'; 

// --- PAGINATION SETUP ---
$batas = 5;
$halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

// --- FILTER SETUP ---
$where = '';
if (isset($_GET['kategori']) && $_GET['kategori'] != '') {
    $id_kategori = $_GET['kategori'];
    $where = "WHERE barang.id_kategori = '$id_kategori'";
}

// --- COUNT DATA ---
$count_query = "SELECT COUNT(*) AS total FROM barang $where";
$result = mysqli_query($koneksi, $count_query);
$data_total = mysqli_fetch_assoc($result)['total'];
$total_halaman = ceil($data_total / $batas);

// --- GET DATA WITH LIMIT ---
$sql = "SELECT barang.*, kategori.nama_kategori 
        FROM barang 
        JOIN kategori ON barang.id_kategori = kategori.id_kategori 
        $where 
        LIMIT $halaman_awal, $batas";
$result_data = mysqli_query($koneksi, $sql);
?>

<h2>Daftar Barang</h2>

<!-- FILTER FORM -->
<form method="GET" class="mb-3">
    <div class="form-row d-flex align-items-end">
        <div class="form-group mr-2">
            <label for="kategori">Filter Kategori</label>
            <select name="kategori" id="kategori" class="form-control">
                <option value="">Semua Kategori</option>
                <?php
                $kategori = mysqli_query($koneksi, "SELECT * FROM kategori");
                while ($k = mysqli_fetch_assoc($kategori)) {
                    $selected = (isset($_GET['kategori']) && $_GET['kategori'] == $k['id_kategori']) ? 'selected' : '';
                    echo "<option value='{$k['id_kategori']}' $selected>{$k['nama_kategori']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group mr-2">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
        <div class="form-group">
            <a href="export_barang.php?<?= http_build_query($_GET) ?>" class="btn btn-success">Export Excel</a>
        </div>
    </div>
</form>

<!-- TABEL BARANG -->
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Tanggal Masuk</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($result_data)): ?>
            <tr>
                <td><?= $row['id_barang'] ?></td>
                <td><?= $row['nama_barang'] ?></td>
                <td><?= $row['nama_kategori'] ?></td>
                <td><?= $row['jumlah_stok'] ?></td>
                <td><?= $row['harga_barang'] ?></td>
                <td><?= $row['tanggal_masuk'] ?></td>
                <td>
                    <a href="edit_barang.php?id=<?= $row['id_barang'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="hapus_barang.php?id=<?= $row['id_barang'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- PAGINATION -->
<nav>
    <ul class="pagination">
        <?php if ($halaman > 1): ?>
            <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['halaman' => $halaman - 1])) ?>">«</a></li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
            <li class="page-item <?= ($i == $halaman) ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['halaman' => $i])) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>

        <?php if ($halaman < $total_halaman): ?>
            <li class="page-item"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['halaman' => $halaman + 1])) ?>">»</a></li>
        <?php endif; ?>
    </ul>
</nav>

<?php include 'footer.php'; ?>
