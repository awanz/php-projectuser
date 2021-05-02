<?php 
    session_start();
    include_once("../includes/config.php");
    $status = null;
    $notif = null;

    if (!empty($_GET)) {
        if (!empty($_GET['message'])) {
          $status = $_GET['status'];
          $notif = $_GET['message'];
        }
    }else {
        header("Location: ../index.php");
    }

    $id = $_GET['id'];


    include_once("../includes/mysqlbase.php");
    $db = new MySQLBase($dbhost, $dbname, $dbuser, $dbpass);    
    
    $result = $db->getBy("data", 'id', $id);
    $dataForm = $result->fetch_object();

    if (empty($dataForm)) {
        header("Location: ../index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Data Detail</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/plugins/lightgallery/dist/css/lightgallery.css">
  </head>
  <body class="app sidebar-mini">
    <?php include_once("../includes/header.php"); ?>
    <?php include_once("../includes/sidebar.php"); ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-cogs"></i> Data Detail</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Data</a></li>
          <li class="breadcrumb-item"><a href="#">Detail</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="" method="POST">
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <h1 style="text-align: center;"><?= $dataForm->tema ?></h1>
                        </div>
                        <?php 
                          $resultUser = $db->getBy("users", 'id', $dataForm->user_id);
                          $dataUsers = $resultUser->fetch_assoc();
                        ?>
                        <div>
                          Dibuat oleh: <b><?= $dataUsers['fullname'] ?></b>
                        </div>
                        <div>
                          Tanggal: <b><?= $dataForm->tanggal ?></b>
                        </div>
                        
                        <div id="lightgallery" class="row" style="margin-top: 10px; margin-bottom: 10px;">
                          <?php if (!empty($dataForm->image1)) { ?>
                          <a href="../assets/images/<?= $dataForm->image1 ?>" class="col-md-3">
                            <img src="../assets/images/<?= $dataForm->image1 ?>" width="100%">
                          </a>
                          <?php } ?>
                          <?php if (!empty($dataForm->image2)) { ?>
                          <a href="../assets/images/<?= $dataForm->image2 ?>" class="col-md-3">
                            <img src="../assets/images/<?= $dataForm->image2 ?>" width="100%">
                          </a>
                          <?php } ?>
                          <?php if (!empty($dataForm->image3)) { ?>
                          <a href="../assets/images/<?= $dataForm->image3 ?>" class="col-md-3">
                            <img src="../assets/images/<?= $dataForm->image3 ?>" width="100%">
                          </a>
                          <?php } ?>
                          <?php if (!empty($dataForm->image4)) { ?>
                          <a href="../assets/images/<?= $dataForm->image4 ?>" class="col-md-3">
                            <img src="../assets/images/<?= $dataForm->image4 ?>" width="100%">
                          </a>
                          <?php } ?>
                        </div>
                        <div class="form-group">
                        <?= $dataForm->description ?>
                        </div>
                    </div>
                </div>
            </div>
          </form>
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
    <script src="../assets/plugins/lightgallery/dist/js/lightgallery.min.js"></script>
    <script>
      lightGallery(document.getElementById('lightgallery'));
    </script>
  </body>
</html>