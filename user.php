<?php
include "koneksi.php";
include "upload_foto.php";
?>

<div class="container">
    <button type="button" class="btn btn-secondary mb-2" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah User
    </button>

    <div class="table-responsive" id="user_data"></div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content text-dark">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Foto</label>
                        <input type="file" name="foto" class="form-control" required>
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

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function(){
    load_data();

    function load_data(hlm){
        $.ajax({
            url: "user_data.php",
            method: "POST",
            data: { hlm: hlm },
            success: function(data){
                $('#user_data').html(data);
            }
        });
    }

    $(document).on('click','.halaman',function(){
        load_data($(this).attr("id"));
    });
});
</script>

<?php
// ================= SIMPAN / EDIT =================
if (isset($_POST['simpan'])) {

    $username = $_POST['username'];
    $password = md5($_POST['password']); // SAMAIN KAYA LOGIN KAMU
    $foto = '';

    if ($_FILES['foto']['name'] != '') {
        $upload = upload_foto($_FILES['foto']);
        if ($upload['status']) {
            $foto = $upload['message'];
        } else {
            echo "<script>alert('".$upload['message']."');</script>";
            exit;
        }
    }

    // EDIT
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $foto_lama = $_POST['foto_lama'];

        if ($foto == '') {
            $foto = $foto_lama;
        } else if ($foto_lama != '' && file_exists("img/".$foto_lama)) {
            unlink("img/".$foto_lama);
        }

        $stmt = $conn->prepare("UPDATE user SET username=?, password=?, foto=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $password, $foto, $id);
        $stmt->execute();
        $stmt->close();

    } 
    // TAMBAH
    else {
        $stmt = $conn->prepare("INSERT INTO user (username,password,foto) VALUES (?,?,?)");
        $stmt->bind_param("sss", $username, $password, $foto);
        $stmt->execute();
        $stmt->close();
    }

    echo "<script>
        alert('Data user berhasil disimpan');
        document.location='admin.php?page=user';
    </script>";
}

// ================= HAPUS =================
if (isset($_POST['hapus'])) {
    $id = $_POST['id'];
    $foto = $_POST['foto'];

    if ($foto != '' && file_exists("img/".$foto)) {
        unlink("img/".$foto);
    }

    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
    $stmt->bind_param("i",$id);
    $stmt->execute();
    $stmt->close();

    echo "<script>
        alert('User berhasil dihapus');
        document.location='admin.php?page=user';
    </script>";
}

$conn->close();
?>
