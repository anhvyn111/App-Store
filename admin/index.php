<!DOCTYPE html>
<html lang="en">
  <head>
    <link href = "../img/logo.png" rel="icon" type="image/gif">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Quản lý cửa hàng NAV</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Custom styles for this template -->
    <link href="../style.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  </head>
  <body>
    <?php
      require("../config/connection.php");
      session_start();
      if(isset($_SESSION["adminLogin"])){
        
      }
      else{
        header("Location: adminlogin.php");
      }
      if(isset($_GET['logout'])&& $_GET['logout']==1){
        unset($_SESSION['adminLogin']);
        header("Location: adminlogin.php");
    }
    ?>
    <div class="sidebar listgroup-admin">
      <div class="sidebar-heading-admin listgroup-admin">
        <div class="row justify-content-center mt-3">
          <img src="../img/logo.png" width="70" height="70" style=""></img>
        </div>
        <div class="row justify-content-center mt-3">
          <a class="ntext-dark border rounded btn text-white mb-3" id="bt-login" href="index.php?logout=1">Đăng xuất</a>
        </div>
      </div>
      <div class="list-group list-group-admin list-group-flush">
        <a href="index.php" class="list-group-item list-group-item-action listgroup-admin text-white text-center">Tổng quan</a>
        <a href="index.php?admin=category" class="list-group-item list-group-item-action text-white text-center listgroup-admin">Quản lí thể loại</a>
        <a href="index.php?admin=approve" class="list-group-item list-group-item-action text-white text-center listgroup-admin">Duyệt ứng dụng</a>
        <a href="index.php?admin=giftcode" class="list-group-item list-group-item-action text-white text-center listgroup-admin">Quản lí mã nạp</a>
      </div>
    </div>

    <!-- Page content -->
    <div class="content">
      <div class="container-fluid">
          <?php
          if(isset($_GET['admin'])){
              $index = $_GET['admin'];
          }
          else {
              $index = '';
              include("dashboard.php");
          }
          if ($index == 'category'){     
              include("category.php");
          }
          elseif ($index == 'giftcode'){     
            include("giftcode.php");
          }
          elseif ($index == 'approve'){     
            include("approve.php");
          }
          elseif ($index == 'approvedetail' && isset($_GET["id"]))
          {
            include("approvedetail.php");
          }
          ?>    
      </div>
    </div>
    <script src="../main.js"></script>
  </body>
</html>
