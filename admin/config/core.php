<?php

// pesan error 0 untuk produksi 1 pengembangan
error_reporting(0);
session_start();

if (isset($_SESSION['login']) == true) {
    $id_akun    = $_SESSION["id_akun"];
    $nama       = $_SESSION["nama"];
    $role       = $_SESSION["role"];
}

include "controller.php"; // panggil file controller.php
include "database.php"; // // panggil file database.php