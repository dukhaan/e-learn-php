<?php 
    include '../../../app/lib/config.php';

    function getAllGrades() {
        global $conn;
        $sql = "SELECT grades.id as id, grade, majors.id as major_id, major 
                FROM grades, majors 
                WHERE grades.major_id = majors.id";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getGradesById($id) {
        global $conn;
        
        $sql = "SELECT * FROM grades, majors WHERE grades.major_id = majors.id AND grades.id = '$id'";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function addGrade($grade, $major_id) {
        global $conn;

        $sql = "INSERT INTO grades (grade, major_id) VALUES ('$grade', '$major_id')";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function editGrade($id, $grade, $major_id) {
        global $conn;

        $sql = "UPDATE grades SET grade = '$grade', major_id = '$major_id' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteGrade($id) {
        global $conn;

        $sql = "DELETE FROM grades WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }
?>