<?php
    include '../../../app/controllers/admin/conSubjects.php';

    $id = $_GET['id'];
    if(deleteSubject($id)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
?>