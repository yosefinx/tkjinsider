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
$checkattend = query("SELECT tgl_absensi FROM tb_absensi_detail INNER JOIN tb_kelas on tb_kelas.kelas_id = tb_absensi_detail.kelas_id WHERE tb_absensi_detail.kelas_id = $kelas_id;");

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
                <div style="display: flex;">
                    <div>
                        <div>
                            <h2 style="font-weight: 500;">Check Attendance</h2>
                        </div>
                        <div>
                            <p style="font-size:medium;"> <?= $nama_siswa ?> | <?= $kelas ?> | <?= $nisn ?></p>
                        </div>
                    </div>
                    <?php if ($nama_role == "Ketua Kelas") : ?>
                        <div style="margin-top:12px; padding:10px; background-color:#FEBE00; border-radius:10px; margin-left:430px">
                            <a style="text-decoration:none; color:#ffffff;" href="addattendance.php">Add Attendance</a>

                        </div>
                    <?php endif; ?>

                </div>

                <div>
                    <table style="width:100%; border-collapse: separate; border-spacing: 0 10px; margin-top:40px;">
                        <thead>
                            <tr>
                                <th style=" width: 50px;">No</th>
                                <th style=" width: 500px;">Hari</th>
                                <th style="width: 500px;">Rekap</th>
                            </tr>
                        </thead>
                        <?php
                        $prev_date = null;
                        $index = 1;
                        foreach ($checkattend as $row) :
                            // Format tanggal untuk perbandingan
                            $current_date = date("Y-m-d", strtotime($row["tgl_absensi"]));
                            // Periksa apakah tanggal sama dengan tanggal sebelumnya
                            if ($current_date != $prev_date) {
                                // Jika tidak sama, tampilkan tanggal dan tombol "Rekap"
                        ?>
                                <tr>
                                    <td style="text-align: center;"><?= $index++ ?></td>
                                    <td style="text-align: center;"><?= date('l, d F Y', strtotime($row['tgl_absensi'])) ?></td>
                                    <td style="text-align: center;">
                                        <form action="rekap_absensi.php?tgl_absensi=<?= $row["tgl_absensi"] ?>" method="post">
                                            <input type="hidden" name="tgl_absensi" value="<?= $current_date ?>">
                                            <button type="submit" style="background-color: #1E9644; color: #ffffff; padding: 5px 10px; text-decoration: none; border: none; border-radius: 5px;">Rekap</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                            // Hanya tampilkan tanggal pertama untuk setiap grup tanggal
                            $prev_date = $current_date;
                        endforeach; ?>
                    </table>
                </div>


            </div>
        </div>

    </div>

    </div>

</body>

</html>