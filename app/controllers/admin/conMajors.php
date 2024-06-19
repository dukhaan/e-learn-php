<?php
    include '../../../app/lib/config.php';

    function getAllMajors() {
        global $conn;
        $sql = "SELECT * FROM majors";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getNameMajor($id) {
        global $conn;
        $sql = "SELECT major FROM majors WHERE id = '$id'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['name'];
    }

    function addMajor($major) {
        global $conn;

        $sql = "INSERT INTO majors (major) VALUES ('$major')";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function editMajor($id, $major) {
        global $conn;

        $sql = "UPDATE majors SET major = '$major' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteMajor($id) {
        global $conn;

        $sql = "DELETE FROM majors WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }
?>