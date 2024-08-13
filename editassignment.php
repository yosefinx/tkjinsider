<?php
require 'functions.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


// var_dump($_POST);
$nisn = $_SESSION["nisn"];
$mapel_id = $_GET["mapel_id"];
$judul = $_GET["judul"];

$editattendance = query("SELECT mapel_id,tb_tugas.judul,deadline,desc_tugas from tb_tugas inner join
tb_tugas_detail on tb_tugas.tugas_id = tb_tugas_detail.tugas_id WHERE mapel_id='$mapel_id' and judul='$judul'")[0];
// var_dump($editattendance);

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
$mapel_id = $editattendance["mapel_id"];

if (isset($_POST["submit"])) {
    if (editAss($_POST) > 0) {
        echo "
        <script>
            alert('Data berhasil diedit');
            window.location.href = 'editaddassignment.php?mapel_id=$mapel_id';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Data tidak bisa diedit');
            window.location.href = 'editaddassignment.php?mapel_id=$mapel_id';
        </script>
        ";
    }
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
            <div class="content-hello" style="position: absolute; display:flex; flex-direction:column;">
                <div style="display: flex;">
                    <div style="margin-right:10px">
                        <a href="editaddassignment.php?mapel_id=<?= $mapel_id ?>"><img src="image/backbutton.png" width="30px"></a>
                    </div>

                    <div>
                        <div>
                            <div>
                                <h2 style="font-weight: 500;">Check Attendance</h2>
                            </div>
                            <div>
                                <p style="font-size:medium;"><?= $nama_siswa ?> | <?= $kelas ?> | <?= $nisn ?></p>
                            </div>

                        </div>
                    </div>
                </div>
                <div style="max-width: 600px; margin-top:40px; margin-left:35px;">
                    <p style="font-weight:500; font-size:large; margin-left:10px;">Edit Data</p>
                    <form action="" method="post" style="border: 1px solid #ccc; padding: 20px; border-radius: 5px; width:900px">


                        <input type="hidden" name="mapel_id" class="form-control" value="<?= $editattendance["mapel_id"] ?>">


                        <div style="margin-bottom: 10px;">
                            <label style="display: block; ">Title</label>
                            <input type="text" name="judul" class="form-control" value="<?=
                                                                                        $editattendance["judul"] ?>" style="width: 880px; padding: 8px; border: 1px solid #ccc; border-radius: 3px;" readonly>
                        </div>

                        <div style="margin-bottom: 10px;">
                            <label style="display: block; ">Deadline</label>
                            <input type="text" name="deadline" class="form-control" value="<?=
                                                                                            $editattendance["deadline"] ?>" style=" width: 880px; padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label style="display: block; ">Description</label>
                            <input type="text" name="desc_tugas" class="form-control" value="<?=
                                                                                                $editattendance["desc_tugas"] ?>" style="width: 880px; padding: 8px; border: 1px solid #ccc; border-radius: 3px;">
                        </div>



                        <div style="text-align: center;">
                            <button type="submit" name="submit" class="btn btn-primary" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 3px; cursor: pointer;">Simpan Data</button>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>
    </div>


</body>

</html>