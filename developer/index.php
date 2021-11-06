<!DOCTYPE html>
<html lang="en">
  <head>
    <link href = "../img/logo.png" rel="icon" type="image/gif">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quản lí nhà phát triển NAV STORE</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="../style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </head>
  <body>
    <?php
      session_start();
      if(isset($_SESSION["login"])){
        require("../config/connection.php");
        $email = $_SESSION["login"];
        $cashCheck = mysqli_query($conn, "SELECT * FROM account WHERE email = '$email'");
        $row = mysqli_fetch_array($cashCheck);
        if($row["status"] == 0){
          echo '<script>alert("Bạn không phải là nhà phát triển. Chọn OK để về trang chủ");
          window.location.href ="../store/index.php?navstore=home";</script>';
        }
        else{
          $selectID = mysqli_query($conn,"SELECT * FROM developer WHERE per_email = '".$email."'");
          $rowDev = mysqli_fetch_assoc($selectID);
          $devID = $rowDev["ID"];
          $_SESSION['Dev'] = $devID;
        }
      }
      else{
        header("Location: ../store/index.php?navstore=login");
      }

      if(isset($_GET['logout'])){
        unset($_SESSION['login']);

        header("Location: ../store/index.php?navstore=login");
      }
    ?>
    <div class="sidebar listgroup-admin">
      <div class="sidebar-heading-admin listgroup-admin">
        <div class="row justify-content-center mt-3 ">
          <img src="../img/logo.png" width="70" height="70" style=""></img>
        </div>
        <div class="row justify-content-center mt-3">
          <a class="border rounded btn text-white mb-3"href="../store/index.php?navstore=home">Trở về cửa hàng</a>
          <a class=" border rounded btn text-white mb-3" href="index.php?logout">Đăng xuất</a>
        </div>
      </div>
      <div class="list-group list-group-flush">
        <button type="button" style="background-color: rgb(255, 123, 0);" class="text-white text-center btn list-group-item list-group-item-action" data-toggle="collapse" data-target="#demo">Danh sách ứng dụng    <i class="fa fa-caret-down"></i></button>
        <div id="demo" class="collapse">
          <a href="index.php?developer=draft" style="background-color: white;" class="text-dark text-center list-group-item list-group-item-action"><span class="ml-4">Bản nháp</span></a>
          <a href="index.php?developer=approving" style="background-color: white;" class="text-dark text-center list-group-item list-group-item-action "><span class="ml-4">Đang chờ duyệt</span></a>
          <a href="index.php?developer=approved"  style="background-color: white;" class="text-dark text-center list-group-item list-group-item-action"><span class="ml-4">Đã được duyệt</span></a>
          <a href="index.php?developer=removed"  style="background-color: white;" class="text-dark text-center list-group-item list-group-item-action"><span class="ml-4">Đã gỡ</span></a>
          <a href="index.php?developer=denied"  style="background-color: white;" class="text-dark text-center list-group-item list-group-item-action"><span class="ml-4">Bị từ chối</span></a>
        </div>
        <a href="index.php?developer=uploadapp"  style="background-color: rgb(255, 123, 0);"class="text-white text-center list-group-item list-group-item-action">Đăng tải ứng dụng mới</a>
        <a href="index.php?developer=sellapp"  style="background-color: rgb(255, 123, 0);"class="text-white text-center list-group-item list-group-item-action">Xem đơn hàng</a>
      </div>
    </div>

    <!-- Page content -->
    <div class="content">
      <div class="container-fluid">
      <?php
          if(isset($_GET['developer'])){
              $index = $_GET['developer'];
          }
          else {
              $index = '';
          ?>
          <div style="display: flex;justify-content: center;align-items: center; height: 600px;">
            <img src="../img/logo.png" style="margin: auto; display: block; width: 30%;">
          </div>
          <?php
          }
          if ($index == 'draft'){     
              include("draft.php");
          }
          elseif($index == 'draftdetail' && isset($_GET["id"])){
            include("draftdetail.php");
          }
          if ($index == 'uploadapp'){     
            include("uploadapp.php");
          }
          if ($index == 'approving'){     
            include("approving.php");
          }
          elseif($index == 'approvingdetail' && isset($_GET["id"])){
            include("approvingdetail.php");
          }
          if ($index == 'approved'){     
            include("approved.php");
          }
          if ($index == 'denied'){
            include("deniedapp.php");
          }   
          if($index == 'removed'){
            include("removedapp.php");
          }
          if($index == 'sellapp'){
            include("sellapplist.php");
          }
          ?>   
      </div>
    </div>       
    <script src="../main.js"></script>
  </body>
</html>
