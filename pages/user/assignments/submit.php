<?php
    include '../../../app/controllers/user/conSubmissions.php';
    session_start();

    $assignment_id = $_POST['id'];
    $user_id = $_SESSION['user_id'];
    $file = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $created_at = date('Y-m-d H:i:s');
    if ($file != "") {
        $location = "../../../assets/files/";
        move_uploaded_file($file_tmp, $location.$file);
    }

    if (addSubmission($assignment_id, $user_id, $file, $created_at)) {
        header("Location: index.php");
    } else {
        echo "Error";
    }
?>