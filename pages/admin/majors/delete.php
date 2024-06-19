<?php
    include '../../../app/controllers/admin/conMajors.php';

    $id = $_GET['id'];
    if(deleteMajor($id)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
?>