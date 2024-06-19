<?php
    include '../../../app/controllers/admin/conMajors.php';
    
    if(isset($_POST['updatedata'])) {
        $id = $_POST['id'];
        $nama = $_POST['name'];
        
        if(editMajor($id, $nama)) {
            header("Location: index.php");
        } else {
            echo "<script>alert('Gagal mengubah data');</script>";
        }
    }
?>