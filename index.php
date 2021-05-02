<?php 
  session_start();
  include_once("includes/config.php");
  include_once("includes/mysqlbase.php");
  if (!empty($_SESSION)) {
    if ($_SESSION['login'] == "masuk") {
      header("Location: dashboard.php");
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Dashboard</title>
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../assets/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/favicons/favicon-16x16.png">
    <link rel="manifest" href="../assets/favicons/site.webmanifest">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="assets/css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body class="app sidebar-mini">
    <?php include_once("includes/header.php"); ?>
    
    <div style="margin-top:50px; height: 100vh; background: #F5F5F5; padding: 50px;" class="h-100 w-100">
      <div class="row">
        <div class="col-md-6" style="text-align: center; margin: auto; width: 50%;">
          <h3>SIM Gallery Kegiatan</h3>
          <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet repellat tempora maiores autem accusantium ipsum, asperiores explicabo iure unde perferendis atque, porro ex eius quia velit, consectetur eaque! Quos, similique!</p>
        </div>
        <div class="col-md-6">
          <img src="assets/banner/19362653.png" alt="" style="max-width: 100%;">
        </div>
      </div>
    </div>

      <!-- <div class="app-title row" style="margin-top:50px;">
        <div class="col-md-12" style="text-align: center;">
          <h3>SIM Gallery Kegiatan</h3>
        </div>
      </div> -->
    <main style="padding-left: 20px;padding-right: 20px; margin-top: 20px; padding-bottom: 40px;">

      <div class="row">
      <?php 
        $db = new MySQLBase($dbhost, $dbname, $dbuser, $dbpass, $dbcharset);
        $result = $db->getBy("data", 'status', 1);

        if($result->num_rows > 0){
        foreach ($result as $r) {
      ?>
        <div class="col-md-3">
          <div class="tile">
            <h3 class="tile-title"><?= $r['tema'] ?></h3>
            <div class="tile-body">
              <div>
                <img src="assets/images/<?= $r['image1'] ?>" alt="" height="180px" width="100%">
              </div>
              <div>
                <small>Tanggal Update: <?= $r['tanggal'] ?></small><br>
                <?php
                  $resultUser = $db->getBy("users", 'id', $r['user_id']);
                  $dataUsers = $resultUser->fetch_assoc();
                ?>
                <small>dibuat oleh: <?php if(!empty($dataUsers['fullname'])){echo $dataUsers['fullname']; }else{echo "-";}  ?></small>
              </div>
            </div>
            <div class="tile-footer"><a class="btn btn-primary" href="data/details.php?id=<?= $r['id'] ?>">Detail</a></div>
          </div>
        </div>
      <?php }}else{ ?>
      <h4 class="col-md-12" style="text-align: center;">No record data</h4>
      <?php } ?>
      </div>
      
    </main>
    <!-- Essential javascripts for application to work-->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="assets/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="assets/js/plugins/chart.js"></script>
  </body>
</html>