<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Gallery
    </button>

    <div class="row">
        <div class="table-responsive" id="gallery_data"></div>
    </div>

    <!-- MODAL TAMBAH -->
    <div class="modal fade" id="modalTambah" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form method="post" action="" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Judul</label>
                            <input type="text" name="judul" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Gambar</label>
                            <input type="file" name="gambar" class="form-control" required>
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
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function(){
    load_data();

    function load_data(hlm){
        $.ajax({
            url: "gallery_data.php",
            method: "POST",
            data: { hlm: hlm },
            success: function(data){
                $('#gallery_data').html(data);
            }
        });
    }

    $(document).on('click','.halaman',function(){
        var hlm = $(this).attr("id");
        load_data(hlm);
    });
});
</script>
<?php
include "koneksi.php";
include "upload_foto.php";
if (isset($_POST['simpan'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $tanggal = date("Y-m-d H:i:s");
    $username = $_SESSION['username'];

    if (!isset($_POST['id'])) {

        if ($_FILES['gambar']['name'] != '') {
            $upload = upload_foto($_FILES['gambar']);

            if ($upload['status']) {
                $gambar = $upload['message'];
            } else {
                echo "<script>alert('".$upload['message']."');</script>";
                exit;
            }
        }

        $stmt = $conn->prepare(
            "INSERT INTO gallery (judul, gambar, tanggal, username)
             VALUES (?,?,?,?)"
        );
        $stmt->bind_param("ssss", $judul, $gambar, $tanggal, $username);
        $stmt->execute();
        $stmt->close();

        echo "<script>
            alert('Data berhasil ditambahkan');
            document.location='admin.php?page=gallery';
        </script>";
    }

    // DEFAULT: pakai gambar lama
    $gambar = $_POST['gambar_lama'];

    // JIKA UPLOAD GAMBAR BARU
    if ($_FILES['gambar']['name'] != '') {
        $upload = upload_foto($_FILES['gambar']);

        if ($upload['status']) {
            // 🔥 HAPUS GAMBAR LAMA
            if ($gambar != '' && file_exists("img/" . $gambar)) {
                unlink("img/" . $gambar);
            }

            // SIMPAN GAMBAR BARU
            $gambar = $upload['message'];
        } else {
            echo "<script>alert('".$upload['message']."');</script>";
            exit;
        }
    }

    $stmt = $conn->prepare(
        "UPDATE gallery 
         SET judul=?, gambar=?, tanggal=?, username=? 
         WHERE id=?"
    );
    $stmt->bind_param("ssssi", $judul, $gambar, $tanggal, $username, $id);
    $stmt->execute();
    $stmt->close();

    echo "<script>
        alert('Data berhasil diupdate');
        document.location='admin.php?page=gallery';
    </script>";
}


// HAPUS
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $gambar = $_POST['gambar'];

    if ($gambar != '' && file_exists("img/".$gambar)) {
        unlink("img/".$gambar);
    }

    $stmt = $conn->prepare("DELETE FROM gallery WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    echo "<script>alert('Data berhasil dihapus');document.location='admin.php?page=gallery';</script>";
}

$conn->close();
?>
