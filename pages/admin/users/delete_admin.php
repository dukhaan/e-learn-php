<?php
    include '../../../app/controllers/admin/conUsers.php';

    $id = $_GET['id'];
    if(deleteAdmin($id)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
?>