<?php
include "koneksi.php";

$hlm = (isset($_POST['hlm'])) ? $_POST['hlm'] : 1;
$limit = 5;
$limit_start = ($hlm - 1) * $limit;
$no = $limit_start + 1;

$sql = "SELECT * FROM user ORDER BY id DESC LIMIT $limit_start, $limit";
$hasil = $conn->query($sql);
?>

<table class="table table-hover">
<thead class="table-dark">
<tr>
    <th>No</th>
    <th>Username</th>
    <th>Foto</th>
    <th>Aksi</th>
</tr>
</thead>
<tbody>
<?php while($row = $hasil->fetch_assoc()){ ?>
<tr>
    <td><?php echo $no++; ?></td>
    <td><?php echo $row['username']; ?></td>
    <td>
        <?php if ($row['foto'] != '' && file_exists("img/".$row['foto'])) { ?>
            <img src="img/<?php echo $row['foto']; ?>" width="80">
        <?php } ?>
    </td>
    <td>
        <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#edit<?php echo $row['id']; ?>">Edit</a>
        <a href="#" class="badge bg-danger" data-bs-toggle="modal" data-bs-target="#hapus<?php echo $row['id']; ?>">Hapus</a>

        <!-- MODAL EDIT -->
        <div class="modal fade" id="edit<?php echo $row['id']; ?>" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content text-dark">
                    <form method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5>Edit User</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="foto_lama" value="<?php echo $row['foto']; ?>">

                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" value="<?php echo $row['username']; ?>" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Password Baru</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label>Ganti Foto</label>
                                <input type="file" name="foto" class="form-control">
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
        <div class="modal fade" id="hapus<?php echo $row['id']; ?>" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content text-dark">
                    <form method="post">
                        <div class="modal-header">
                            <h5>Hapus User</h5>
                            <button class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            Yakin hapus user <b><?php echo $row['username']; ?></b>?
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="hidden" name="foto" value="<?php echo $row['foto']; ?>">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <input type="submit" name="hapus" value="Hapus" class="btn btn-danger">
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
$sql1 = "SELECT * FROM user";
$hasil1 = $conn->query($sql1); 
$total_records = $hasil1->num_rows;
?>
<p>Total user : <?php echo $total_records; ?></p>
<nav class="mb-2">
    <ul class="pagination justify-content-end">
    <?php
        $jumlah_page = ceil($total_records / $limit);
        $jumlah_number = 1;
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
