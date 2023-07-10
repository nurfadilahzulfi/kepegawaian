<?php
    include_once "connect.php";

    $SQL_1 = "SELECT peg.NIP, peg.IDJabatan, peg.ID_Golongan, peg.NamaPegawai, peg.Alamat, peg.TempatLahir, peg.TglLahir, peg.Status, peg.Agama, peg.HandPhone, peg.Telepon, jab.NamaJabatan AS jabatan, gol.ID_Golongan AS golongan
            FROM pegawai peg
            LEFT JOIN jabatan jab ON peg.IDJabatan = jab.IDJabatan
            LEFT JOIN golongan gol ON peg.ID_Golongan = gol.ID_Golongan";

    $conn = new mysqli($server, $username, $password, $database);
    $result_pegawai = mysqli_query($conn, $SQL_1);

if (isset($_GET['status'])) {
    if ($_GET['status'] == "ubah") {
        $SQL_2 = "SELECT peg.NIP, peg.IDJabatan, peg.ID_Golongan, peg.NamaPegawai, peg.Alamat, peg.TempatLahir, peg.TglLahir, peg.Status, peg.Agama, peg.HandPhone, peg.Telepon, jab.NamaJabatan AS jabatan, gol.ID_Golongan AS golongan
                FROM pegawai peg
                LEFT JOIN jabatan jab ON peg.IDJabatan = jab.IDJabatan
                LEFT JOIN golongan gol ON peg.ID_Golongan = gol.ID_Golongan
                WHERE NIP = '".$_GET['id']."'";

        $result_2 = $conn->query($SQL_2);
        $value_form = $result_2->fetch_assoc();

        if (isset($_POST['btnSimpan'])) {
            $sqlUpdate = "UPDATE pegawai SET NIP='".$_POST['NIP']."', IDJabatan='".$_POST['Jabatan']."', ID_Golongan='".$_POST['Golongan']."', NamaPegawai='".$_POST['NamaPegawai']."', Alamat='".$_POST['Alamat']."', TempatLahir='".$_POST['TempatLahir']."', TglLahir='".$_POST['TanggalLahir']."', Status='".$_POST['StatusPerkawinan']."', Agama='".$_POST['Agama']."', HandPhone='".$_POST['HP']."', Telepon='".$_POST['Telp']."' WHERE NIP='".$_GET['id']."'";

            $resultUpdate = $conn->query($sqlUpdate) or die("Update Data gagal.");
            header("Location: pegawai.php");
        }
    }

        if ($_GET['status'] == "new") {
            if (isset($_POST['btnSimpan'])) {
                $SQL_3 = "INSERT INTO pegawai(NIP, IDJabatan, ID_Golongan, NamaPegawai, Alamat, TempatLahir, TglLahir, Status, Agama, Handphone, Telepon) VALUES('".$_POST['NIP']."', '".$_POST['Jabatan']."', '".$_POST['Golongan']."', '".$_POST['NamaPegawai']."', '".$_POST['Alamat']."', '".$_POST['TempatLahir']."', '".$_POST['TanggalLahir']."', '".$_POST['StatusPerkawinan']."', '".$_POST['Agama']."', '".$_POST['HP']."', '".$_POST['Telp']."')";

                if ($_POST['NIP'] != NULL) {
                    $result_3 = mysqli_query($conn, $SQL_3) or die("Data baru Gagal Disimpan");
                    header("Location: pegawai.php");
                }
            }
        }

        if ($_GET['status'] == "hapus") {
            $sqlDelete = "DELETE FROM pegawai WHERE NIP='".$_GET['id']."'";
            $result_delete = mysqli_query($conn, $sqlDelete) or die("Gagal Dihapus");
            header("Location: pegawai.php");
        }
    }
    ?>
<!DOCTYPE html>
<html>

<head>
    <title>Data Pegawai</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

h1 {
    color: #333;
}

h2 {
    margin-top: 30px;
    color: #333;
}

form {
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-align: left;
    border-bottom: 1px solid #ccc;
}

th {
    background-color: #f2f2f2;
}

input[type="text"], select, textarea {
    width: 200px;
    padding: 5px;
    border: 1px solid #ccc;
}

input[type="submit"] {
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
}

a {
    color: #0066cc;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
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
    <h1>Input Data Pegawai</h1>

    <form action="?status=new" method="post">
        <label for="NIP">NIP:</label>
        <input type="text" name="NIP" required><br><br>

        <label for="Jabatan">Jabatan:</label>
        <select name="Jabatan" required>
            <option value="">Pilih Jabatan</option>
            <?php
            $result_jabatan = mysqli_query($conn, "SELECT * FROM jabatan");
            while ($row_jabatan = mysqli_fetch_assoc($result_jabatan)) {
                echo "<option value='".$row_jabatan['IDJabatan']."'>".$row_jabatan['NamaJabatan']."</option>";
            }
            ?>
        </select><br><br>

        <label for="Golongan">Golongan:</label>
        <select name="Golongan" required>
            <option value="">Pilih Golongan</option>
            <?php
            $result_golongan = mysqli_query($conn, "SELECT * FROM golongan");
            while ($row_golongan = mysqli_fetch_assoc($result_golongan)) {
                echo "<option value='".$row_golongan['ID_Golongan']."'>".$row_golongan['ID_Golongan']."</option>";
            }
            ?>
        </select><br><br>

        <label for="NamaPegawai">Nama Pegawai:</label>
        <input type="text" name="NamaPegawai" required><br><br>

        <label for="Alamat">Alamat:</label>
        <textarea name="Alamat" required></textarea><br><br>

        <label for="TempatLahir">Tempat Lahir:</label>
        <input type="text" name="TempatLahir" required><br><br>

        <label for="TanggalLahir">Tanggal Lahir:</label>
        <input type="date" name="TanggalLahir" required><br><br>

        <label for="StatusPerkawinan">Status Perkawinan:</label>
        <select name="StatusPerkawinan" required>
            <option value="">Pilih Status</option>
            <option value="Belum Menikah">Belum Menikah</option>
            <option value="Menikah">Menikah</option>
            <option value="cerai">Cerai</option>
        </select><br><br>

        <label for="Agama">Agama:</label>
        <select name="Agama">
            <option value="">Pilih Agama</option>
            <option value="Belum Menikah">Islam</option>
            <option value="Menikah">Kristen</option>
            <option value="cerai">Budha</option>
            <option value="cerai">Konghucu</option>
            <option value="cerai">Hindu</option>
        </select><br><br>

        <label for="HP">No. HP:</label>
        <input type="text" name="HP" required><br><br>

        <label for="Telp">Telepon:</label>
        <input type="text" name="Telp" required><br><br>

        <input type="submit" name="btnSimpan" value="Simpan">
    </form>
    <hr>
    <h2>Data Pegawai</h2>
    <table>
        <tr>
            <th>NIP</th>
            <th>Jabatan</th>
            <th>Golongan</th>
            <th>Nama Pegawai</th>
            <th>Alamat</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Status Perkawinan</th>
            <th>Agama</th>
            <th>No. HP</th>
            <th>Telepon</th>
            <th>Aksi</th>
        </tr>
        <?php
    while ($row = mysqli_fetch_assoc($result_pegawai)) {
        echo "<tr>";
        echo "<td>".$row['NIP']."</td>";
        echo "<td>".$row['jabatan']."</td>";
        echo "<td>".$row['golongan']."</td>";
        echo "<td>".$row['NamaPegawai']."</td>";
        echo "<td>".$row['Alamat']."</td>";
        echo "<td>".$row['TempatLahir']."</td>";
        echo "<td>".$row['TglLahir']."</td>";
        echo "<td>".$row['Status']."</td>";
        echo "<td>".$row['Agama']."</td>";
        echo "<td>".$row['HandPhone']."</td>";
        echo "<td>".$row['Telepon']."</td>";
        echo "<td><a href='?status=ubah&id=".$row['NIP']."'>Ubah</a> | <a href='?status=hapus&id=".$row['NIP']."'>Hapus</a></td>";
        echo "</tr>";
    }
    ?>
    </table>

    <?php
        if (isset($_GET['status']) && $_GET['status'] == "ubah") {
    ?>
    <h2>Ubah Data Pegawai</h2>
    <form action="pegawai.php?status=ubah&id=<?php echo $_GET['id']; ?>" method="POST">
        <label for="NIP">NIP:</label>
        <input type="text" name="NIP" value="<?php echo $value_form['NIP']; ?>" required><br>

        <label for="Jabatan">Jabatan:</label>
        <select name="Jabatan" required>
            <option value="">Pilih Jabatan</option>
            <?php
            $result_jabatan = mysqli_query($conn, "SELECT * FROM jabatan");
            while ($row_jabatan = mysqli_fetch_assoc($result_jabatan)) {
                $selected = ($value_form['IDJabatan'] == $row_jabatan['IDJabatan']) ? 'selected' : '';
                echo "<option value='".$row_jabatan['IDJabatan']."' $selected>".$row_jabatan['NamaJabatan']."</option>";
            }
            ?>
        </select><br>

        <label for="Golongan">Golongan:</label>
        <select name="Golongan" required>
            <option value="">Pilih Golongan</option>
            <?php
            $result_golongan = mysqli_query($conn, "SELECT * FROM golongan");
            while ($row_golongan = mysqli_fetch_assoc($result_golongan)) {
                $selected = ($value_form['ID_Golongan'] == $row_golongan['ID_Golongan']) ? 'selected' : '';
                echo "<option value='".$row_golongan['ID_Golongan']."' $selected>".$row_golongan['ID_Golongan']."</option>";
            }
            ?>
        </select><br>

        <label for="NamaPegawai">Nama Pegawai:</label>
        <input type="text" name="NamaPegawai" value="<?php echo $value_form['NamaPegawai']; ?>" required><br>

        <label for="Alamat">Alamat:</label>
        <textarea name="Alamat" required><?php echo $value_form['Alamat']; ?></textarea><br>

        <label for="TempatLahir">Tempat Lahir:</label>
        <input type="text" name="TempatLahir" value="<?php echo $value_form['TempatLahir']; ?>" required><br>

        <label for="TanggalLahir">Tanggal Lahir:</label>
        <input type="date" name="TanggalLahir" value="<?php echo $value_form['TglLahir']; ?>" required><br>

        <label for="StatusPerkawinan">Status Perkawinan:</label>
        <select name="StatusPerkawinan" required>
            <option value="">Pilih Status</option>
            <option value="Belum Menikah" <?php echo ($value_form['Status'] == 'Belum Menikah') ? 'selected' : ''; ?>>
                Belum Menikah</option>
            <option value="Menikah" <?php echo ($value_form['Status'] == 'Menikah') ? 'selected' : ''; ?>>Menikah
            </option>
            <option value="Cerai" <?php echo ($value_form['Status'] == 'Cerai') ? 'selected' : ''; ?>>Cerai
            </option>
        </select><br>

        <label for="Agama">Agama:</label>
        <select name="Agama">
            <option value="">Pilih Agama</option>
            <option value="Islam" <?php echo ($value_form['Agama'] == 'Islam') ? 'selected' : ''; ?>>Islam</option>
            <option value="Kristen" <?php echo ($value_form['Agama'] == 'Kristen') ? 'selected' : ''; ?>>Kristen
            </option>
            <option value="Budha" <?php echo ($value_form['Agama'] == 'Budha') ? 'selected' : ''; ?>>Budha</option>
            <option value="Konghucu" <?php echo ($value_form['Agama'] == 'Konghucu') ? 'selected' : ''; ?>>Konghucu
            </option>
            <option value="Hindu" <?php echo ($value_form['Agama'] == 'Hindu') ? 'selected' : ''; ?>>Hindu</option>
        </select><br>

        <label for="HP">No. HP:</label>
        <input type="text" name="HP" required <?php echo $value_form['HandPhone']; ?>><br><br>

        <label for="Telp">Telepon:</label>
        <input type="text" name="Telp" required <?php echo $value_form['Telepon']; ?>><br><br>

        <input type="submit" name="btnSimpan" value="Simpan">
    </form>
    <?php
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>