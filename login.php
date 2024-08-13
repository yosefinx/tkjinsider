<?php
session_start();
require 'functions.php';
if (isset($_POST["login"])) {
  $emailski = $_POST["emailski"];
  $password = $_POST["password"];

  $result = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE emailski = '$emailski'");


  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if ($password == $row["password"]) {
      $_SESSION["login"] = true;
      $_SESSION["nisn"] = $row["nisn"];
      $_SESSION["role_id"] = $row["role_id"];

      if ($row["role_id"] == 'SIS') {
        header("Location: dashboard.php");
      } elseif ($row["role_id"] == 'KETKEL') {
        header("Location: dashboardketkel.php");
      } elseif ($row["role_id"] == 'ADM') {
        header("Location: admindashboard.php");
      }
      exit;
    }
  }
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE-edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>TKJ Insider</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="stylelogin.css" />
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounder rounder-5 p-3 bg-white shadow box-area">
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: #0a3fbd">
        <div class="featured-image mb-3">
          <img src="image/Illustration - calendar front.png" class="img-fluid" style="width: 250px" />
        </div>
        <p class="text-white fs-2" style="font-family: 'IBM Plex Mono', monospace; font-weight: 700">
          TKJ INSIDER
        </p>
        <small class="text-white text-warp text-center" style="
              width: 17rem;
              font-family: 'IBM Plex Mono', monospace;
              font-weight: 500;
            ">To increase the efficiency of teaching and learning
          activities.</small>
      </div>
      <div class="col-md-6 right-box">
        <div class="row align-items-center">
          <div class="header-text mb-4">
            <h2>Hello, Students/Admins!</h2>
            <p>We are happy to have you here.</p>
          </div>
          <form action="" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control form-control-lg bg-light fs-6" placeholder="Insert your SKI Email here" name="emailski" />
            </div>
            <div class="input-group mb-1">
              <input type="password" class="form-control form-control-lg bg-light fs-6" placeholder="Insert your password" name="password" />
            </div>
            <div class="input-group mb-5">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="formCheck" />
                <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
              </div>
            </div>
            <div class="input-group mb-3">
              <button class="btn btn-lg btn-primary w-100 fs-6" type="submit" name="login">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>