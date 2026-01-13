<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th class="w-25">Judul</th>
            <th class="w-75">Isi</th>
            <th class="w-25">Gambar</th>
            <th class="w-25">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "koneksi.php";

        // Pengaturan Pagination
        $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
        $limit = 3;
        $limit_start = ($hlm - 1) * $limit;
        $no = $limit_start + 1;

        // Query Ambil Data
        $sql = "SELECT * FROM article ORDER BY tanggal DESC LIMIT $limit_start, $limit";
        $hasil = $conn->query($sql);

        while ($row = $hasil->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <strong><?= htmlspecialchars($row["judul"]) ?></strong>
                    <br><small class="text-muted">pada : <?= $row["tanggal"] ?></small>
                    <br><small class="text-muted">oleh : <?= htmlspecialchars($row["username"]) ?></small>
                </td>
                <td><?= nl2br(htmlspecialchars($row["isi"])) ?></td>
                <td>
                    <?php
                    if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])) {
                        echo '<img src="img/' . $row["gambar"] . '" width="100" class="img-thumbnail">';
                    } else {
                        echo '<span class="text-muted small">No Image</span>';
                    }
                    ?>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                        <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                    </div>

                    <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Edit Article</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="" enctype="multipart/form-data">
                                    <div class="modal-body text-start">
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Judul</label>
                                            <input type="text" class="form-control" name="judul" value="<?= htmlspecialchars($row["judul"]) ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Isi</label>
                                            <textarea class="form-control" name="isi" rows="5" required><?= htmlspecialchars($row["isi"]) ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ganti Gambar</label>
                                            <input type="file" class="form-control" name="gambar">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label d-block">Gambar Lama</label>
                                            <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])) { ?>
                                                <img src="img/<?= $row["gambar"] ?>" width="100" class="mb-2">
                                            <?php } ?>
                                            <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5">Konfirmasi Hapus</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="">
                                    <div class="modal-body text-start">
                                        <p>Yakin akan menghapus artikel "<strong><?= htmlspecialchars($row["judul"]) ?></strong>"?</p>
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" name="hapus" class="btn btn-danger">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php 
// Menghitung Total Data untuk Pagination
$sql_total = "SELECT * FROM article";
$res_total = $conn->query($sql_total); 
$total_records = $res_total->num_rows;
?>

<div class="d-flex justify-content-between align-items-center mt-3">
    <p>Total article : <?= $total_records; ?></p>
    <nav>
        <ul class="pagination mb-0">
        <?php
            $jumlah_page = ceil($total_records / $limit);
            $jumlah_number = 1; 
            $start_number = ($hlm > $jumlah_number)? $hlm - $jumlah_number : 1;
            $end_number = ($hlm < ($jumlah_page - $jumlah_number))? $hlm + $jumlah_number : $jumlah_page;

            // First & Prev
            if($hlm == 1){
                echo '<li class="page-item disabled"><a class="page-link">First</a></li>';
                echo '<li class="page-item disabled"><a class="page-link">&laquo;</a></li>';
            } else {
                echo '<li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>';
                echo '<li class="page-item halaman" id="'.($hlm - 1).'"><a class="page-link" href="#">&laquo;</a></li>';
            }

            // Numbering
            for($i = $start_number; $i <= $end_number; $i++){
                $link_active = ($hlm == $i)? ' active' : '';
                echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
            }

            // Next & Last
            if($hlm == $jumlah_page || $total_records == 0){
                echo '<li class="page-item disabled"><a class="page-link">&raquo;</a></li>';
                echo '<li class="page-item disabled"><a class="page-link">Last</a></li>';
            } else {
                echo '<li class="page-item halaman" id="'.($hlm + 1).'"><a class="page-link" href="#">&raquo;</a></li>';
                echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>';
            }
        ?>
        </ul>
    </nav>
</div>