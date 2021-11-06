
<!doctype html>
<html lang="en">
  <head>
    <link href = "../img/logo.png" rel="icon" type="image/gif">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>NAV Store</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
  </head>
  <body>
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	
	<?php
    session_start();
    if(!isset($_SESSION["login"])){
      header("Location: ../store/index.php?navstore=login");
    }
    require("../config/connection.php");
    $email = $_SESSION["login"];
    $cashCheck = mysqli_query($conn, "SELECT * FROM account WHERE email = '$email'");
    $row = mysqli_fetch_array($cashCheck);
    if($row["status"] == 1){
      echo '<script>alert("Bạn đã là nhà phát triển. Chọn OK để về trang chủ");
      window.location.href ="../store/index.php?navstore=home";</script>';
    }

      include("../store/navbar.php");
	?>
    <div class="container">
      <p class="text-left mt-2 mb-3">Nâng cấp nhà phát triển</p>
      <hr/>
      <div class="row justify-content-center">
          <div class="col-md-6 mb-4">
              <form class="shadow border p-3 rounded" action=""  method = "POST" enctype="multipart/form-data">
                  <div class="text-center">
                      <img src="../img/logo.png" alt="Logo-Login" width = 70 height= 70></img>
                      <h3 class="mt-2">Nâng cấp nhà phát triển</h3>
                  </div> 
                  <div class="form-group mt-5 mb-4">
                      <label for ="name">Tên nhà phát triển:</label>
                      <input type="text" class="form-control" id="name" placeholder="Tên nhà phát triển" name="name">
                  </div>
                  <div class="form-group">
                      <label for ="company-email">Email liên hệ:</label>
                      <input type="email" class="form-control" id="company-email" placeholder="Email" name="company-email">
                  </div>
                  
                  <div class="form-group">
                    <label for ="FrontImgFile">Ảnh chứng minh thư (Mặt trước):</label>
                    <div class="custom-file">
                      <input type="file" id="FrontImgFile" name="FrontImgFile">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for ="BackImgFile">Ảnh chứng minh thư (Mặt sau):</label>
                    <div class="custom-file">
                      <input type="file" id="BackImgFile" name="BackImgFile">
                    </div>
                  </div>
                  <div class="form-group text-center">
                      <label for ="company-email" style="font-size: 1.5rem;">Phí: <span style="color: green;">500.000 VND</span></label>
                  </div>
                  
                  <div class="errorMessage my-3">
                    <?php
                      if(isset($_POST['submit-upgrade'])){
                        $name = $_POST["name"];
                        $companyEmail = $_POST["company-email"];
                        $fileName1 = "uploads/developers/".$name."_1_".$_FILES["FrontImgFile"]["name"];
                        $fileName2 = "uploads/developers/".$name."_2_".$_FILES["BackImgFile"]["name"];
                        $targetFile1 = "../" . $fileName1;
                        $targetFile2 = "../" . $fileName2;
                        if($name == "" || $companyEmail == "" || $_FILES["FrontImgFile"]["size"] == 0 || $_FILES["BackImgFile"]["size"] == 0){
                          echo '<p style="color: red;" id ="error-Message">Vui lòng nhập đầy đủ thông tin, hình ảnh</p>';
                        }
                        else{
                          if($row["cash"] >= 500000){   
                              $sql = "INSERT INTO developer(name, com_email, front_img, back_img, per_email)
                                VALUES ('$name','".$companyEmail."', '$fileName1', '$fileName2', '$email')";
                              $excuteSql = mysqli_query($conn, $sql);
                              move_uploaded_file($_FILES["FrontImgFile"]["tmp_name"], $targetFile1);
                              move_uploaded_file($_FILES["BackImgFile"]["tmp_name"], $targetFile2);         
                              $amount = $row["cash"] - 500000;
                              $query="UPDATE `account` SET `status` = 1, `cash` = $amount WHERE email = '$email' ";
                              $updateStatus = mysqli_query($conn, $query);            
                              echo '<script>if(confirm("Nâng cấp thành công, click OK để về trang chủ.")) window.location = "../store/index.php?navstore=home";</script>';
                              header("../store/index.php");
                          }
                          else{
                            echo '<p style="color: red;" id ="error-Message">Bạn không đủ số dư trong tài khoản, vui lòng nạp thêm</p>';
                          }
                        }
                        
                        
                    ?>
                  </div>
                    <?php
                      }
                      $conn->close();
                    ?>
                    
                  
                  <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                      <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="submit-upgrade">Xác nhận</button>
                  </div>
              </form>
          </div>
      </div>
    </div>
    <?php 
		include("../store/footer.php");
	?>
  </body>
</html>