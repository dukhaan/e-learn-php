<?php
    include '../../../app/controllers/user/conAssignments.php';

    $id = $_GET['id'];
    if(deleteAssignment($id)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }
?>