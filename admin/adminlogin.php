

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
  <body style="background-color: rgb(255, 123, 0);">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<?php
        if (!empty( $_SESSION['adminLogin'] ) ) {
            header('Location:index.php');
            exit;
        }
    ?>
    <section id="cover" >
        <div id="cover-caption" >
            <div id="container" class="container">
                <div class="row">
                    <div class="col-sm-10 offset-sm-1 text-center">
                        <h1 class="display-3 mt-5 text-white">QUẢN LÝ NAV STORE</h1>
                        <div class="row justify-content-center mt-5">
                            <div class="col-md-6 mb-4">
                                <form class="shadow border p-3 rounded" style="background-color: white" action=""  method = "POST">
                                    <div class="text-center">
                                        <img src="../img/logo.png" alt="Logo-Login" width = 70 height= 70></img>
                                    </div> 
                                    <div class="form-group mt-5     mb-4">
                                        <input type="text" class="form-control" id="username" placeholder="Tên đăng nhập" name="username">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" id="password" placeholder="Mật khẩu" name="password">
                                    </div>
                                    <div class="errorMessage my-3">
                                    <?php
                                        session_start();
                                        if(isset($_POST['adminLogin'])){
                                                require("../config/connection.php");
                                                $username = $_POST['username'];
                                                $password = $_POST['password'];
                                                $stmt = $conn->prepare("SELECT * FROM `admin` WHERE username = ? and `password` = ?");
                                                $stmt->bind_param("ss", $username, $password);
                                                if($stmt->execute()){
                                                    $result = $stmt->get_result();
                                                    $num_rows = mysqli_num_rows($result);
                                                }
                                                if($num_rows > 0){
                                                echo "Success";
                                                $_SESSION['adminLogin'] = $_POST['username'];
                                                header("Location: index.php");
                                                }
                                                else{
                                                echo '<p style="color: red">Tài khoản hoặc mật khẩu không chính xác</p>';
                                                }
                                        }  
                                    ?>
                                    </div>
                                    <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                                        <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="adminLogin">Đăng nhập</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
	
  </body>
</html>

