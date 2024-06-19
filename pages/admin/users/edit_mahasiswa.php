<?php
    include '../../../app/controllers/admin/conUsers.php';
    include '../../../app/controllers/admin/conGrades.php';
    session_start();
    if(!isset($_SESSION['user_logged_in'])) {
        header("Location: auth/login.php");
    } else {
        $grades = getAllGrades();
        $id = $_GET['id'];
        $datas = getMahasiswaById($id);
        $data = $datas[0];
        if (isset($_POST['submit'])) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $nim = $_POST['nim'];
            $grade_id = $_POST['grade_id'];

            if(editMahasiswa($id, $name, $email, $nim, $grade_id)) {
                header("Location: index.php");
            } else {
                echo "<script>alert('Gagal menambahkan data');</script>";
            }
        }

        include '../../../app/lib/closedb.php';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Edit Mahasiswa &mdash; Stisla</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/cda0666fb1.js" crossorigin="anonymous"></script>

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="../../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="../../../assets/css/style.css">
    <link rel="stylesheet" href="../../../assets/css/components.css">
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="../../../assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $_SESSION['nama'] ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="auth/logout.php" class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="../../index.php">E-Learn</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="../../index.php">EL</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Dashboard</li>
                        <li class="nav-item">
                            <a href="../../index.php" class="nav-link"><i class="fas fa-house"></i></i><span>Dashboard</span></a>
                        </li>
                        <?php if ($_SESSION['role'] == 'admin') : ?>
                        <li class="menu-header">Admin</li>
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cube"></i></i> <span>Master</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="../majors/index.php">Majors</a></li>
                                <li><a class="nav-link" href="../grades/index.php">Grades</a></li>
                                <li><a class="nav-link" href="../subjects/index.php">Subjects</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link"><i class="fas fa-users"></i> <span>Users</span></a>
                        </li>
                        <?php elseif ($_SESSION['role'] == 'dosen' || $_SESSION['role'] == 'mahasiswa') : ?>
                        <li class="menu-header">Menu</li>
                        <li class="nav-item">
                            <a href="../../user/assignments/index.php" class="nav-link"><i class="fas fa-folder-tree"></i></i> <span>Assignments</span></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Edit Mahasiswa</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active"><a href="index.php">Users</a></div>
                            <div class="breadcrumb-item">Edit Mahasiswa</div>
                        </div>
                    </div>
                    <div class="section-body">
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label>NIM</label>
                                                <input type="text" class="form-control" name="nim" value="<?= $data['nim'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Name</label>
                                                <input type="text" class="form-control" name="name" value="<?= $data['name'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Email</label>
                                                <input type="email" class="form-control" name="email" value="<?= $data['email'] ?>" required>
                                            </div>
                                            <div class="form-group">
                                                <label>Grade</label>
                                                <select class="form-control" name="grade_id" required>
                                                    <option value="<?= $data['grade_id'] ?>"><?= $data['grade'] ?> <?= $data['major'] ?></option>
                                                    <?php foreach($grades as $grade): ?>
                                                        <option value="<?= $grade['id'] ?>"><?= $grade['grade'] ?> <?= $grade['major'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="card-footer text-right">
                                            <button class="btn btn-primary" name="submit">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="../../../assets/js/stisla.js"></script>
    <script src="../../../node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="../../../node_modules/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>

    <!-- JS Libraies -->

    <!-- Template JS File -->
    <script src="../../../assets/js/scripts.js"></script>
    <script src="../../../assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
