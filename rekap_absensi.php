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

$result = mysqli_query($conn, "SELECT nisn, kelas ,tb_isi_kelas.kelas_id FROM tb_kelas INNER JOIN tb_isi_kelas on tb_kelas.kelas_id = tb_isi_kelas.kelas_id WHERE nisn = '$nisn'");
if ($row2 = mysqli_fetch_assoc($result)) {
    $kelas = $row2["kelas"];
    $kelas_id = $row2["kelas_id"];
}

$tgl_absensi = isset($_GET["tgl_absensi"]) ? $_GET["tgl_absensi"] : null;
$rekap = [];
$tgl_absensi1 = date("Y-m-d", strtotime($tgl_absensi));

if ($tgl_absensi) {
    $rekap = query("SELECT nama_siswa, jam_absensi, status, keterangan, tb_siswa.nisn 
    FROM tb_siswa 
    INNER JOIN tb_absensi ON tb_siswa.nisn = tb_absensi.nisn 
    INNER JOIN tb_absensi_detail ON tb_absensi.absensi_id = tb_absensi_detail.absensi_id 
    WHERE DATE(tgl_absensi) = '$tgl_absensi1'AND kelas_id='$kelas_id'");
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
            <div class="content-hello" style="position: absolute; display:flex">
                <div style="margin-right:10px">
                    <a href="classattend.php"><img src="image/backbutton.png" width="30px"></a>
                </div>
                <div>
                    <div>
                        <h2 style="font-weight: 500;">Check Attendance</h2>
                    </div>
                    <div>
                        <p style="font-size:medium;"><?= $nama_siswa ?> | <?= $kelas ?> | <?= $nisn ?></p>
                    </div>
                    <div>
                        <p style="margin-top: 30px; font-weight: 500;"><?= date('l, d F Y', strtotime($tgl_absensi)) ?></p>
                        <table style="width:100%; border-collapse: separate; border-spacing: 0 10px; margin-top:20px;">
                            <thead>
                                <tr>
                                    <th style="width: 40px;">No</th>
                                    <th style="width: 200px;">Nama</th>
                                    <th style="width: 100px;">Time</th>
                                    <th style="width: 250px;">Sakit/Izin/Alpa/Hadir</th>
                                    <th style="width: 200px;">Ket</th>
                                    <th style="width: 50px;">#</th>
                                </tr>
                            </thead>
                            <?php
                            $index = 1;
                            foreach ($rekap as $row) :
                            ?>
                                <tr>
                                    <td style="text-align: center;"><?= $index++ ?></td>
                                    <td style="text-align: center;"><?= $row["nama_siswa"] ?></td>
                                    <td style="text-align: center;"><?= $row["jam_absensi"] ?></td>
                                    <td style="text-align: center;"><?= $row["status"] ?></td>
                                    <td style="text-align: center;"><?= $row["keterangan"] ?></td>
                                    <td style="text-align: center; display:flex;">
                                        <form action="editrekap.php?nisn=<?= $row["nisn"] ?>&tgl_absensi=<?= $tgl_absensi ?>" method="post">
                                            <input type="hidden" name="tgl_absensi" value="">
                                            <button type="submit" style="background-color: #FEBE00; color: #ffffff; padding: 5px 10px; text-decoration: none; border: none; border-radius: 5px;">Edit</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>



            </div>
        </div>
    </div>
    </div>


</body>

</html>