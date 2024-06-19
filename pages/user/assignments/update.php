<?php
    include '../../../app/controllers/user/conSubmissions.php';
    session_start();

    $id = $_POST['id'];
    $score = $_POST['score'];

    if (editScore($id, $score)) {
        header("Location: index.php");
    } else {
        echo "Error";
    }
?>