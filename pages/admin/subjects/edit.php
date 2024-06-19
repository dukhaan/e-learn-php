<?php
    include '../../../app/controllers/admin/conSubjects.php';
    
    if(isset($_POST['updatedata'])) {
        $id = $_POST['id'];
        $subject = $_POST['subject'];
        $grade_id = $_POST['grade_id'];
        
        if(editSubject($id, $subject, $grade_id)) {
            header("Location: index.php");
        } else {
            echo "<script>alert('Gagal mengubah data');</script>";
        }
    }
?>