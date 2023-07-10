<?php
include_once "connect.php";

$conn = new mysqli($server, $username, $password, $database);

$SQL_1 = "SELECT ID_Satker, NamaSatker, Alamat, Telepon FROM satker";

if (isset($_GET['status'])) {
    if ($_GET['status'] == "ubah") {
        $SQL_2 = "SELECT ID_Satker, NamaSatker, Alamat, Telepon FROM satker WHERE ID_Satker = '" . $_GET['id'] . "'";
        $result_2 = $conn->query($SQL_2);
        $value_form = $result_2->fetch_object();

        if (isset($_POST['btnSimpan'])) {
            $sqlUpdate = "UPDATE satker SET NamaSatker = '" . $_POST['NamaSatker'] . "', Alamat = '" . $_POST['Alamat'] . "', Telepon = '" . $_POST['Telepon'] . "' WHERE ID_Satker = " . $_GET['id'];
            $resultUpdate = $conn->query($sqlUpdate) or die("Update Data gagal.");
            header("Location: satker.php");
        }
    }

    if ($_GET['status'] == "new") {
        if (isset($_POST['btnSimpan'])) {
            $SQL_3 = "INSERT INTO satker (NamaSatker, Alamat, Telepon) VALUES ('" . $_POST['NamaSatker'] . "', '" . $_POST['Alamat'] . "', '" . $_POST['Telepon'] . "')";

            if ($_POST['NamaSatker'] != NULL) {
                $result_3 = $conn->query($SQL_3) or die("Data baru Gagal Di Simpan");
                header("Location: satker.php");
            }
        }
    }

    if ($_GET['status'] == "hapus") {
        $sqlDelete = "DELETE FROM satker WHERE ID_Satker = '" . $_GET['id'] . "'";
        $result_delete = $conn->query($sqlDelete) or die("Gagal Di Hapus");
        header("Location: satker.php");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Input Data Satker</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <h1>Input Data Satker</h1>

    <!-- Form input data -->
    <form action="satker.php?status=new" method="POST">
        <div class="form-group">
            <label for="NamaSatker">Nama Satker:</label>
            <input type="text" class="form-control" name="NamaSatker" required>
        </div>

        <div class="form-group">
            <label for="Alamat">Alamat:</label>
            <input type="text" class="form-control" name="Alamat" required>
        </div>

        <div class="form-group">
            <label for="Telepon">Telepon:</label>
            <input type="number" class="form-control" name="Telepon" required>
        </div>

        <button type="submit" name="btnSimpan" class="btn btn-primary">Simpan</button>
    </form>

    <hr>

    <!-- Tabel data yang telah diinputkan -->
    <h2>Data Golongan</h2>
    <table class="table">
        <thead>
        <tr>
            <th>Nama Satker</th>
            <th>Alamat</th>
            <th>Telpon</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Menampilkan data dari database
        $result = mysqli_query($conn, $SQL_1);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['NamaSatker'] . "</td>";
            echo "<td>" . $row['Alamat'] . "</td>";
            echo "<td>" . $row['Telepon'] . "</td>";
            echo "<td><a href='satker.php?status=ubah&id=" . $row['ID_Satker'] . "' class='btn btn-primary'>Ubah</a> ";
            echo "<a href='satker.php?status=hapus&id=" . $row['ID_Satker'] . "' class='btn btn-danger'>Hapus</a></td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Form ubah data -->
    <?php
    if (isset($_GET['status']) && $_GET['status'] == "ubah") {
        ?>
        <h2>Ubah Data Satker</h2>
        <form action="satker.php?status=ubah&id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
                <label for="NamaSatker">Nama Satker:</label>
                <input type="text" class="form-control" name="NamaSatker" value="<?php echo $value_form->NamaSatker; ?>" required>
            </div>

            <div class="form-group">
                <label for="Alamat">Alamat:</label>
                <input type="text" class="form-control" name="Alamat" value="<?php echo $value_form->Alamat; ?>" required>
            </div>

            <div class="form-group">
                <label for="Telepon">Telepon:</label>
                <input type="number" class="form-control" name="Telepon" value="<?php echo $value_form->Telepon; ?>" required>
            </div>

            <button type="submit" name="btnSimpan" class="btn btn-primary">Simpan</button>
        </form>
        <?php
    }
    ?>
</div>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
