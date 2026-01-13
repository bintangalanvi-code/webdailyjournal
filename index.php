<?php
include "koneksi.php"; 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My DAILY JOURNAL</title>
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .schedule-card { border: 1px solid #dee2e6; border-radius: 8px; overflow: hidden; }
        .schedule-header { padding: 10px; font-weight: bold; text-align: center; }
    </style>
  </head>
  <body>
    
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">My DAILY JOURNAL</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
            <li class="nav-item"><a class="nav-link" href="#home">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#article">Article</a></li>
            <li class="nav-item"><a class="nav-link" href="#gallery">Gallery</a></li>
            <li class="nav-item"><a class="nav-link" href="#schedule">Schedule</a></li>
            <li class="nav-item"><a class="nav-link" href="#profile">PROFILE</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">login</a></li>
          </ul>
          <button id="tombol-Gelap" class="btn btn-warning"><i class="bi bi-moon-fill"></i></button>
          <button id="tombol-Terang" class="btn btn-secondary"><i class="bi bi-sun-fill"></i></button>
        </div>
      </div>
    </nav>
    <section id="home" class="change text-center p-5 bg-danger-subtle text-sm-start change-t">
        <div class="container">
          <div class="d-sm-flex flex-sm-row-reverse align-items-center">
            <img src="img/nongkrong.jpg" class="img-fluid" width="300">
            <div>
              <h1 class="fw-bold display-4">Semua adalah sebuah memori</h1>
              <h4 class="lead display-6">Mencatat kegiatan sehari hari yang ada tanpa terkecuali</h4>
              <h6>
                <span id="tanggal"></span>
                <span id="jam"></span>
              </h6>
            </div>
          </div>
        </div>
    </section>
    <section id="article" class="text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">article</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center">
          <?php
          $sql = "SELECT * FROM article ORDER BY tanggal DESC";
          $hasil = $conn->query($sql); 
          while($row = $hasil->fetch_assoc()){
          ?>
            <div class="col">
              <div class="card h-100">
                <img src="img/<?= $row["gambar"]?>" class="card-img-top" alt="..." />
                <div class="card-body text-start">
                  <h5 class="card-title"><?= $row["judul"]?></h5>
                  <p class="card-text"><?= $row["isi"]?></p>
                </div>
                <div class="card-footer">
                  <small class="text-body-secondary"><?= $row["tanggal"]?></small>
                </div>
              </div>
            </div>
          <?php } ?> 
        </div>
      </div>
    </section>
    <section id="schedule" class="change text-center p-5">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3 text-start">Jadwal Kuliah & Kegiatan Mahasiswa</h1>
        <div class="row row-cols-1 row-cols-md-4 g-4 justify-content-center">
          <div class="col">
            <div class="schedule-card bg-white shadow-sm">
              <div class="schedule-header bg-primary text-white">Senin</div>
              <div class="p-3 text-start text-dark">
                <div class="fw-bold">09:00 - 12:00</div>
                <div>Rekayasa Perangkat Lunak</div>
                <div class="text-muted">Ruang H.5.4</div>
                <div class="fw-bold">12:30 - 15:00</div>
                <div>Logika informatika</div>
                <div class="text-muted">Ruang H.5.2</div>    
              </div>
            </div>
          </div>
          <div class="col">
            <div class="schedule-card bg-white shadow-sm">
              <div class="schedule-header bg-success text-white">Selasa</div>
              <div class="p-3 text-start text-dark">
                <div class="fw-bold">08:00 - 10:20</div>
                <div>Technopreneur</div>
                <div class="text-muted">Ruang H.4.3</div>
                <div class="fw-bold">16:20 - 18:00</div>
                <div>Pendidikan Kewarganegaraan</div>
                <div class="text-muted">Ruang E.3</div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="schedule-card bg-white shadow-sm">
              <div class="schedule-header bg-info text-white">Rabu</div>
              <div class="p-3 text-start text-dark">
                <div class="fw-bold">07:00 - 09:00</div>
                <div>Sistem Operasi</div>
                <div class="text-muted">Ruang H.4.3</div>
                <div class="fw-bold">10:20 - 12:00</div>
                <div>Pemograman Berbasis Web</div>
                <div class="text-muted">Ruang D.2.J</div>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="schedule-card bg-white shadow-sm">
              <div class="schedule-header bg-warning text-dark">Kamis</div>
              <div class="p-3 text-start text-dark">
                <div class="fw-bold">07:00 - 08:40</div>
                <div>Basis Data</div>
                <div class="text-muted">Ruang H.5.2</div>
                <div class="fw-bold">16:30 - 18.00</div>
                <div>Probabilitas dan statistik</div>
                <div class="text-muted">Ruang H.3.2</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="gallery" class="change text-center p-5 bg-danger-subtle">
      <div class="container">
        <h1 class="fw-bold display-4 pb-3">Gallery</h1>
        <?php
        $sql_g = "SELECT * FROM gallery ORDER BY tanggal DESC";
        $hasil_g = $conn->query($sql_g);
        if ($hasil_g->num_rows > 0) {
        ?>
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php
            $no = 1;
            while ($row_g = $hasil_g->fetch_assoc()) {
                $active = ($no == 1) ? 'active' : '';
            ?>
                <div class="carousel-item <?= $active ?>">
                    <img src="img/<?= $row_g['gambar'] ?>" class="w-100" style="height:400px; object-fit:contain;">
                </div>
            <?php $no++; } ?>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
          </button>
        </div>
        <?php } else { echo "<p>Belum ada gallery.</p>"; } ?>
      </div>
    </section>

    <section id="profile" class="change p-5 bg-danger-subtle">
      <div class="container">
        <h1 class="fw-bold display-4 text-start pb-3">Profil Mahasiswa</h1>
        <div class="d-flex flex-column flex-md-row align-items-center justify-content-start">
          <img src="img/wo.jpg" class="rounded-circle mb-3 mb-md-0 me-md-4" width="180" height="180">
          <div class="card change-a text-center text-md-start" style="max-width: 700px;">
            <div class="card-body">
              <h5 class="card-title fw-bold text-dark">Bintang Al Anvi</h5>
              <p class="card-text mb-1 text-dark"><strong>NIM:</strong> A11.2024.16075</p>
              <p class="card-text mb-1 text-dark"><strong>Program Studi:</strong> Teknik Informatika</p>
              <p class="card-text mb-1 text-dark"><strong>Email:</strong> bintangalanvi@gmail.com</p>
              <p class="card-text mb-1 text-dark"><strong>Telepon:</strong> +62 89659256947</p>
              <p class="card-text text-dark"><strong>Alamat:</strong> Buko kec.Wedung kota.Demak</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer id="mainFooter" class="change-ikon text-center p-5 bg-body-tertiary">
      <div>
        <a href="https://www.instagram.com/bbintngg" class="bi bi-instagram h2 p-2"></a>
        <a href="https://x.com/udinusofficial" class="bi bi-twitter-x h2 p-2"></a>
        <a href="https://wa.me/+6289659256947" class="bi bi-whatsapp h2 p-2"></a>
      </div>
      <div class="mt-2">
        A11.2024.16075 &copy; 2025 Bintang Al Anvi
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      function tampilwaktu() {
        var waktu = new Date();
        var bulan = waktu.getMonth() + 1;
        document.getElementById("tanggal").innerHTML = waktu.getDate() + "/" + bulan + "/" + waktu.getFullYear();
        document.getElementById("jam").innerHTML = waktu.getHours() + ":" + waktu.getMinutes() + ":" + waktu.getSeconds();
        setTimeout(tampilwaktu, 1000);
      }
      tampilwaktu();

      const tombolGelap = document.getElementById("tombol-Gelap");
      const tombolTerang = document.getElementById("tombol-Terang");
      const collection = document.getElementsByClassName("change");
      const textCollection = document.getElementsByClassName("change-ikon");
      const footer = document.getElementById("mainFooter");

      tombolTerang.disabled = true;

      tombolGelap.onclick = function () {
        document.body.classList.add("bg-dark", "text-white");
        tombolGelap.disabled = true;
        tombolTerang.disabled = false;
        if (footer) footer.classList.replace("bg-body-tertiary", "bg-dark");
        for (let i = 0; i < collection.length; i++) {
          collection[i].classList.remove("bg-danger-subtle", "bg-white");
          collection[i].classList.add("bg-secondary");
        }
      };

      tombolTerang.onclick = function () {
        document.body.classList.remove("bg-dark", "text-white");
        tombolTerang.disabled = true;
        tombolGelap.disabled = false;
        if (footer) footer.classList.replace("bg-dark", "bg-body-tertiary");
        for (let i = 0; i < collection.length; i++) {
          collection[i].classList.remove("bg-secondary");
          if (collection[i].id === "home" || collection[i].id === "gallery" || collection[i].id === "profile") {
            collection[i].classList.add("bg-danger-subtle");
          } else {
            collection[i].classList.add("bg-white");
          }
        }
      };
    </script>
  </body>
</html>