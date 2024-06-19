<?php
    include '../../../app/controllers/admin/conGrades.php';

    $id = $_GET['id'];
    if(deleteGrade($id)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
?>