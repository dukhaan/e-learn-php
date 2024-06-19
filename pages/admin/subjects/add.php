<?php
    include '../../../app/controllers/admin/conSubjects.php';

    $subject = $_POST['subject'];
    $grade_id = $_POST['grade_id'];
    
    if(addSubject($subject, $grade_id)) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menambahkan data');</script>";
    }
?>