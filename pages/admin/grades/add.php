<?php
    include '../../../app/controllers/admin/conGrades.php';

    $grade = $_POST['grade'];
    $major_id = $_POST['major_id'];
    
    if(addGrade($grade, $major_id)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
?>