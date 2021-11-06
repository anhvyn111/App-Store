<?php
    session_start();
    if(!isset($_SESSION['login'])){
        header('Location: index.php?navstore=login');
    }
    require('../config/connection.php');
    if(isset($_POST['BuyAppID'])){
        $user = $_SESSION['login'];
        $appID = $_POST['BuyAppID'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y H:i:s");
        $executeApp = mysqli_query($conn, "SELECT * FROM `application` WHERE ID = ".$appID." AND price > 0");
        if(mysqli_num_rows($executeApp) < 1){
            echo 2;
            exit;
        }
        else{
            $rowApp = mysqli_fetch_assoc($executeApp);
            $executeUser = mysqli_query($conn, "SELECT * FROM `account` WHERE email = '".$user."'");
            $rowUser = mysqli_fetch_assoc($executeUser);
            if($rowUser['cash'] < $rowApp['price']){
                echo 1;
                exit;
            }
        }
        $sql = "INSERT INTO buyapp_history(date, ID_app, cost, user) VALUES('".$date"', ".$appID.", ".$rowApp['price'].",'".$user."')";
        if($executeBuy = mysqli_query($conn, $sql)){
            echo 0;
            exit;
        }
    }
    if(isset($_POST['AppID']) && isset($_POST['ratingContent'])){
        
    }
?>
