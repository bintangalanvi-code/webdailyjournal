<table class="table table-hover">
    <thead class="table-dark">
        <tr>
            <th>No</th>
            <th class="w-50">Judul</th>
            <th class="w-25">Gambar</th>
            <th class="w-25">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include "koneksi.php";

        $hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
        $limit = 3;
        $limit_start = ($hlm - 1) * $limit;
        $no = $limit_start + 1;

        $sql = "SELECT * FROM gallery ORDER BY tanggal DESC LIMIT $limit_start, $limit";
        $hasil = $conn->query($sql);

        while ($row = $hasil->fetch_assoc()) {
        ?>
            <tr>
                <td><?= $no++ ?></td>
                <td>
                    <strong><?= $row["judul"] ?></strong>
                    <br>pada : <?= $row["tanggal"] ?>
                    <br>oleh : <?= $row["username"] ?>
                </td>
                <td>
                    <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])) { ?>
                        <img src="img/<?= $row["gambar"] ?>" width="100">
                    <?php } ?>
                </td>
                <td>
                    <a href="#" class="badge rounded-pill text-bg-success"
                       data-bs-toggle="modal"
                       data-bs-target="#modalEdit<?= $row["id"] ?>">
                        <i class="bi bi-pencil"></i>
                    </a>

                    <a href="#" class="badge rounded-pill text-bg-danger"
                       data-bs-toggle="modal"
                       data-bs-target="#modalHapus<?= $row["id"] ?>">
                        <i class="bi bi-x-circle"></i>
                    </a>

                    <!-- MODAL EDIT -->
                    <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Gallery</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="post" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">

                                        <div class="mb-3">
                                            <label>Judul</label>
                                            <input type="text" name="judul" class="form-control"
                                                   value="<?= $row["judul"] ?>" required>
                                        </div>

                                        <div class="mb-3">
                                            <label>Ganti Gambar</label>
                                            <input type="file" name="gambar" class="form-control">
                                        </div>

                                        <div class="mb-3">
                                            <label>Gambar Lama</label><br>
                                            <?php if ($row["gambar"] != '' && file_exists('img/' . $row["gambar"])) { ?>
                                                <img src="img/<?= $row["gambar"] ?>" width="100">
                                            <?php } ?>
                                            <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <input type="submit" name="simpan" value="Simpan" class="btn btn-primary">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- MODAL HAPUS -->
                    <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static">
                        <div class="modal-dialog">
                            <div class="modal-content text-dark">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus Gallery</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="post">
                                    <div class="modal-body">
                                        Yakin hapus gallery <strong><?= $row["judul"] ?></strong>?
                                        <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                        <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <input type="submit" name="hapus" value="Hapus" class="btn btn-primary">
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
$sql1 = "SELECT * FROM gallery";
$hasil1 = $conn->query($sql1); 
$total_records = $hasil1->num_rows;
?>
<p>Total gallery : <?php echo $total_records; ?></p>
<nav class="mb-2">
    <ul class="pagination justify-content-end">
    <?php
        $jumlah_page = ceil($total_records / $limit);
        $jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
        $start_number = ($hlm > $jumlah_number)? $hlm - $jumlah_number : 1;
        $end_number = ($hlm < ($jumlah_page - $jumlah_number))? $hlm + $jumlah_number : $jumlah_page;

        if($hlm == 1){
            echo '<li class="page-item disabled"><a class="page-link" href="#">First</a></li>';
            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
        } else {
            $link_prev = ($hlm > 1)? $hlm - 1 : 1;
            echo '<li class="page-item halaman" id="1"><a class="page-link" href="#">First</a></li>';
            echo '<li class="page-item halaman" id="'.$link_prev.'"><a class="page-link" href="#"><span aria-hidden="true">&laquo;</span></a></li>';
        }

        for($i = $start_number; $i <= $end_number; $i++){
            $link_active = ($hlm == $i)? ' active' : '';
            echo '<li class="page-item halaman '.$link_active.'" id="'.$i.'"><a class="page-link" href="#">'.$i.'</a></li>';
        }

        if($hlm == $jumlah_page){
            echo '<li class="page-item disabled"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
            echo '<li class="page-item disabled"><a class="page-link" href="#">Last</a></li>';
        } else {
        $link_next = ($hlm < $jumlah_page)? $hlm + 1 : $jumlah_page;
            echo '<li class="page-item halaman" id="'.$link_next.'"><a class="page-link" href="#"><span aria-hidden="true">&raquo;</span></a></li>';
            echo '<li class="page-item halaman" id="'.$jumlah_page.'"><a class="page-link" href="#">Last</a></li>';
        }
    ?>
    </ul>
</nav>
