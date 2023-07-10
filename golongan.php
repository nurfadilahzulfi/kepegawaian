<?php
include_once "connect.php";
//connect ke database
$conn = new mysqli($server, $username, $password, $database);
$SQL_1 = "SELECT ID_Golongan, GajiPokok FROM golongan";

if (isset($_GET['status'])) {
    if ($_GET['status'] == "ubah") {
        $SQL_2 = "SELECT ID_Golongan, GajiPokok FROM golongan WHERE ID_Golongan='" . $_GET['id'] . "'";
        $result_2 = mysqli_query($conn, $SQL_2);
        $value_form = mysqli_fetch_object($result_2);

        if (isset($_POST['btnSimpan'])) {
            $sqlUpdate = "UPDATE golongan SET ID_Golongan='" . $_POST['IDGolongan'] . "', GajiPokok=" . $_POST['GajiPokok'] . " WHERE ID_Golongan='" . $_GET['id'] . "'";
            $resultUpdate = mysqli_query($conn, $sqlUpdate) or die("Update Data gagal.");
            header("Location: golongan.php");
            exit();
        }
    }

    if ($_GET['status'] == "new") {
        if (isset($_POST['btnSimpan'])) {
            $SQL_3 = "INSERT INTO golongan(ID_Golongan, GajiPokok) VALUES('" . $_POST['IDGolongan'] . "', " . $_POST['GajiPokok'] . ")";
            $result_3 = mysqli_query($conn, $SQL_3) or die("Data baru Gagal Di Simpan");
            header("Location: golongan.php");
            exit();
        }
    }

    if ($_GET['status'] == "hapus") {
        $sqlDelete = "DELETE FROM golongan WHERE ID_Golongan='" . $_GET['id'] . "'";
        $result_delete = mysqli_query($conn, $sqlDelete) or die("Gagal Di Hapus");
        header("Location: golongan.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Data Golongan</title>
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
            <li><a class="dropdown-item" href="ReportGaji">Report Gaji</a></li>
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

    <!-- Form input data -->
    <h4 class="mt-3 text-center">Silahkan Inputkan Data </h4>
    <div class="card">
  <div class="card-body">
  <form action="golongan.php?status=new" method="POST">
        <div class="form-group">
            <label for="IDGolongan">ID Golongan:</label>
            <input type="text" class="form-control" name="IDGolongan" required>
        </div>

        <div class="form-group">
            <label for="GajiPokok">Gaji Pokok:</label>
            <input type="number" class="form-control" name="GajiPokok" required>
        </div>
        <br>
        <input type="submit" class="btn btn-primary" name="btnSimpan" value="Simpan">
    </form>

    <!-- Tabel data yang telah diinputkan -->
    
        <h4 class="text-center">Data Golongan</h4>
    <table class="table">
        <thead>
            <tr>
                <th>ID Golongan</th>
                <th>Gaji Pokok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Menampilkan data dari database
            $result = mysqli_query($conn, $SQL_1);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID_Golongan'] . "</td>";
                echo "<td>" . $row['GajiPokok'] . "</td>";
                echo "<td><a href='golongan.php?status=ubah&id=" . $row['ID_Golongan'] . "'>Ubah</a> | ";
                echo "<a href='golongan.php?status=hapus&id=" . $row['ID_Golongan'] . "'>Hapus</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
        </div>
    </div>

    <!-- Form ubah data -->
    <?php
    if (isset($_GET['status']) && $_GET['status'] == "ubah") {
        ?>
        <h2>Ubah Data Golongan</h2>
        <form action="golongan.php?status=ubah&id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
                <label for="IDGolongan">ID Golongan:</label>
                <input type="text" class="form-control" name="IDGolongan" value="<?php echo $value_form->ID_Golongan; ?>" required>
            </div>

            <div class="form-group">
                <label for="GajiPokok">Gaji Pokok:</label>
                <input type="number" class="form-control" name="GajiPokok" value="<?php echo $value_form->GajiPokok; ?>" required>
            </div>

            <input type="submit" class="btn btn-primary" name="btnSimpan" value="Simpan">
        </form>
        <?php
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
