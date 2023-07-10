<?php
include "connect.php";

$SQL_1 = "SELECT jbtn.IDJabatan, jbtn.ID_Satker, jbtn.NamaJabatan, jbtn.TunjanganJabatan, sat.NamaSatker
        FROM jabatan jbtn
        LEFT JOIN satker sat ON jbtn.ID_Satker = sat.ID_Satker";

$SQL_Satker = "SELECT * FROM satker";

if (isset($_GET['status'])) {
    if ($_GET['status'] == "ubah") {
        $SQL_2 = "SELECT jbtn.IDJabatan, jbtn.ID_Satker, jbtn.NamaJabatan, jbtn.TunjanganJabatan, sat.NamaSatker
                FROM jabatan jbtn
                LEFT JOIN satker sat ON jbtn.ID_Satker = sat.ID_Satker
                WHERE jbtn.IDJabatan = ".$_GET['id'];
        $conn = new mysqli($server, $username, $password, $database);
        $result_2 = $conn->query($SQL_2);
        $value_form = $result_2->fetch_object();

        if (isset($_POST['btnSimpan'])) {
            $ID_Satker = $_POST['ID_Satker'];
            $NamaJabatan = $_POST['NamaJabatan'];
            $TunjanganJabatan = $_POST['TunjanganJabatan'];

            $sqlUpdate = "UPDATE jabatan SET ID_Satker = ?, NamaJabatan = ?, TunjanganJabatan = ? WHERE IDJabatan = ?";
            $stmt = $conn->prepare($sqlUpdate);
            $stmt->bind_param("isdi", $ID_Satker, $NamaJabatan, $TunjanganJabatan, $_GET['id']);
            $stmt->execute();

            header("Location: jabatan.php");
        }
    }

    if ($_GET['status'] == "new") {
        if (isset($_POST['btnSimpan'])) {
            $ID_Satker = $_POST['ID_Satker'];
            $NamaJabatan = $_POST['NamaJabatan'];
            $TunjanganJabatan = $_POST['TunjanganJabatan'];

            $SQL_3 = "INSERT INTO jabatan (ID_Satker, NamaJabatan, TunjanganJabatan) VALUES (?, ?, ?)";
            $conn = new mysqli($server, $username, $password, $database);
            $stmt = $conn->prepare($SQL_3);
            $stmt->bind_param("isd", $ID_Satker, $NamaJabatan, $TunjanganJabatan);
            $stmt->execute();

            header("Location: jabatan.php");
        }
    }

    if ($_GET['status'] == "hapus") {
        $sqlDelete = "DELETE FROM jabatan WHERE IDJabatan = ?";
        $conn = new mysqli($server, $username, $password, $database);
        $stmt = $conn->prepare($sqlDelete);
        $stmt->bind_param("i", $_GET['id']);
        $stmt->execute();

        header("Location: jabatan.php");
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Jabatan</title>
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

input[type="number"] {
    width: 100px;
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

    <h1>Data Jabatan</h1>

    <!-- Form input data -->
    <form action="jabatan.php?status=new" method="POST">
        <label for="ID_Satker">Satuan Kerja:</label>
        <select name="ID_Satker" required>
            <?php
            // Menampilkan data satuan kerja dari database
            $conn = new mysqli($server, $username, $password, $database);
            $resultSatker = mysqli_query($conn, $SQL_Satker);
            while ($rowSatker = mysqli_fetch_assoc($resultSatker)) {
                echo "<option value='" . $rowSatker['ID_Satker'] . "'>" . $rowSatker['NamaSatker'] . "</option>";
            }
            ?>
        </select><br>

        <label for="NamaJabatan">Nama Jabatan:</label>
        <input type="text" name="NamaJabatan" required><br>

        <label for="TunjanganJabatan">Tunjangan Jabatan:</label>
        <input type="number" name="TunjanganJabatan" required><br>

        <input type="submit" name="btnSimpan" value="Simpan">
    </form>

    <hr>

    <!-- Tabel data jabatan -->
    <h2>Data Jabatan</h2>
    <table>
        <tr>
            <th>Satuan Kerja</th>
            <th>Nama Jabatan</th>
            <th>Tunjangan Jabatan</th>
            <th>Aksi</th>
        </tr>

        <?php
        // Menampilkan data jabatan dari database
        $conn = new mysqli($server, $username, $password, $database);
        $result = mysqli_query($conn, $SQL_1);
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['NamaSatker'] . "</td>";
            echo "<td>" . $row['NamaJabatan'] . "</td>";
            echo "<td>" . $row['TunjanganJabatan'] . "</td>";
            echo "<td><a href='jabatan.php?status=ubah&id=" . $row['IDJabatan'] . "'>Ubah</a> | ";
            echo "<a href='jabatan.php?status=hapus&id=" . $row['IDJabatan'] . "'>Hapus</a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Form ubah data -->
    <?php
    if (isset($_GET['status']) && $_GET['status'] == "ubah") {
        ?>
        <h2>Ubah Data Jabatan</h2>
        <form action="jabatan.php?status=ubah&id=<?php echo $_GET['id']; ?>" method="POST">
            <label for="ID_Satker">Satuan Kerja:</label>
            <select name="ID_Satker" required>
                <?php
                // Menampilkan data satuan kerja dari database
                $conn = new mysqli($server, $username, $password, $database);
                $resultSatker = mysqli_query($conn, $SQL_Satker);
                while ($rowSatker = mysqli_fetch_assoc($resultSatker)) {
                    $selected = ($value_form->ID_Satker == $rowSatker['ID_Satker']) ? "selected" : "";
                    echo "<option value='" . $rowSatker['ID_Satker'] . "' " . $selected . ">" . $rowSatker['NamaSatker'] . "</option>";
                }
                ?>
            </select><br>

            <label for="NamaJabatan">Nama Jabatan:</label>
            <input type="text" name="NamaJabatan" value="<?php echo $value_form->NamaJabatan; ?>" required><br>

            <label for="TunjanganJabatan">Tunjangan Jabatan:</label>
            <input type="number" name="TunjanganJabatan" value="<?php echo $value_form->TunjanganJabatan; ?>" required><br>

            <input type="submit" name="btnSimpan" value="Simpan">
        </form>
        <?php
    }
    ?>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>