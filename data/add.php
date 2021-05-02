<?php 
  session_start();
  include_once("../includes/config.php");
  $status = null;
  $notif = null;

  function uploadFile($filez)
  {
    // Upload 1
    $error = null;
    $file_max_weight = 1900000; 
    $ok_ext = array('jpg','png','gif','jpeg'); 
    $destination = '../assets/images/';
    $file = $filez;
    $filename = explode(".", $file["name"]); 
    $file_name = $file['name']; // file original name
    $file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
    $file_extension = $filename[count($filename)-1];
    $file_weight = $file['size'];
    $file_type = $file['type'];

    // If there is no error
    if( $file['error'] == 0 ){
        // mengecek apakah extensi file sama dengaan keinginan
        if( in_array($file_extension, $ok_ext)):
            // mengecek ukuran file
            if( $file_weight <= $file_max_weight ):
                    // mengubah nama file, dan di encript dengan md5
                    $fileNewName = md5( $file_name_no_ext[0].microtime() ).'.'.$file_extension ;
                    // and move it to the destination folder
                    if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ):
                      $error = "sukses";
                    else:
                      $error = "Upload Gagal";
                    endif;
            else:
               $error = "File terlalu besar";
            endif;
        else:
            $error = "Extensi file tidak didukung";
        endif;
    }
    // End Upload 1
    $result = [
      "error" => $error,
      "filename" => $fileNewName
    ];
    return $result;
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

  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    include_once("../includes/mysqlbase.php");
    $db = new MySQLBase($dbhost, $dbname, $dbuser, $dbpass);
    $dataArray = $_POST;
    

    $jumlahFile = 0;
    if (!empty($_FILES['file']['name'])) {
      $stat[$jumlahFile] = uploadFile($_FILES['file']);
      $jumlahFile++;
    }
    if (!empty($_FILES['file2']['name'])) {
      $stat[$jumlahFile] = uploadFile($_FILES['file2']);
      $jumlahFile++;
    }
    if (!empty($_FILES['file3']['name'])) {
      $stat[$jumlahFile] = uploadFile($_FILES['file3']);
      $jumlahFile++;
    }
    if (!empty($_FILES['file4']['name'])) {
      $stat[$jumlahFile] = uploadFile($_FILES['file4']);
      $jumlahFile++;
    }
    
    $hitungImages = 1;
    foreach ($stat as $key => $value) {
      if ($value['error'] != 'sukses') {
        header("Location: add.php?status=0&message=".$value['error']);
      }else{
        $dataArray['image'.$hitungImages] = $value['filename'];
        $hitungImages++;
      }
    }
    $dataArray['user_id'] = $_SESSION['user_id'];

    $dataArray['tanggal'] = date("Y-m-d", strtotime($dataArray['tanggal']));  

    $result = $db->insert("data", $dataArray);
    if ($result['status'] == 0) {
      header("Location: add.php?status=".$result['status']."&message=".$result['message']);
    }else{
      header("Location: list.php?status=".$result['status']."&message=".$result['message']);
    }

    
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>Data Add</title>
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
          <h1><i class="fa fa-tasks"></i> Data</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="#">Data</a></li>
          <li class="breadcrumb-item"><a href="#">Add</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form action="" method="POST" enctype="multipart/form-data">
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
                    <div class="col-lg-8">
                        <div class="form-group">
                            <input name="tema" class="form-control" type="text" placeholder="Tema" required>
                        </div>
                        <div class="form-group">
                            <input name="tempat" class="form-control" type="text" placeholder="Tempat" required>
                        </div>
                        <div class="form-group">
                            <input id="demoDate" autocomplete="off" name="tanggal" class="form-control" type="text" placeholder="Tanggal" required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                          <input type="file" name="file" id="file" required>
                        </div>
                        <div class="form-group">
                          <input type="file" name="file2" id="file2">
                        </div>
                        <div class="form-group">
                          <input type="file" name="file3" id="file3">
                        </div>
                        <div class="form-group">
                          <input type="file" name="file4" id="file4">
                        </div>
                        
                    </div>
                </div>
                <div class="tile-footer">
                    <a href="list.php" class="btn btn-danger" type="submit">Cancel</a>
                    <button class="btn btn-primary" type="submit">Save</button>
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
    <script type="text/javascript" src="../assets/js/plugins/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="../assets/plugins/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
    <script type="text/javascript">
     
      $('#demoDate').datepicker({
      	format: "yyyy-mm-dd",
      	autoclose: true,
      	todayHighlight: true
      });
      
    </script>
  </body>
</html>