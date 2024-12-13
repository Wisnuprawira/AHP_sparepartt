<?php
$config["server"] = 'localhost';
$config["username"] = 'root';
$config["password"] = '';
$config["database_name"] = 'ahp_crips';

// Membuat koneksi ke database
$db = new mysqli($config["server"], $config["username"], $config["password"], $config["database_name"]);

// Cek koneksi
if ($db->connect_error) {
    die("Koneksi gagal: " . $db->connect_error);
}
?>