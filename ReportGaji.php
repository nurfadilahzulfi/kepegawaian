<?php
include_once "connect.php";
?>

<html>
<head>
    <title>Report Gaji</title>
    <link rel="stylesheet" href="style.css">
    
    <style>
        body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

h1 {
    color: #333;
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

a.link {
    color: #0066cc;
    text-decoration: none;
}

a.link:hover {
    text-decoration: underline;
}

    </style>
</head>
<body>
       <h1><strong>Report Gaji</strong> <a href="index.php">Home</a></h1>
     
    <table>
        <tr">
            <th>NIP</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Golongan</th>
            <th>Gaji Pokok</th>
            <th>Tunjangan</th>
            <th>Gaji Bersih</th>
        </tr>

        <?php
        $sql = "SELECT peg.NIP, peg.NamaPegawai, jab.NamaJabatan as jabatan, gol.ID_Golongan as golongan, gol.GajiPokok, jab.TunjanganJabatan as Tunjangan, (gol.GajiPokok+jab.TunjanganJabatan) as GajiBersih FROM pegawai peg left join jabatan jab on peg.IDJabatan=jab.IDJabatan left join golongan gol on peg.ID_Golongan=gol.ID_Golongan";
        $conn = new mysqli($server, $username, $password, $database);
        $result = mysqli_query($conn, $sql);

        while ($row = mysqli_fetch_object($result)) {
        ?>
        <tr>
            <td>
                <a href="pegawai.php?status=ubah&id=<?php echo $row->NIP; ?>" style="text-decoration:none;color:black;"><?php echo $row->NIP; ?></a>
            </td>
            <td><?php echo $row->NamaPegawai; ?></td>
            <td><?php echo $row->jabatan; ?></td>
            <td><?php echo $row->golongan; ?></td>
            <td><?php echo $row->GajiPokok; ?></td>
            <td><?php echo $row->Tunjangan; ?></td>
            <td><?php echo $row->GajiBersih; ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>