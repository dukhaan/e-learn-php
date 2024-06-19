<?php
  include '../../../app/controllers/admin/conMajors.php';
  session_start();

  if(!isset($_SESSION['user_logged_in'])) {
    header("Location: auth/login.php");
  } else {
    $data = getAllMajors();
    $i = 1;

    include '../../../app/lib/closedb.php';
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Majors &mdash; E-Learn</title>

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
              <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-cube"></i></i> <span>Departemen</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link active" href="index.php">Program Studi</a></li>
                <li><a class="nav-link" href="../grades/index.php">Kelas</a></li>
                <li><a class="nav-link" href="../subjects/index.php">Mata Kuliah</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a href="../users/index.php" class="nav-link"><i class="fas fa-users"></i> <span>Users</span></a>
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
            <h1>Program Studi</h1>
          </div>

          <div class="section-body">
            <div class="card">
              <div class="card-header">
                <h4><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAdd"><i class="fas fa-plus"></i> Add</button></h4>

              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <?php if($data != NULL) : ?>
                  <table class="table table-striped table-md">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach($data as $dt): ?>
                      <tr>
                        <td><?= $i++ ?></td>
                        <td style="display:none"><?= $dt['id'] ?></td>
                        <td><?= $dt['major'] ?></td>
                        <td>
                          <button class="btn btn-warning editbtn"><i class="fas fa-pen-to-square"></i></button>
                          <a href="delete.php?id=<?= $dt['id'] ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                  <?php else : ?>
                    <div class="alert alert-light" role="alert">
                      <center>Data kosong!</center>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Add Major</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="add.php" method="post">
              <div class="modal-body">
                <div class="form-group">
                  <label>Nama Major</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="..." name="major">
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

      <div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Edit Major</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="edit.php" method="post">
              <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="form-group">
                  <label>Nama Major</label>
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="..." name="major" id="major">
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

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="../../../assets/js/scripts.js"></script>
  <script src="../../../assets/js/custom.js"></script>

  <!-- Page Specific JS File -->
  <script src="../../../assets/js/page/modules-datatables.js"></script>

  <script>
    $(document).ready(function () {
      $('.editbtn').on('click', function() {
        $('#modalEdit').modal('show');

        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
          return $(this).text();
        }).get();

        console.log(data);

        $('#id').val(data[1]);
        $('#major').val(data[2]);
      });
    });
  </script>

</body>
</html>
