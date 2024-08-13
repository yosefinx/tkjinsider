<?php
require 'functions.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
$nisn = $_SESSION["nisn"];
$result = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nisn = '$nisn'");

if ($row = mysqli_fetch_assoc($result)) {
    $nama_siswa = $row["nama_siswa"];
    $nama_depan = $row["nama_depan"];
}

$result = mysqli_query($conn, "SELECT nisn,nama_role FROM tb_siswa INNER JOIN tb_role ON tb_role.role_id = tb_siswa.role_id WHERE nisn = '$nisn'");

if ($row1 = mysqli_fetch_assoc($result)) {
    $nama_role = $row1["nama_role"];
}

$result = mysqli_query($conn, "SELECT nisn, kelas FROM tb_kelas INNER JOIN tb_isi_kelas on tb_kelas.kelas_id = tb_isi_kelas.kelas_id WHERE nisn = '$nisn'");
if ($row2 = mysqli_fetch_assoc($result)) {
    $kelas = $row2["kelas"];
}

$result = mysqli_query($conn, "SELECT COUNT(mapel_id) AS total_mapel FROM tb_mapel;");

if ($row4 = mysqli_fetch_assoc($result)) {
    $total_mapel = $row4["total_mapel"];
}

$result = mysqli_query($conn, "SELECT COUNT(tgl_absensi) AS total_hadir FROM tb_absensi_detail INNER JOIN tb_absensi ON tb_absensi.absensi_id= tb_absensi_detail.absensi_id WHERE nisn = '$nisn' and status= 'Hadir'");

if ($row5 = mysqli_fetch_assoc($result)) {
    $total_hadir = $row5["total_hadir"];
}

$result = mysqli_query($conn, "SELECT COUNT(tgl_absensi) AS total_tidakhadir FROM tb_absensi_detail INNER JOIN tb_absensi ON tb_absensi.absensi_id= tb_absensi_detail.absensi_id WHERE nisn = '$nisn' and status= 'Alpa'");

if ($row6 = mysqli_fetch_assoc($result)) {
    $total_tidakhadir = $row6["total_tidakhadir"];
}

$result = mysqli_query($conn, "SELECT COUNT(tgl_absensi) AS total_sakit FROM tb_absensi_detail INNER JOIN tb_absensi ON tb_absensi.absensi_id= tb_absensi_detail.absensi_id WHERE nisn = '$nisn' and status= 'Sakit'");

if ($row7 = mysqli_fetch_assoc($result)) {
    $total_sakit = $row7["total_sakit"];
}
$result = mysqli_query($conn, "SELECT COUNT(tgl_absensi) AS total_izin FROM tb_absensi_detail INNER JOIN tb_absensi ON tb_absensi.absensi_id= tb_absensi_detail.absensi_id WHERE nisn = '$nisn' and status= 'Izin'");

if ($row8 = mysqli_fetch_assoc($result)) {
    $total_izin = $row8["total_izin"];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Student</title>
    <link rel="stylesheet" href="styledb.css" />

</head>

<body>
    <div class="left">
        <div class="icontkj">
            <p>TKJ INSIDER</p>
        </div>

        <br>
        <div class="profilepic">
            <div><img src="image/profile.jpg" class="user-pic" width="40px"></div>
            <div class="contentprofilepic">
                <p><?= $nama_depan ?></p>
                <strong style="font-size: small;"><?= $nama_role ?></strong>
            </div>


        </div>
        <div class="navigation" style="margin-top: 20px;">
            <ul>
                <li>
                    <a href="dashboard.php">
                        <span class="icon"><img src="image/dashboard .png" width="20px"></span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="attendance.php">
                        <span class="icon"><img src="image/user (7) 1.png" width="20px"></span>
                        <span class="title">Attendance</span>
                    </a>
                </li>
                <li>
                    <a href="assignment.php">
                        <span class="icon"><img src="image/approve 1.png" width="20px"></span>
                        <span class="title">Assignment</span>
                    </a>
                </li>
                <li>
                    <a href="subjectdata.php">
                        <span class="icon"><img src="image/search (4) 1.png" width="20px"></span>
                        <span class="title">Subject Data</span>
                    </a>
                </li>
                <li>
                    <a href="calendar.php">
                        <span class="icon"><img src="image/calendar (2) 1.png" width="20px"></span>
                        <span class="title">Calendar</span>
                    </a>
                </li>
                <li>
                    <a href="classdata.php">
                        <span class="icon"><img src="image/presentation 1.png" width="20px"></span>
                        <span class="title">Class Data</span>
                    </a>
                </li>
               

                <br>

                <li style="background: #EA4644; border: 2px solid #EA4644;
                 border-radius: 25px;">
                    <a href="login.php">
                        <span class="icon"><img src="image/logout (1) 1.png" width="20px"></span>
                        <span class="title">Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="right">
        <div class="content">
            <div class="content-hello" style="position: absolute;">
                <div>
                    <h2 style="font-weight: 500;">Hello, <?= $nama_depan ?>!</h2>
                </div>
                <div>
                    <p style="font-size:medium;"> <?= $nama_siswa ?> | <?= $kelas ?> | <?= $nisn ?></p>
                </div>
                <div class="top">
                    <div style=" position:relative; display: flex;">
                        <div class="recap" style="display: flex; position:relative; background:#0077FE">
                            <div class=" recap-content">
                                <div>
                                    <p style=" font-size: 40px; font-weight:bold; color: #ffffff; margin-top: 30px; margin-left:30px"><?= $total_hadir ?></p>
                                </div>
                                <div>
                                    <p style="color: #ffffff; margin-top: 30px; margin-left:30px">Total Kehadiran</p>
                                </div>
                            </div>
                            <div style="position: absolute; margin-left: 180px;">
                                <img src="image/reading-book (1) 1.png" style=" margin-top:20px">
                            </div>
                        </div>
                        <div class="recap" style="display: flex; position:relative; margin-left:20px; background:#1E9644">
                            <div class="recap-content">
                                <div>
                                    <p style=" font-size: 40px; font-weight:bold; color: #ffffff; margin-top: 30px; margin-left:30px"><?= $total_tidakhadir ?></p>
                                </div>
                                <div>
                                    <p style="color: #ffffff; margin-top: 30px; margin-left:30px">Ketidakhadiran</p>
                                </div>
                            </div>
                            <div style="position: absolute; margin-left: 165px;">
                                <img src="image/no-entry 1.png" style=" margin-top:20px">
                            </div>
                        </div>
                        <div class="recap" style="display: flex; position:relative; margin-left:20px; background:#FEBE00">
                            <div class="recap-content">
                                <div>
                                    <p style=" font-size: 40px; font-weight:bold; color: #ffffff; margin-top: 30px; margin-left:30px"><?= $total_sakit ?></p>
                                </div>
                                <div>
                                    <p style="color: #ffffff; margin-top: 30px; margin-left:30px">Total Sakit</p>
                                </div>
                            </div>
                            <div style="position: absolute; margin-left: 140px;">
                                <img src="image/fever 1.png" style=" margin-top:20px">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bottom" style="margin-top:-50px">
                    <div style=" position:relative; display: flex;">
                        <div class="recap" style="display: flex; position:relative; background:#0B97BA">
                            <div class="recap-content">
                                <div>
                                    <p style=" font-size: 40px; font-weight:bold; color: #ffffff; margin-top: 30px; margin-left:30px"><?= $total_izin ?></p>
                                </div>
                                <div>
                                    <p style="color: #ffffff; margin-top: 30px; margin-left:30px">Total izin</p>
                                </div>
                            </div>
                            <div style="position: absolute; margin-left: 140px;">
                                <img src="image/mail 1.png" style=" margin-top:20px">
                            </div>
                        </div>
                        <div class="recap" style="display: flex; position:relative; background:#734FC8; margin-left:20px;">
                            <div class="recap-content">
                                <div>
                                    <p style=" font-size: 40px; font-weight:bold; color: #ffffff; margin-top: 30px; margin-left:30px"><?= $total_mapel ?></p>
                                </div>
                                <div>
                                    <p style="color: #ffffff; margin-top: 30px; margin-left:30px">Jumlah Mapel</p>
                                </div>
                            </div>
                            <div style="position: absolute; margin-left: 180px;">
                                <img src="image/search (3) 1.png" style=" margin-top:20px">
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="content-login" style="display: flex; margin-top:35px; margin-left:500px; width:550px">
            <div>
                <img src="image/checlist.png" class="checklist" width="18px">
            </div>
            <div style="margin-left:10px;">
                <p>You are successfully logged in as <span style="font-weight: bold; color: #0B3B62"><?= $nama_role ?></span> </p>
            </div>
        </div>
    </div>

    </div>

</body>

</html>