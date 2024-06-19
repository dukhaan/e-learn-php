<?php
  include '../../../app/controllers/user/conAssignments.php';
  include '../../../app/controllers/user/conSubmissions.php';
  session_start();
  if(!isset($_SESSION['user_logged_in'])) {
    header("Location: auth/login.php");
  } else {
      $id = $_GET['id'];
      $data = getAssignmentById($id);
      $subject_id = $_GET['subject_id'];
      $mahasiswa = getMahasiswaBySubjectId($subject_id);

      $submit = getSubmissionById($id);

      include '../../../app/lib/closedb.php';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Detail &mdash; E-Learn</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/cda0666fb1.js" crossorigin="anonymous"></script>

  <!-- CSS Libraries -->

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
                    <a href="../../auth/logout.php" class="dropdown-item has-icon text-danger">
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
                    <li><a class="nav-link" href="../../admin/majors/index.php">Majors</a></li>
                    <li><a class="nav-link" href="../../admin/grades/index.php">Grades</a></li>
                    <li><a class="nav-link" href="../../admin/subjects/index.php">Subjects</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="../../admin/users/index.php" class="nav-link active"><i class="fas fa-users"></i> <span>Users</span></a>
            </li>
            <?php elseif ($_SESSION['role'] == 'dosen' || $_SESSION['role'] == 'mahasiswa') : ?>
            <li class="menu-header">Menu</li>
            <li class="nav-item">
              <a href="index.php" class="nav-link"><i class="fas fa-folder-tree"></i></i> <span>Assignments</span></a>
            </li>
            <?php endif; ?>
          </ul>
        </aside>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Detail Assignments</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="index.php">Assignments</a></div>
                    <div class="breadcrumb-item">Detail</div>
                </div>
            </div>
            <div class="section-body">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $data['title'] ?></h4>
                        <div class="card-header-action">
                          <?php if($_SESSION['role'] == 'dosen') : ?>
                          <a href="see-all.php?id=<?= $data['id'] ?>&subject_id=<?= $data['subject_id'] ?>" class="btn btn-primary"><i class="fas fa-eye"></i>&nbsp; All Submissions</a>
                          <?php elseif($_SESSION['role'] == 'mahasiswa') : ?>
                          <button type="button" class="btn btn-primary" id="submitBtn<?= $data['id'] ?>" data-toggle="modal" data-target="#modalSubmit<?= $data['id'] ?>"><i class="fas fa-upload"></i>&nbsp; Submit</button>
                          <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <h6>Deskripsi: <?= $data['description'] ?></h6>
                        <h6>Deadline: <?= $data['deadline'] ?></h6>
                        <h6>
                          Lampiran:
                          <?php if ($data['file_path'] == null) : ?>
                            <span class="badge badge-danger">Tidak ada</span>
                          <?php else : ?>
                            <?= $data['file_path']; ?> &nbsp;
                            <a href="../../download.php?file=<?= $data['file_path']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-download"></i></a>
                          <?php endif; ?>
                        </h6>
                    </div>
                </div>
                <?php if ($_SESSION['role'] == 'dosen') : ?>
                <div class="card">
                  <div class="card-header">
                    <h4>Daftar Mahasiswa</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>NIM</th>
                            <th>Email</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $i = 1; ?>
                          <?php foreach ($mahasiswa as $mhs) : ?>
                          <tr>
                            <td><?= $i ?></td>
                            <td><?= $mhs['name'] ?></td>
                            <td><?= $mhs['nim'] ?></td>
                            <td><?= $mhs['email'] ?></td>
                          </tr>
                          <?php $i++; ?>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <?php endif; ?>

                <?php if ($_SESSION['role'] == 'mahasiswa') : ?>
                  <div class="card">
                    <div class="card-header">
                      <h4>Submission</h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>NIM</th>
                              <th>Nama</th>
                              <th>Email</th>
                              <th>File Tugas</th>
                              <th>Score</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php $i = 1; ?>
                            <?php if($submit != null) : ?>
                            <?php foreach ($submit as $s) : ?>
                            <tr>
                              <td><?= $i ?></td>
                              <td><?= $s['nim'] ?></td>
                              <td><?= $s['name'] ?></td>
                              <td><?= $s['email'] ?></td>
                              <td><a href="../../download.php?file=<?= $s['file_path']; ?>" class="btn btn-primary btn-sm"><i class="fa-solid fa-download"></i></a></td>
                              <td><?= $s['score'] ?></td>
                              <td><?= $s['status'] ?></td>
                            </tr>
                            <?php $i++; ?>
                            <?php endforeach; ?>
                            <?php else : ?>
                            <tr>
                              <td colspan="7" class="text-center">Data tidak ditemukan</td>
                            </tr>
                            <?php endif; ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
            </div>
        </section>
      </div>

      <div class="modal fade" id="modalSubmit<?= $data['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Submit</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="submit.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="<?= $data['id'] ?>">
                <div class="form-group">
                  <label>File Tugas</label>
                  <div class="input-group">
                    <input type="file" class="form-control" name="file">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="updatedata">Update</button>
              </div>
            </form>
          </div>
        </div>
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

  <!-- JS Libraies -->
  <script src="../../../node_modules/summernote/dist/summernote-bs4.js"></script>

  <!-- Template JS File -->
  <script src="../../../assets/js/scripts.js"></script>
  <script src="../../../assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
</body>
</html>
