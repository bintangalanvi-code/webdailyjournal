<?php
// login.php

// 1. MEMULAI SESI (Pastikan di baris paling atas tanpa spasi di atasnya)
session_start();
// 2. MENYERTKAN KONEKSI
include "koneksi.php";

// Inisialisasi variabel untuk pesan error/alert
$login_message = "";

// 3. CHECK APAKAH USER SUDAH LOGIN
if (isset($_SESSION['username'])) { 
  header("location:admin.php"); 
  exit(); // PENTING: Menghentikan skrip
}

// 4. PENANGANAN REQUEST POST (PROSES LOGIN)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['user'];
  $password = md5($_POST['pass']); // Menggunakan MD5 untuk mencocokkan hash database
    
  // Prepared statement
  $stmt = $conn->prepare("SELECT username FROM user WHERE username=? AND password=?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $hasil = $stmt->get_result();
  $row = $hasil->fetch_array(MYSQLI_ASSOC);

  if (!empty($row)) {
    // LOGIN BERHASIL: Buat Sesi dan Redirect
    $_SESSION['username'] = $row['username'];
    header("location:admin.php");
    exit(); // PENTING: Menghentikan skrip
  } else {
    // LOGIN GAGAL: Simpan pesan error
    $login_message = "Username atau Password yang Anda masukkan salah.";
  }

  $stmt->close();
  $conn->close();
}
// Setelah ini, skrip akan melanjutkan menampilkan HTML
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login | My Daily Journal</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous" />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" />
  <link rel="icon" href="img/logo.png" />
</head>

<body class="bg-danger-subtle">
  <div class="container mt-5 pt-5">
    <div class="row">
      <div class="col-12 col-sm-8 col-md-6 m-auto">
        <div class="card border-0 shadow rounded-5">
          <div class="card-body">
            <div class="text-center mb-3">
              <i class="bi bi-person-circle h1 display-4"></i>
              <p>My Daily Journal</p>
              <hr />
            </div>
            
            <form action="" method="post">
              <?php if ($login_message) : ?>
                <div class="alert alert-warning text-center rounded-4 mb-3" role="alert">
                  <strong>Login Gagal!</strong> <?php echo $login_message; ?>
                </div>
              <?php endif; ?>
              
              <input
                type="text"
                name="user"
                class="form-control my-4 py-2 rounded-4"
                placeholder="Username" />
              <input
                type="password"
                name="pass"
                class="form-control my-4 py-2 rounded-4"
                placeholder="Password" />
              <div class="text-center my-3 d-grid">
                <button class="btn btn-danger rounded-4">Login</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</body>

</html>