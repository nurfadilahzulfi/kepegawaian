<?php
include_once "connect.php";
//connect ke database
$conn = new mysqli($server, $username, $password, $database);
$SQL_1 = "SELECT ID_Golongan, GajiPokok FROM golongan";


?>

<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .card{
            margin-right: 20px;
            margin-left: 20px;
        }
    </style>
</head>
<body>

<!--navbar-->
<nav class="navbar navbar-expand-lg bg-body-primary fw-medium">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">PT ASAM JAWA</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Tentang Kami</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Data Pegawai
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="golongan.php">Golongan</a></li>
            <li><a class="dropdown-item" href="satker.php">Satuan Kerja</a></li>
            <li><a class="dropdown-item" href="jabatan.php">Jabatan</a></li>
            <li><a class="dropdown-item" href="pegawai.php">Pegawai</a></li>
            <li><a class="dropdown-item" href="ReportGaji.php">Report Gaji</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
    </div>
</nav>
<!--INI UNTUK TEXT-->
        <h1 class="text-center" style="margin-top:250px;">Selamat Datang Di sistem Informasi Kepegawaian</h1>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
