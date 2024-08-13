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
$result = mysqli_query($conn, "SELECT nisn,nama_role FROM tb_siswa INNER JOIN tb_role ON tb_role.role_id = tb_siswa.role_id WHERE nisn = '$nisn'");

if ($row1 = mysqli_fetch_assoc($result)) {
    $nama_role = $row1["nama_role"];
}




// $result = mysqli_query($conn, "SELECT judul, create_by, create_at, deadline, desc_tugas, status, submitted_at, nama_mapel, nama_ketkel FROM tb_tugas INNER JOIN tb_tugas_detail ON tb_tugas.tugas_id = tb_tugas_detail.tugas_id INNER JOIN tb_mapel ON tb_tugas_detail.mapel_id = tb_mapel.mapel_id INNER JOIN tb_kelas ON tb_tugas_detail.kelas_id = tb_kelas.kelas_id INNER JOIN tb_ketkel ON tb_ketkel.ketkel_id = tb_tugas.create_by WHERE nisn = $nisn AND tb_mapel.mapel_id = '$mapel_id'");

// if ($row3 = mysqli_fetch_assoc($result)) {
//     $judul = $row3["judul"];
//     $create_by = $row3["create_by"];
//     $create_at = $row3["create_at"];
//     $deadline = $row3["deadline"];
//     $desc_tugas = $row3["desc_tugas"];
//     $status = $row3["status"];
//     $submitted_at = $row3["submitted_at"];
//     $nama_mapel = $row3["nama_mapel"];
// }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Student</title>
    <link rel="stylesheet" href="styleassignment.css" />


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
                            <h2 style="font-weight: 500; width:300px;">My Assignment</h2>
                        </div>
                        <div>
                            <p style="font-size:medium;  width:400px;"><?= $nama_siswa ?> | <?= $kelas ?> | <?= $nisn ?></p>
                        </div>

                    </div>
                </div>

                <div>
                    <div class="all-content" style="display: flex; flex-direction:column;">
                        <div class="row" style=" display: flex; margin-top:40px;">
                            <div class="kotak" style="background: #105ec5;">
                                <a href="assignmentdetail.php?mapel_id=PWL">PWL</a>
                            </div>
                            <div class="kotak" style="background: #1E9644;">
                                <a href="assignmentdetail.php?mapel_id=PDL">PDL</a>
                            </div>
                            <div class="kotak" style="background: #FEBE00;">
                                <a href="assignmentdetail.php?mapel_id=DAMI">DAMI</a>
                            </div>
                            <div class="kotak" style="background: #EA4644;">
                                <a href="assignmentdetail.php?mapel_id=TLJ">TLJ</a>
                            </div>
                        </div>
                        <div class="row" style=" display: flex; margin-top:20px;">
                            <div class="kotak" style="background: #105ec5;">
                                <a href="assignmentdetail.php?mapel_id=PPL">PPL</a>
                            </div>
                            <div class="kotak" style="background: #1E9644;">
                                <a href="assignmentdetail.php?mapel_id=ING">ING</a>
                            </div>
                            <div class="kotak" style="background: #FEBE00;">
                                <a href="assignmentdetail.php?mapel_id=BIND">BIND</a>
                            </div>
                            <div class="kotak" style="background: #EA4644;">
                                <a href="assignmentdetail.php?mapel_id=MTK">MTK</a>
                            </div>
                        </div>
                        <div class="row" style=" display: flex; margin-top:20px;">
                            <div class="kotak" style="background: #105ec5;">
                                <a href="assignmentdetail.php?mapel_id=PJOK">PJOK</a>
                            </div>
                            <div class="kotak" style="background: #1E9644;">
                                <a href="assignmentdetail.php?mapel_id=PKDK">PKDK</a>
                            </div>
                            <div class="kotak" style="background: #FEBE00;">
                                <a href="assignmentdetail.php?mapel_id=MDR">MDR</a>
                            </div>
                            <div class="kotak" style="background: #EA4644;">
                                <a href="assignmentdetail.php?mapel_id=PPKNSEJ">PPKNSEJ</a>
                            </div>
                        </div>
                        <div class="row" style=" display: flex; margin-top:20px;">
                            <div class="kotak" style="background: #105ec5;">
                                <a href="assignmentdetail.php?mapel_id=AGM">AGM</a>
                            </div>
                        </div>



                    </div>
                </div>

            </div>

        </div>
    </div>



</body>

</html>