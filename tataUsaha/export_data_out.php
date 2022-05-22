<?php
session_start();
include '../config/config.php';

// Excel
header('Content-Type: application/vnd-ms-excel');
header('Content-Disposition: attachment; filename=Data Absen.xls');

$username = $_SESSION['username'];
$level_mhs = $_SESSION['level'] == 'mahasiswa';
$level_dsn = $_SESSION['level'] == 'dosen';
$level_tu = $_SESSION['level'] == 'tata_usaha';

if ($level_mhs) {
    $dataAbsen = mysqli_query($conn, "SELECT * FROM history_out WHERE username='$username' ORDER BY id_out DESC");
}
if ($level_dsn) {
    $dataAbsen = mysqli_query($conn, "SELECT * FROM history_out WHERE level_user='mahasiswa' ORDER BY id_out DESC");
}
if ($level_tu) {
    $dataAbsen = mysqli_query($conn, "SELECT * FROM history_out ORDER BY id_out DESC");
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Export Data</title>
  <link rel="icon" href="../img/TFME.jpg">

</head>

<body>

  <center>
    <h2>Absen Pulang</h2>
  </center>

  <center>Data Absen</center>

  <table border="1">
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Tanggal</th>
      <th>Bulan</th>
      <th>Tahun</th>
      <th>Waktu Masuk</th>
    </tr>
    <?php $no = 1; ?>
    <?php foreach ($dataAbsen as $mhs) : ?>
    <tr>
      <td><?= $no; ?></td>
      <td><?= $mhs['username']; ?></td>
      <!-- // -->
      <?php $date = date_create($mhs['date_out']); ?>
      <td><?= date_format($date, "j"); ?></td>
      <td><?= date_format($date, "F"); ?></td>
      <td><?= date_format($date, "Y"); ?></td>
      <td>
        <?= date_format($date, 'g:i:a'); ?>
      </td>
    </tr>
    <?php $no++; ?>
    <?php endforeach; ?>

  </table>

</body>

</html>