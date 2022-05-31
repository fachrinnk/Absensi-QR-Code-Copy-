<?php

session_start();
include "config/config.php";

?>
<html>

<head>
  <meta charset="UTF-8">
  <title>Login with Qrcode</title>
  <style>
  fieldset {
    display: none;
  }
  </style>
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- scanner -->
  <script src="scanner/vendor/modernizr/modernizr.js"></script>
  <script src="scanner/vendor/vue/vue.min.js"></script>

  <!-- Bootstrap4 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- css -->
  <link rel="stylesheet" href="css/masuk.css">
  <!-- Link CDN font-awesome  -->
  <link rel="stylesheet" href="font-awesome/fa/css/all.css">
  <!--  CDN SWAL-->
  <script src="swal2/dist/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="swal2/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="sweetalert2.min.css">
  <link rel="icon" href="img/TFME.jpg">

</head>

<body>

  <!-- scan -->
  <div id="app" class="box text-white" style="width: 100%; height: 100vh;">
    <div class="sidebar">
      <ul>
        <li v-if="cameras.length === 0" class="empty">No cameras found</li>
        <li v-for="camera in cameras">
          <span v-if="camera.id == activeCameraId" :title="formatName(camera.name)" class="active"><input type="radio"
              class="align-middle mr-1" checked> {{ formatName(camera.name) }}</span>
          <span v-if="camera.id != activeCameraId" :title="formatName(camera.name)">
            <a @click.stop="selectCamera(camera)"> <input type="radio"
                class="align-middle mr-1">@{{ formatName(camera.name) }}</a>
          </span>
        </li>
      </ul>
      <div class="clearfix"></div>
      <!-- form scan -->
      <form action="" method="POST" id="myForm">
        <fieldset class="scheduler-border">
          <legend class="scheduler-border"> Scan Pada Box </legend>
          <input type="text" name="qrcode" id="code" autofocus>
          <input type="date" name="date">
        </fieldset>
      </form>

      <div class="title">
        <h4 class="text-white">Check-in attendance<i class="fas fa-cloud-sun ml-4"></i></h4>
        <h6 class="text-weight-bold">Scan the QRCODE below<i class="fas fa-level-down-alt ml-2"></i></h6>
      </div>


      <?php

      if (!empty($_POST['qrcode'])) {
        // 
        $qrcode = $_POST['qrcode'];
        $arr = explode("|", $qrcode);

        $id = $arr[0];

        error_reporting(E_ALL & ~E_NOTICE);
        $username = $arr[1];
        $pass = $arr[2];
        date_default_timezone_set('Asia/Jakarta');
        $tgl = date('d-m-Y');


        // mengambil baris di table tb_user
        $sql = "SELECT * FROM tb_user WHERE username ='$username' AND password ='$pass' AND IsActive = 1";
        $resultSQL = mysqli_query($conn, $sql); // 
        $result = mysqli_fetch_array($resultSQL);

        // cek baris
        if (mysqli_num_rows($resultSQL) > 0) {

          $_SESSION['id'] = $result['id'];

          $_SESSION['username'] = $result['username'];
          $_SESSION['level'] = $result['level_user'];
          $_SESSION['dateIn'] = $result['createDate'];

          $id = $_SESSION['id'];
          $date = $_SESSION['dateIn'];
          $level_user = $_SESSION['level'];
          $username = $_SESSION['username'];
          $_SESSION['IsActive'] = TRUE;


          $cek = mysqli_query($conn, "SELECT * FROM tb_user WHERE id = '$id'");
          $resultCek = mysqli_fetch_array($cek);

          $id_db = $resultCek['id'];
          $dateIN = date_create($resultCek['createDate']);
          $tgl_db = date_format($dateIN, 'd-m-Y');

          if ($tgl == $tgl_db) {
            echo '<script>
             swal.fire ({
              title: "You have been absent today!",
                icon: "warning",
                showCancelButton: false,
                showConfirmButton: false
             });
              </script>';
            echo ' <script type="text/javascript">
               setTimeout(function(){window.top.location="index.php"} , 2000);
             </script>';
            die;
          }



          // Update data table user
          $query =  mysqli_query($conn, "UPDATE tb_user SET createDate = now() WHERE username = '$username' ");




          // var_dump($hasil['username']);
          $rec = "INSERT INTO history_in (date_masuk, username, level_user) VALUES (now(), '$username', '$level_user')";
          $hasil = mysqli_query($conn, $rec);


          // alternatif alert JS
          // echo "
          //   <script>
          //       alert ('Absen Berhasil Bro');
          //   </script>";




          $berhasil = true;
          echo '<script>
          swal("Absen Berhasil!", "Selamat Berkerja :)", "success");
          </script>';
        } else {
          echo '<script>
          swal.fire ("Data Not Found !", ":(", "error");
          </script>';
        }
      }

      ?>

    </div>
    <div class="col-xs-12 preview-container camera">
      <video id="preview" class="thumbnail"></video>
    </div>


    <a href="tataUsaha/index.php" class="btn btn-light"><i class="fas fa-sign-in-alt mr-2"></i>Login</a>
    <a href="keluar.php" class="btn btn-light"><i class="fas fa-qrcode mr-2"></i>Check-out attendance</a>
    <div class="footer d-flex justify-content-center">
      <p>Created By &copy; TIM 6 RPL</p>
    </div>

    <div class="photo">
      <img src="img/kemakom.png" alt="TFME Photo" style="width: 100px; height: 100px;">
      <img src="img/upi.png" alt="poltek" style="width: 100px; height: 100px;" class="poltek">
    </div>

    <?php if (isset($dataGanda)) : ?>
    <script>
    setTimeout(function() {
      swal.fire({
        title: "Wow!",
        text: "Message!",
        icon: "error",
        timer: 2000,
        showConfirmButton: false
      }, function() {
        window.location = "index.php";
      });
    }, 1000);
    </script>
    <?php endif; ?>

    <?php if (isset($berhasil)) : ?>
    <script>
    swal.fire("Completed!", "Happy Working <?= $username; ?> :) ", "success");
    </script>
    <script type="text/javascript">
    setTimeout(function() {
      window.top.location = "index.php"
    }, 4500);
    </script>

    <?php


      if ($username == 'resa') {
        $resa = true;
      }

      if ($username == 'widya') {
        $widya = true;
      }

      if ($username == 'fara') {
        $fara = true;
      }

      if ($username == 'rachmat') {
        $rachmat = true;
      }
      if ($username == 'diana') {
        $diana = true;
      }

      if ($username == 'riansyah') {
        $rian = true;
      }

      if ($username == 'anawati') {
        $anawati = true;
      }

      if ($username == 'putri') {
        $putri = true;
      }

      if ($username == 'garda') {
        $garda = true;
      }

      if ($username == 'hidayat') {
        $hidayat = true;
      }

      if ($username == 'tama') {
        $tama = true;
      }

      if ($username == 'fajar') {
        $fajar = true;
      }

      if ($username == 'adi') {
        $adi = true;
      }
      if ($username == 'rangga') {
        $rangga = true;
      }
      if ($username == 'pragus') {
        $pragus = true;
      }
      if ($username == 'liza') {
        $liza = true;
      }
      if ($username == 'tessha') {
        $tessha = true;
      }




      ?>
    <?php endif; ?>

    <!-- voice -->
    <?php if (isset($tessha)) :  ?>
    <audio autoplay>
      <source src="voice/tessha.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($liza)) :  ?>
    <audio autoplay>
      <source src="voice/liza.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($pragus)) :  ?>
    <audio autoplay>
      <source src="voice/pragus.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($rangga)) :  ?>
    <audio autoplay>
      <source src="voice/rangga.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>


    <?php if (isset($adi)) :  ?>
    <audio autoplay>
      <source src="voice/adi.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($fajar)) :  ?>
    <audio autoplay>
      <source src="voice/fajar.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>


    <?php if (isset($resa)) :  ?>
    <audio autoplay>
      <source src="voice/resa.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($widya)) :  ?>
    <audio autoplay>
      <source src="voice/widya.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($fara)) :  ?>
    <audio autoplay>
      <source src="voice/fara.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($rachmat)) :  ?>
    <audio autoplay>
      <source src="voice/rachmat.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($diana)) :  ?>
    <audio autoplay>
      <source src="voice/diana.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($rian)) :  ?>
    <audio autoplay>
      <source src="voice/rian.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($anawati)) :  ?>
    <audio autoplay>
      <source src="voice/anawati.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($putri)) :  ?>
    <audio autoplay>
      <source src="voice/putri.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($garda)) :  ?>
    <audio autoplay>
      <source src="voice/garda.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($hidayat)) :  ?>
    <audio autoplay>
      <source src="voice/hidayat.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>

    <?php if (isset($tama)) :  ?>
    <audio autoplay>
      <source src="voice/tama.mp3" type="audio/mpeg">
    </audio>
    <?php endif; ?>




  </div>

  <!-- scanner -->
  <script src="scanner/js/app.js"></script>
  <script src="scanner/vendor/instascan/instascan.min.js"></script>
  <script src="scanner/js/scanner.js"></script>

</body>

</html>