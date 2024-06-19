<?php
    include '../../../app/controllers/user/conAssignments.php';

    if(isset($_POST['updatedata'])) {
        $id = $_POST['id'];
        $subject_id = $_POST['subject_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];
        $file = $_FILES['file']['name'] ?? '';
        $file_tmp = $_FILES['file']['tmp_name'] ?? '';
        $updated_at = date('Y-m-d H:i:s');
        if ($file != "") {
            $location = "../../../assets/files/";
            move_uploaded_file($file_tmp, $location.$file);
        }
    
        if (editAssignment($id, $subject_id, $title, $description, $file, $deadline, $updated_at)) {
            header("Location: index.php");
        } else {
            echo "Error";
        }
    }
?>