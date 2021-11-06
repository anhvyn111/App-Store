<?php
    if(isset($_SESSION['login'])){
        echo '<script>alert("Bạn đã đăng nhập thành công tài khoản.");
        window.location.href ="../store/index.php?navstore=home";</script>';
    }
    else{
        if(isset($_GET['email']) && isset($_GET['token'])){
            $email = $_GET['email'];
            $token = $_GET['token'];
            $sql = "SELECT * FROM reset_token WHERE email = ? AND token = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $email, $token);
            if($stmt->execute()){
                $result = $stmt->get_result();
                if($count = mysqli_num_rows($result) < 1){
                    die("<p class='text-center mt-3'>Email hoặc token không đúng</p>");
                }
                else{
                    $exp = time();
                    $row = mysqli_fetch_assoc($result);
                    if($row['expire_on'] < $exp){
                        die("<p class='text-center mt-3'>Phiên đã hết hạn.</p>");
                    }
                    else{
                        $sql ="SELECT `name`,avatar FROM account WHERE email = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $email);
                        if($stmt->execute()){
                            $result = $stmt->get_result();
                            $row = mysqli_fetch_assoc($result);   
                        }    
                }        
?>
<div class="container mt-2">
        <p class="text-left mt-2 mb-3">Khôi phục mật khẩu</p>
        <hr/>
        <div class="row justify-content-center">
            <div class="col-md-6 mb-4">
                <form class="shadow border p-3 rounded" action=""  method = "POST">
                    <div class="text-center">
                        <img class = "rounded-circle" src="../uploads/user/avatar/<?php echo $row['avatar']?>" alt="Logo-Login" width = 100 height= 100></img>
                        <h5 class = "mt-3"><b><?php echo $row['name']?></b></h5>
                    </div> 
                    <div class="form-group mt-5">
                        <label>Mật khẩu mới:</label>
                        <input type="password" class="form-control" id="email" placeholder="Nhập mật khẩu mới" name="password">
                    </div>
                    <div class="form-group mb-4">
                        <label>Nhập lại mật khẩu:</label>
                        <input type="password" class="form-control" id="email" placeholder="Nhập lại mật khẩu" name="confirmpassword">
                    </div>
                    <div class="errorMessage my-3">
                        <?php
                            if(!empty($error)){
                                echo '<div class="alert alert-danger">'. $error .'</div>';
                            }
                        ?>  
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                        <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="resetpwd">Xác nhận</button>
                    </div>  
                </form>
            </div>
        </div>
    </div>
<?php
            }
        }
    }

    else{
        die("<p class='text-center mt-3'>Vui lòng cung cấp đầy đủ email và token!</p>");
    }
    if(isset($_POST['resetpwd'])){
        $newPass1 = $_POST['password'];
        $newPass2 = $_POST['confirmpassword'];
        if($newPass1 != $newPass2){
            $error = "Mật khẩu không trùng khớp. Vui lòng nhập lại.";
        }
        else{
            $newPass = md5($newPass2);
            $sql = "UPDATE account SET `password` = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $newPass, $email);
            if($stmt->execute()){
                $sql = "DELETE FROM reset_token WHERE email = ? AND token = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $token);
                if($stmt->execute()){
                    echo '<script>alert("Mật khẩu đã cập nhật thành công.<br>Chọn OK để vào trang đăng nhập");
                    window.location.href ="../store/index.php?navstore=login";</script>';
                }
            }
        }
    }
}
?>
    

