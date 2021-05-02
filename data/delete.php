<?php 
    session_start();
    include_once("../includes/config.php");
    if (!empty($_SESSION)) {
        if ($_SESSION['login'] != "masuk") {
            header("Location: ../index.php");
        }
    }else{
        header("Location: ../index.php");
    }

    if (empty($_GET)) {
        header("Location: list.php");
    }else{
        if (!empty($_GET['id'])) {
            include_once("../includes/mysqlbase.php");
            $id = $_GET['id'];
            $db = new MySQLBase($dbhost, $dbname, $dbuser, $dbpass);
            $result = $db->getBy("data", "id", $id);
            if (!empty($result)) {
                $resultDelete = $db->delete("data", "id", $id);
                header("Location: list.php?status=".$resultDelete['status']."&message=".$resultDelete['message']);
            }
            
        } else {
            header("Location: list.php");
        }
    }