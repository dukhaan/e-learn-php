<?php
    include '../../../app/lib/config.php';

    function getSubjectIdByUserId($user_id) {
        global $conn;
        $sql = "SELECT subject_id FROM dosen WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getMahasiswaBySubjectId($subject_id) {
        global $conn;
        $sql = "SELECT DISTINCT(users.id) as id, name, email, nim, 
                        mahasiswa.grade_id as user_grade,
                        subjects.id as subject_id,
                        subjects.grade_id as subject_grade
                FROM users, mahasiswa, grades, subjects 
                WHERE mahasiswa.user_id = users.id AND
                        mahasiswa.grade_id = subjects.grade_id AND 
                        subjects.id = '$subject_id'
                ORDER BY nim ASC";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getAllAssignmentsDosen($subject_id) {
        global $conn;
        $sql = "SELECT assignments.id as id, title, description, deadline, file_path,
                        subjects.id as subject_id, subject, 
                        grades.id as grade_id, grade, 
                        majors.id as major_id, major
                FROM assignments, subjects, grades, majors
                WHERE assignments.subject_id = subjects.id AND
                        subjects.grade_id = grades.id AND
                        grades.major_id = majors.id AND
                        subjects.id = '$subject_id'
                ORDER BY assignments.id DESC";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getAllAssignmentsMahasiswa($grade_id) {
        global $conn;
        $sql = "SELECT assignments.id as id, title, description, deadline, file_path,
                        subjects.id as subject_id, subject, 
                        grades.id as grade_id, grade, 
                        majors.id as major_id, major
                FROM assignments, subjects, grades, majors
                WHERE assignments.subject_id = subjects.id AND
                        subjects.grade_id = grades.id AND
                        grades.major_id = majors.id AND
                        subjects.grade_id = '$grade_id'
                ORDER BY assignments.id DESC";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getAssignmentById($id) {
        global $conn;
        $sql = "SELECT assignments.id as id, title, description, deadline, file_path,
                        subjects.id as subject_id, subject, 
                        grades.id as grade_id, grade, 
                        majors.id as major_id, major
                FROM assignments, subjects, grades, majors
                WHERE assignments.subject_id = subjects.id AND
                        subjects.grade_id = grades.id AND
                        grades.major_id = majors.id AND
                        assignments.id = '$id'";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows[0];
    }

    function getAssignmentsBySubject($id) {
        global $conn;
        $sql = "SELECT id, subjects.id as subject_id, subject, title, description, deadline
                FROM assignments, subjects 
                WHERE assignments.subject_id = subjects.id AND subject_id = '$id'";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    function addAssignment($subject_id, $title, $description, $file_path, $deadline, $created_at) {
        global $conn;
        $sql = "INSERT INTO assignments (subject_id, title, description, file_path, deadline, created_at, update_at) VALUES ('$subject_id', '$title', '$description', '$file_path', '$deadline', '$created_at', '$created_at')";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function editAssignment($id, $subject_id, $title, $description, $file_path, $deadline, $update_at) {
        global $conn;
        $sql = "UPDATE assignments SET subject_id = '$subject_id', title = '$title', description = '$description',
                file_path = '$file_path', deadline = '$deadline', update_at = '$update_at' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteAssignment($id) {
        global $conn;
        $sql = "DELETE FROM assignments WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function getSubjectByDosenId($user_id) {
        global $conn;
        $sql = "SELECT subjects.id as id, subject, grade, major
                FROM subjects, grades, majors, dosen
                WHERE subjects.grade_id = grades.id AND
                        grades.major_id = majors.id AND
                        dosen.subject_id = subjects.id AND 
                        dosen.user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getSubjectByMahasiswaId($user_id) {
        global $conn;
        $sql = "SELECT subjects.id as id, subject, grade, major
                FROM subjects, grades, majors, mahasiswa
                WHERE subjects.grade_id = grades.id AND
                        grades.major_id = majors.id AND
                        mahasiswa.subject_id = subjects.id AND 
                        mahasiswa.user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }
?>