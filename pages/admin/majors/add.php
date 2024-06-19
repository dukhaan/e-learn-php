<?php
    include '../../../app/controllers/admin/conMajors.php';

    $major = $_POST['major'];

    if(addMajor($major)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
?>