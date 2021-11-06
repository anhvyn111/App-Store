<?php 
    if(isset($_POST['login'])){   
            include("../config/connection.php");
            
            if(empty($_POST["email"])){
                $error = "Vui lòng nhập email";
            }
            elseif(empty($_POST["password"])){
                $error = "Vui lòng nhập mật khẩu";
            }
            else{
                $email = $_POST["email"];
                $password = md5($_POST["password"]);
                $stmt = $conn->prepare("SELECT * FROM account WHERE email = ? AND password = ? LIMIT 1") or die(mysqli_error());
                $stmt->bind_param("ss", $email, $password);
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    $count = $result->num_rows;
                    $getData = mysqli_fetch_assoc($result);
                    if($count>0){
                        echo "Đăng nhập thành công";
                        $_SESSION['login'] = $getData["email"];
                        header('Location: index.php?navstore=home');   
                    }
                    else{
                        $error="Email hoặc mật khẩu không chính xác.";
                    }
                    $conn->close();
                }
        }     
    }
    if(isset($_SESSION['login'])){
        echo '<script>alert("Bạn đã đăng nhập tài khoản!");
        window.location.href ="index.php?navstore=home";</script>';
    }
    else{
?>
<div class="container mt-2">
    <p class="text-left mt-2 mb-3">Đăng nhập</p>
    <hr/>
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <form class="shadow border p-3 rounded" action=""  method = "POST">
                <div class="text-center">
                    <img src="../img/logo.png" alt="Logo-Login" width = 70 height= 70></img>
                </div> 
                <div class="form-group mt-5 mb-4">
                    <input type="text" class="form-control" id="email" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="password" placeholder="Mật khẩu" name="password">
                </div>
                <div class="errorMessage my-3">
                    <?php
                        if(!empty($error)){
                            echo '<div class="alert alert-danger ">'. $error .'</div>';
                        }
                    ?>  
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                    <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="login">Đăng nhập</button>
                </div>
                <div>
				    <div class="d-flex justify-content-center links">
					    Chưa có tài khoản?<a href="index.php?navstore=register">Đăng kí ngay</a>
				    </div>
				    <div class="d-flex justify-content-center">
					    <a href="index.php?navstore=forgotpassword">Quên mật khẩu?</a>
				    </div>
			    </div>
            </form>
        </div>
    </div>
</div>
<?php
    }
?>