<?php 
    require("../sentmail.php");
    require('../config/connection.php');
    if(isset($_SESSION['login'])){
        echo '<script>alert("Bạn đã đăng nhập thành công tài khoản.");
        window.location.href ="../store/index.php?navstore=home";</script>';
    }
    if (isset($_POST['forgotpwd'])) {
        $email = $_POST['email'];
        $token = md5($email.'+'.random_int(1000,2000));
        $stmt =$conn->prepare("SELECT * FROM `account` WHERE email = ?");
        $stmt->bind_param("s", $email);
        if($stmt->execute()){
            $result = $stmt->get_result();
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                $row = mysqli_fetch_assoc($result);
                $exp = time() + 3600*24;
                $stmt =$conn->prepare("UPDATE reset_token SET token = ?, expire_on = ? WHERE email = ?");
                $stmt->bind_param("sis", $token, $exp, $email);
                if($stmt->execute()){
                    echo '<script>alert("Email khôi phục tài khoản đã được gửi đến '.$email.'");
                    window.location.href ="../store/index.php?navstore=forgotpassword";</script>';
                }
                if($stmt->affected_rows == 0){
                    $stmt =$conn->prepare("INSERT INTO reset_token VALUES(?,?,?)");
                    $stmt->bind_param("ssi", $email, $token, $exp);
                    if($stmt->execute()){
                        echo '<script>alert("Email khôi phục tài khoản đã được gửi đến '.$email.'");
                        window.location.href ="../store/index.php?navstore=forgotpassword";</script>';
                    }
                }
                SentRecoveryMailDenyApp($email, $row['name'], $token);
            } 
            else {
                $error = "Email không tồn tại!!";
            }
        }
        
    }
?>

<div class="container mt-2">
    <p class="text-left mt-2 mb-3">Quên mật khẩu</p>
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
                <div class="errorMessage my-3">
                    <?php
                        if(!empty($error)){
                            echo '<div class="alert alert-danger ">'. $error .'</div>';
                        }
                        if(!empty($success)){
                            echo '<div class="alert alert-success">'. $sucess .'</div>';
                        }
                    ?>  
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                    <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="forgotpwd">Tiếp tục</button>
                </div>    
            </form>
        </div>
    </div>
</div>