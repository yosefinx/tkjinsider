<?php
$conn = mysqli_connect("localhost", "root", "", "db_tkjinsider");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function editAbs($data)
{
    global $conn;
    $nisn = $data["nisn"];
    $time = $data["jam_absensi"];
    $status = $data["status"];
    $keterangan = $data["keterangan"];
    $tgl_absensi = $data["tgl_absensi"];

    $query = "UPDATE tb_absensi_detail 
    INNER JOIN tb_absensi ON tb_absensi_detail.absensi_id = tb_absensi.absensi_id
    SET tb_absensi_detail.jam_absensi = '$time', 
        tb_absensi.status = '$status', 
        tb_absensi.keterangan = '$keterangan'
    WHERE tb_absensi.nisn = '$nisn' AND tb_absensi_detail.tgl_absensi = '$tgl_absensi';";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function editAss($data)
{
    global $conn;
    $mapel_id = $data["mapel_id"];
    $judul = $data["judul"];
    $deadline = $data["deadline"];
    $desc_tugas = $data["desc_tugas"];

    $query = "UPDATE tb_tugas
              INNER JOIN tb_tugas_detail ON tb_tugas.tugas_id = tb_tugas_detail.tugas_id
              SET 
                  tb_tugas_detail.mapel_id = '$mapel_id',
                  tb_tugas.judul = '$judul',
                  tb_tugas.deadline = '$deadline',
                  tb_tugas.desc_tugas = '$desc_tugas'
              WHERE 
                  tb_tugas_detail.mapel_id = '$mapel_id' 
                  AND tb_tugas.judul = '$judul'";

    mysqli_query($conn, $query);


    return mysqli_affected_rows($conn);
}


function tambahAss($data)
{
    global $conn;
    $mapel_id = $data["mapel_id"];
    $judul = $data["judul"];
    $deadline = $data["deadline"];
    $desc_tugas = $data["desc_tugas"];
    $create_at = date('Y-m-d H:i:s');
    $create_by = $data["ketkel_id"];
    $kelas_id = $data["kelas_id"];


    $queryCheck = "SELECT COUNT(*) AS total FROM tb_tugas WHERE judul = '$judul' AND desc_tugas = '$desc_tugas'";
    $resultCheck = mysqli_query($conn, $queryCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);
    $totalTugas = $rowCheck["total"];


    if ($totalTugas == 0) {

        $queryTugas = "INSERT INTO tb_tugas (tugas_id, judul, create_at, create_by, deadline, desc_tugas) VALUES ( '', '$judul','$create_at','$create_by','$deadline', '$desc_tugas')";
        mysqli_query($conn, $queryTugas);

        $tugas_id = mysqli_insert_id($conn);

        if (is_array($data["nisn"]) && !empty($data["nisn"])) {
            foreach ($data["nisn"] as $nisn) {
                $queryTugasDetail = "INSERT INTO tb_tugas_detail (tugas_detail_id, tugas_id, mapel_id, kelas_id, nisn, status, submitted_at) VALUES ('','$tugas_id', '$mapel_id','$kelas_id','$nisn','Submit','')";
                mysqli_query($conn, $queryTugasDetail);
            }

            return mysqli_affected_rows($conn);
        }
    }


    return 0;
}

function tambahAtt($data)
{
    global $conn;
    $nisnArray = $data["nisn"];
    $status = $data["status"];
    $keterangan = $data["keterangan"];
    $tgl_absensi = date('Y-m-d H:i:s');
    $kelas_id = $data["kelas_id"];
    $jam_absensi = $data["jam_absensi"];

    foreach ($nisnArray as $nisn) {
        $queryAbsensi = "INSERT INTO tb_absensi (absensi_id, nisn, status, keterangan) VALUES ('', '$nisn', '$status', '$keterangan')";
        mysqli_query($conn, $queryAbsensi);
        $absensi_id = mysqli_insert_id($conn);

        $queryAbsensiDetail = "INSERT INTO tb_absensi_detail (absensi_detail_id, absensi_id, tgl_absensi, kelas_id, jam_absensi, hadir, izin, alpa) VALUES ('', '$absensi_id', '$tgl_absensi', '$kelas_id', '$jam_absensi', 0, 0, 0)";
        mysqli_query($conn, $queryAbsensiDetail);
    }
    return mysqli_affected_rows($conn);
}
