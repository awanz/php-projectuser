<?php 
    session_start();
    if ($_SESSION['level'] != 2) {
      header("Location: ../index.php");
    }
    $status = null;
    $notif = null;
    include_once("../includes/config.php");
    if (!empty($_GET)) {
      if (!empty($_GET['message'])) {
        $status = $_GET['status'];
        $notif = $_GET['message'];
      }
    }

    if (!empty($_SESSION)) {
      if ($_SESSION['login'] != "masuk") {
        header("Location: ../index.php");
      }
    }else{
      header("Location: ../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="awan.">
    <title>Users List</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
    <?php include_once("../includes/header.php"); ?>
    <?php include_once("../includes/sidebar.php"); ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> Users Lists</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Users</a></li>
          <li class="breadcrumb-item"><a href="#">Lists</a></li>
        </ul>
      </div>
      <div class="row">
      <div class="col-md-12">
      
          <div class="tile">
            <?php 
              if (!empty($notif)) {
                  if ($status == 0) {
                      echo '<div class="alert alert-danger" role="alert"><center>';
                      echo $notif;
                      echo "</center></div>";
                  } 
                  if ($status == 1) {
                      echo '<div class="alert alert-primary" role="alert"><center>';
                      echo $notif;
                      echo "</center></div>";
                  } 
              }
            ?>         
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Lengkap</th>
                      <th>Phone</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      include '../includes/mysqlbase.php';
                      $db = new MySQLBase($dbhost, $dbname, $dbuser, $dbpass, $dbcharset);
                      $result = $db->getAll("users");
                      foreach ($result as $r) {
                    ?>
                    <tr>
                      <td><?= $r['id'] ?></td>
                      <td><?= $r['fullname'] ?></td>
                      <td><a href="https://wa.me/62<?= $r['phone'] ?>" target="_BLANK">0<?= $r['phone'] ?></a></td>
                      <td> 
                        <a href="detail.php?id=<?= $r['id'] ?>">Detail</a> - 
                        <a href="edit.php?id=<?= $r['id'] ?>">Edit</a> - 
                        <?php if ($r['id'] != $_SESSION['user_id']) { ?>
                        <a href="delete.php?id=<?= $r['id'] ?>" onclick="return confirm('Are you sure you want to delete this data?');">Delete</a> - 
                        <?php } ?>
                        <a href="#" onclick="reset()">Reset</a>
                    </tr>
                    <?php  } ?>
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="../assets/js/jquery-3.3.1.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="../assets/js/plugins/pace.min.js"></script>
    <!-- Data table plugin-->
    <script type="text/javascript" src="../assets/js/plugins/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="../assets/js/plugins/dataTables.bootstrap.min.js"></script>
    <script type="text/javascript">$('#sampleTable').DataTable();</script>
    <script>
    function reset() {
      var newPass = prompt("Masukan password baru", "12345");
      if (newPass != null) {
        window.location.href = 'reset.php?id=<?= $r['id'] ?>&pass='+newPass;
      }
    }
    </script>
  </body>
</html>