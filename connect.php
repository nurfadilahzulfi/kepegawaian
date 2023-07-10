<?php
    $server = "localhost";
    $database = "kepegawaian";
    $username = "root";
    $password = "";

    /*ini untuk konek database*/
    $conn = new mysqli($server,$username,$password,$database);
    /*ini untuk close koneksi*/
    $conn->close();
?>