<?php
  include '../../../app/controllers/user/conAssignments.php';
  include '../../../app/controllers/admin/conUsers.php';
  session_start();

  if(!isset($_SESSION['user_logged_in'])) {
    header("Location: auth/login.php");
  } else {
    $id = $_SESSION['user_id'];
    if($_SESSION['role'] == 'dosen') {
      $user = getDosenById($id);
      $subject_id = $user[0]['subject_id'];
      $data = getAllAssignmentsDosen($subject_id);
      $subjects = getSubjectByDosenId($id);
    } elseif ($_SESSION['role'] == 'mahasiswa') {
      $user = getMahasiswaById($id);
      $grade_id = $user[0]['grade_id'];
      $data = getAllAssignmentsMahasiswa($grade_id);
    }
    $i = 1;

    include '../../../app/lib/closedb.php';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Assignments &mdash; E-Learn</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/cda0666fb1.js" crossorigin="anonymous"></script>

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="../../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../node_modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="../../../node_modules/bootstrap-daterangepicker/daterangepicker.css">

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
                <li><a class="nav-link" href="../admin/majors/index.php">Majors</a></li>
                <li><a class="nav-link" href="../admin/grades/index.php">Grades</a></li>
                <li><a class="nav-link" href="../admin/subjects/index.php">Subjects</a></li>
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
                  <h1>Assignments</h1>
                  <?php if($_SESSION['role'] == 'dosen') : ?>
                  <div class="section-header-breadcrumb">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i> Add</button>
                  </div>
                  <?php endif; ?>
              </div>

              <div class="section-body">
                  <div class="row">
                    <?php foreach($data as $dt) : ?>
                      <div class="col-lg-4 col-md-4 col-sm-12">
                          <div class="card card-statistic-2">
                              <div class="card-header text-center">
                                  <strong style="font-size : 15pt"><?= $dt['title'] ?></strong>
                                  <p style="font-size : 9pt;"><?= $dt['subject'] ?><br><?= $dt['grade'] ?> <?= $dt['major'] ?></p>
                                  <hr>
                              </div>
                              <div class="card-body">
                                  <h6 style="font-size: 11pt"><?= $dt['description'] ?></h6>
                                  <p style="font-size: 11pt">Deadline : <?= $dt['deadline'] ?></p>
                              </div>
                              <div class="card-footer text-right">
                                  <?php if($_SESSION['role'] == 'dosen') : ?>
                                    <button type="button" class="btn btn-sm btn-warning editbtn" id="editBtn<?= $dt['id'] ?>" data-toggle="modal" data-target="#modalEdit<?= $dt['id'] ?>">edit</button>
                                  <a href="delete.php?id=<?= $dt['id'] ?>" class="btn btn-sm btn-danger">delete</a>
                                  <?php endif; ?>
                                  <a href="detail.php?id=<?= $dt['id'] ?>&subject_id=<?= $dt['subject_id'] ?>" class="btn btn-sm btn-info">read more</a>
                              </div>
                          </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
              </div>
          </section>
      </div>

      <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Add Assignment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="add.php" method="post" enctype="multipart/form-data">
              <div class="modal-body">
                <div class="form-group">
                  <label>Subject</label>
                  <select class="form-control" name="subject_id">
                    <option value="">Pilih Subject</option>
                    <?php foreach($subjects as $subject): ?>
                    <option value="<?= $subject['id'] ?>"><?= $subject['subject'] ?> - <?= $subject['grade'] ?> <?= $subject['major'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Judul</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="..." name="title" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Deadline</label>
                  <div class="input-group">
                    <input type="text" class="form-control datetimepicker" name="deadline" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <div class="input-group">
                    <textarea class="form-control" placeholder="..." name="description" style="height: 100px;" required></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label>Lampiran</label>
                  <div class="input-group">
                    <input type="file" class="form-control" placeholder="..." name="file">
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" name="addData">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php foreach($data as $dt): ?>
      <div class="modal fade" id="modalEdit<?= $dt['id'] ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Edit Assignment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="edit.php" method="post" enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="<?= $dt['id'] ?>">
                <div class="form-group">
                  <label>Subject</label>
                  <select class="form-control" name="subject_id">
                    <option value="<?= $dt['subject_id'] ?>"><?= $dt['subject'] ?> - <?= $dt['grade'] ?> <?= $dt['major'] ?></option>
                    <?php foreach($subjects as $subject): ?>
                    <option value="<?= $subject['id'] ?>"><?= $subject['subject'] ?> - <?= $subject['grade'] ?> <?= $subject['major'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label>Judul</label>
                  <div class="input-group">
                    <input type="text" class="form-control" value="<?= $dt['title'] ?>" name="title" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Deadline</label>
                  <div class="input-group">
                    <input class="form-control datetimepicker" value="<?= $dt['deadline'] ?>" name="deadline" required>
                  </div>
                </div>
                <div class="form-group">
                  <label>Deskripsi</label>
                  <div class="input-group">
                    <textarea class="form-control" name="description" style="height: 100px;" required><?= $dt['description'] ?></textarea>
                  </div>
                </div>
                <div class="form-group">
                  <label>Lampiran</label>
                  <div class="input-group">
                    <p><?= $dt['file_path'] ?></p>
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
      <?php endforeach; ?>


      <footer class="main-footer">
        <div class="footer-left">
        </div>
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
  <script src="../../../node_modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
  <script src="../../../node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="../../../assets/js/scripts.js"></script>
  <script src="../../../assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="../../../assets/js/page/modules-datatables.js"></script>
  <script src="../../../assets/js/page/forms-advanced-forms.js"></script>

</body>
</html>
