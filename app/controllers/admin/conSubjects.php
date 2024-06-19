<?php
    include '../../../app/lib/config.php';

    function getAllSubjects() {
        global $conn;
        $sql = "SELECT subjects.id as id, subject, grades.id as grade_id, grade, major FROM subjects, grades, majors WHERE subjects.grade_id = grades.id AND grades.major_id = majors.id";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function addSubject($subject, $grade_id) {
        global $conn;
        $sql = "INSERT INTO subjects (subject, grade_id) VALUES ('$subject', '$grade_id')";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function editSubject($id, $subject, $grade_id) {
        global $conn;
        $sql = "UPDATE subjects SET subject = '$subject', grade_id = '$grade_id' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteSubject($id) {
        global $conn;
        $sql = "DELETE FROM subjects WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }
?>