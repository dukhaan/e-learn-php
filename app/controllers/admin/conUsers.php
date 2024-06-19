<?php
    include '../../../app/lib/config.php';

    function getAllUsers() {
        global $conn;
        $sql = "SELECT * FROM users";
        $result = mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    function getDosenById($id) {
        global $conn;
        $sql = "SELECT users.id as id, name, email, 
                        dosen.id as dosen_id, subjects.id as subject_id, subject, 
                        grades.id as grade_id, grade, 
                        majors.id as major_id, major
                FROM users, dosen, subjects, grades, majors
                WHERE users.id = dosen.user_id AND 
                        dosen.subject_id = subjects.id AND 
                        subjects.grade_id = grades.id AND 
                        grades.major_id = majors.id AND
                        users.id = '$id'";

        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function getMahasiswaById($id) {
        global $conn;
        $sql = "SELECT users.id as id, name, email, nim,  
                        grades.id as grade_id, grade, 
                        majors.id as major_id, major
                FROM users, mahasiswa, subjects, grades, majors
                WHERE users.id = mahasiswa.user_id AND 
                        mahasiswa.grade_id = grades.id AND 
                        grades.major_id = majors.id AND
                        users.id = '$id'";

        $result = mysqli_query($conn, $sql);
        $rows = [];
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }

    function addAdmin($name, $email, $password, $role) {
        global $conn;

        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function addMahasiswa($name, $email, $password, $role, $nim, $grade_id) {
        global $conn;

        mysqli_begin_transaction($conn);
        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $user_id = mysqli_insert_id($conn);
            $sql = "INSERT INTO mahasiswa (nim, user_id, grade_id) VALUES ('$nim', '$user_id', '$grade_id')";
            if (mysqli_query($conn, $sql)) {
                mysqli_commit($conn);
                return true;
            } else {
                mysqli_rollback($conn);
                return false;
            }
        } else {
            mysqli_rollback($conn);
            return false;
        }
    }

    function addDosen($name, $email, $password, $role, $subject_id) {
        global $conn;

        mysqli_begin_transaction($conn);

        $sql = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        if (mysqli_query($conn, $sql)) {
            $user_id = mysqli_insert_id($conn);
            $sql = "INSERT INTO dosen (user_id, subject_id) VALUES ('$user_id', '$subject_id')";
            if (mysqli_query($conn, $sql)) {
                mysqli_commit($conn);
                return true;
            } else {
                mysqli_rollback($conn);
                return false;
            }
        } else {
            mysqli_rollback($conn);
            return false;
        }
    }

    function editDosen($id, $name, $email, $subject_id) {
        global $conn;

        mysqli_begin_transaction($conn);

        $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            $sql = "UPDATE dosen SET subject_id = '$subject_id' WHERE user_id = '$id'";
            if (mysqli_query($conn, $sql)) {
                mysqli_commit($conn);
                return true;
            } else {
                mysqli_rollback($conn);
                return false;
            }
        } else {
            mysqli_rollback($conn);
            return false;
        }
    }

    function editMahasiswa($id, $name, $email, $nim, $grade_id) {
        global $conn;

        mysqli_begin_transaction($conn);

        $sql = "UPDATE users SET name = '$name', email = '$email' WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            $sql = "UPDATE mahasiswa SET nim = '$nim', grade_id = '$grade_id' WHERE user_id = '$id'";
            if (mysqli_query($conn, $sql)) {
                mysqli_commit($conn);
                return true;
            } else {
                mysqli_rollback($conn);
                return false;
            }
        } else {
            mysqli_rollback($conn);
            return false;
        }
    }

    function deleteAdmin($id) {
        global $conn;

        $sql = "DELETE FROM users WHERE id = '$id'";
        if (mysqli_query($conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function deleteDosen($id) {
        global $conn;

        mysqli_begin_transaction($conn);

        $sql = "DELETE FROM dosen WHERE user_id = '$id'";
        if (mysqli_query($conn, $sql)) {
            $sql = "DELETE FROM users WHERE id = '$id'";
            if (mysqli_query($conn, $sql)) {
                mysqli_commit($conn);
                return true;
            } else {
                mysqli_rollback($conn);
                return false;
            }
        } else {
            mysqli_rollback($conn);
            return false;
        }
    }

    function deleteMahasiswa($id) {
        global $conn;

        mysqli_begin_transaction($conn);

        $sql = "DELETE FROM mahasiswa WHERE user_id = '$id'";
        if (mysqli_query($conn, $sql)) {
            $sql = "DELETE FROM users WHERE id = '$id'";
            if (mysqli_query($conn, $sql)) {
                mysqli_commit($conn);
                return true;
            } else {
                mysqli_rollback($conn);
                return false;
            }
        } else {
            mysqli_rollback($conn);
            return false;
        }
    }
?>