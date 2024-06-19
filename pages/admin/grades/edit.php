<?php
    include '../../../app/controllers/admin/conGrades.php';
    
    if(isset($_POST['updatedata'])) {
        $id = $_POST['id'];
        $grade = $_POST['grade'];
        $major_id = $_POST['major_id'];
        
        if(editGrade($id, $grade, $major_id)) {
            header("Location: index.php");
        } else {
            echo "<script>alert('Gagal mengubah data');</script>";
        }
    }
?>