<?php
    if(isset($_POST['changePass'])){
        if(!isset($_POST['currentPass']) || !isset($_POST['newPass1']) || !isset($_POST['newPass2'])){
            $error = '<div class="alert alert-danger ">Vui lòng nhập đầy đủ thông tin.</div>';        
        }
        else{
            $currentPass=md5($_POST['currentPass']);
            $newPass1 = $_POST['newPass1'];
            $newPass2 = $_POST['newPass2'];
            $password = md5($newPass1);
            $email = $_SESSION['login'];
            if($currentPass == '' || $newPass1 == '' || $newPass2 == ''){
                $error = '<div class="alert alert-danger ">Vui lòng nhập đầy đủ thông tin.</div>';        
            }
            else{
                if($newPass1 != $newPass2){
                    $error = '<div class="alert alert-danger ">Mật khẩu mới không trùng nhau!</div>';        
                }
                elseif($currentPass != $row['password']){
                    $error = '<div class="alert alert-danger ">Sai mật khẩu hiện tại!</div>';        
                }
                elseif($newPass1 == $currentPass){
                    $error = '<div class="alert alert-danger ">Mật khẩu mới không được giống mật khẩu cũ!</div>';        
                }
                else{
                    $sql = "UPDATE account SET `password` = ? WHERE email = '".$email."'";
                    $stmt = $conn->prepare($sql) or die(mysqli_error());
                    $stmt->bind_param("s", $password);
                    if($stmt->execute()){
                        $result = $stmt->get_result();
                        echo '<script>alert("Cập nhật mật khẩu thành công!!")</script>';      
                    }
                }
            }
        }
    }
?>

<div class="form shadow border rounded p-3">
    <form action="" method="post">
        <div class="text-center mb-4">
            <img src="../img/logo.png" alt="Logo-Login" width = 70 height= 70></img>
        </div> 
        <div class="form-group">
            <label for="first_name"> Mật khẩu hiện tại:</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="currentPass">
                    <div class="input-group-append"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="first_name"> Mật khẩu mới:</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="newPass1">
                    <div class="input-group-append"></div>
            </div>
        </div> 
        <div class="form-group">
            <label for="first_name"> Nhập lại mật khẩu mới:</label>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="newPass2">
                    <div class="input-group-append"></div>
            </div>
        </div>   
        <div class="errorMessage my-3">
            <?php
                if(!empty($error)){
                    echo $error;
                }
            ?>  
        </div>
        <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
            <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="changePass">Xác nhận</button>
        </div>             
    </form>
</div>