<?php
    include '../../../app/lib/config.php';

    function getAllSubmissions($assignment_id) {
        global $conn;
        $sql = "SELECT submissions.id as id, users.id as user_id, 
                        file_path, score, status, 
                        nim, name, email
                FROM submissions, users, mahasiswa
                WHERE submissions.user_id = users.id AND
                        mahasiswa.user_id = users.id AND
                        assignment_id = '$assignment_id'"; 
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getSubmissionById($assignment_id) {
        global $conn;
        $sql = "SELECT submissions.id as id, users.id as user_id, 
                        file_path, score, status, 
                        nim, name, email
                FROM submissions, users, mahasiswa
                WHERE submissions.user_id = users.id AND
                        mahasiswa.user_id = users.id AND
                        assignment_id = '$assignment_id'";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function addSubmission($assignment_id, $user_id, $file_path, $created_at) {
        global $conn;
        $sql = "INSERT INTO submissions (assignment_id, user_id, file_path, status, created_at) 
                VALUES ('$assignment_id', '$user_id', '$file_path', 'pending', '$created_at')";

        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function editSubmission($id, $file_path, $updated_at) {
        global $conn;
        $sql = "UPDATE submissions SET file_path = '$file_path', updated_at = '$updated_at' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function editScore($id, $score) {
        global $conn;
        $sql = "UPDATE submissions SET score = '$score', status = 'accepted' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }
    
?>