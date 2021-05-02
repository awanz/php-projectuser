<?php 
    session_start();
    include_once("../includes/config.php");
    $status = null;
    $notif = null;
    if ($_SESSION['level'] != 2) {
      header("Location: ../index.php");
    }
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
    include_once("../includes/mysqlbase.php");
    $db = new MySQLBase($dbhost, $dbname, $dbuser, $dbpass);    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $dataArray = $_POST;
        if ($dataArray['password'] == null) {
          unset($dataArray['password']);
        }else{
          $dataArray['password'] = md5($dataArray['password']); 
        }
        $result = $db->update("users", $dataArray, 'id', $_SESSION['user_id']);

        header("Location: list.php?status=".$result['status']."&message=".$result['message']);
    }else{
        $result = $db->getBy("users", 'id', $_SESSION['user_id']);
        $dataForm = $result->fetch_object();
    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Edit Users</title>
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
          <h1><i class="fa fa-cogs"></i> Edit Users</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Users</a></li>
          <li class="breadcrumb-item"><a href="#">Edit</a></li>
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
                          <label for="username">Username <small style="color: red;">*</small></label>
                          <input value="<?= $dataForm->username ?>" name="username" class="form-control" type="text" placeholder="Your name" required>
                        </div>

                        <div class="form-group">
                          <label for="fullname">Fullname <small style="color: red;">*</small></label>
                          <input value="<?= $dataForm->fullname ?>" name="fullname" class="form-control" type="text" placeholder="Your name" required>
                        </div>
                        
                        <div class="form-group">
                          <label for="email">Email <small style="color: red;">*</small></label>
                          <input value="<?= $dataForm->email ?>" name="email" class="form-control" type="email" placeholder="you@mal.com" required>
                        </div>
                        
                        <div class="form-group">
                          <label for="phone">Phone <small style="color: red;">*</small></label>
                          <input value="0<?= $dataForm->phone ?>" name="phone" class="form-control" type="text" placeholder="085........." required>
                        </div>
                        
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="level" type="radio" name="level" value="1" <?php if($dataForm->level == 1){ echo "checked"; } ?>>User
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="form-check-input" id="level" type="radio" name="level" value="2" <?php if($dataForm->level == 2){ echo "checked"; } ?>>Administrator
                                </label>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">Update</button>
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

    
  </body>
</html>