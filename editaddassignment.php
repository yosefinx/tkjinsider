<?php
session_start();
require 'functions.php';

$nisn = $_SESSION["nisn"];
$attendance = query("SELECT tgl_absensi, jam_absensi, status, keterangan FROM tb_absensi_detail INNER JOIN tb_absensi ON tb_absensi.absensi_id= tb_absensi_detail.absensi_id WHERE nisn = '$nisn'");

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
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

$mapel_id = $_GET["mapel_id"];


$assignmentdetail = query("SELECT judul, create_by, create_at, deadline, desc_tugas, status, submitted_at, nama_mapel, nama_ketkel, tugas_detail_id FROM tb_tugas INNER JOIN tb_tugas_detail ON tb_tugas.tugas_id = tb_tugas_detail.tugas_id INNER JOIN tb_mapel ON tb_tugas_detail.mapel_id = tb_mapel.mapel_id INNER JOIN tb_kelas ON tb_tugas_detail.kelas_id = tb_kelas.kelas_id INNER JOIN tb_ketkel ON tb_ketkel.ketkel_id = tb_tugas.create_by WHERE nisn = $nisn AND tb_mapel.mapel_id = '$mapel_id'");

$result = mysqli_query($conn, "SELECT nama_mapel, mapel_id FROM tb_mapel WHERE mapel_id = '$mapel_id'");
if ($row4 = mysqli_fetch_assoc($result)) {
    $nama_mapel = $row4["nama_mapel"];
    $mapel_id = $row4["mapel_id"];
}
$result = mysqli_query($conn, "SELECT judul, create_by, create_at, deadline, desc_tugas, status, submitted_at, nama_mapel, nama_ketkel, tugas_detail_id FROM tb_tugas INNER JOIN tb_tugas_detail ON tb_tugas.tugas_id = tb_tugas_detail.tugas_id INNER JOIN tb_mapel ON tb_tugas_detail.mapel_id = tb_mapel.mapel_id INNER JOIN tb_kelas ON tb_tugas_detail.kelas_id = tb_kelas.kelas_id INNER JOIN tb_ketkel ON tb_ketkel.ketkel_id = tb_tugas.create_by WHERE nisn = $nisn AND tb_mapel.mapel_id = '$mapel_id'");
if ($row10 = mysqli_fetch_assoc($result)) {
    $judul = $row10["judul"];
}
if (isset($_POST["status"])) {
    $date = date("Y-m-d H:i:s");
    $tugas_detail_id = $_POST["tugas_detail_id"];
    $result = mysqli_query($conn, "UPDATE tb_tugas_detail SET status = 'Submitted', submitted_at='$date' WHERE tugas_detail_id='$tugas_detail_id'");

    header("Location: assignmentdetail.php?mapel_id=$mapel_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Student</title>
    <link rel="stylesheet" href="styleassignment.css">
    <script src="script.js"> </script>
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
        <div class="nav" style="margin-top: 20px;">
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
                <li style="background: #EA4644; border: 2px solid #EA4644; border-radius: 25px;">
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
            <div class="content-hello" style="position: absolute; display:flex; width:1100px;">
                <div style="margin-right:10px">
                    <a href="assignment.php"><img src="image/backbutton.png" width="30px"></a>
                </div>
                <div>
                    <div>
                        <h2 style="font-weight: 500;"><?= $nama_mapel ?></h2>
                    </div>
                    <div>
                        <p style="font-size:medium;"><?= $nama_siswa ?> | <?= $kelas ?> | <?= $nisn ?></p>
                    </div>
                </div>
                <div style="position:absolute; margin-top:105px;">
                    <div class="all-content" style="display: flex; flex-direction:column;">
                        <?php foreach ($assignmentdetail as $key => $row) : ?>
                            <div class="box" style="background-color: #ffffff; border: 2px solid #105ec5; border-radius: 10px; margin-top:20px;">
                                <div style="padding: 20px;">
                                    <div style="width:1000px; display:flex; height:40px">
                                        <h2 style="width: 600px; height:30px; margin-right:300px;"><?= $row["judul"] ?></h2>
                                        <div style="text-align:right;">
                                            <div>
                                                <p style="width: 200px;"><?= date('l, d F Y', strtotime($row["deadline"])) ?></p>
                                                <p style="width: 200px;"><?= date('H:i:s', strtotime($row["deadline"])) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="display: flex; font-size:small;">
                                        <p style="margin-right:10px; width:auto;"><?= $row["nama_ketkel"] ?></p>
                                        <p style="width: auto;"><?= date('l, d F Y', strtotime($row["create_at"])) ?></p>
                                    </div>
                                    <div style="margin-top:10px">
                                        <p style="width:1000px; text-align:left; font-size:10;"><?= $row["desc_tugas"] ?></p>
                                    </div>
                                    <div style="margin-top:10px; display:flex;">
                                        <form action="editassignment.php?mapel_id=<?= $mapel_id ?>& judul=<?= $row["judul"] ?>" method="post">
                                            <input type="hidden" name="tugas_detail_id" value="<?= $row["tugas_detail_id"] ?>">
                                            <button style="border-radius:30px; background-color:#FEBE00;">Edit</button>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php if ($nama_role == "Ketua Kelas") : ?>
                    <div style="margin-top:12px; padding:10px; background-color:#FEBE00; border-radius:10px; margin-left:430px">
                        <a style="text-decoration:none; color:#ffffff;" href="addassignment.php?mapel_id=<?= $mapel_id ?>">Add Assignment</a>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>