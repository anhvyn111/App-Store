<?php
    include("../config/connection.php");
    function test_input($data)
    {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
    }
    if(isset($_POST["register"])){
        if(!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['birthday']) || !isset($_POST['gender'])){
            $error = '<div class="alert alert-danger ">Đã xảy ra lỗi!</div>';
        }
        else{
            $name = $_POST["name"];
            $email = ($_POST["email"]);
            $password = md5($_POST["password"]);
            $birthday = ($_POST["birthday"]);
            $gender = ($_POST["gender"]);
            if($name == '' || $email == '' || $password == '' || $birthday =='' || $gender == ''){
                $error = '<div class="alert alert-danger ">Vui lòng nhập đầy đủ thông tin!</div>';

            }
            else{
                $emailVali = test_input($mail);
                    // check if e-mail address is well-formed
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $error = '<div class="alert alert-danger ">Email không đúng định dạng</div>';
                }
                else{
                    //Kiểm tra email đã có người dùng chưa
                    $querySelect = "SELECT * FROM account where email = '".$email."'";
                    $emailCheck = $conn->query($querySelect);
                    if($emailCheck->num_rows > 0){
                        $error = '<div class="alert alert-danger ">Email đã tồn tại!!</div>';
                    }
                }
            }
        }
        if(empty($error)){
            $addaccount ="INSERT INTO account(`name`, email, `password`, birthday, gender, cash, `status`) VALUES ('{$name}','{$email}','{$password}','{$birthday}','{$gender}', 0, 0)";
            if($conn->query($addaccount) == TRUE)
                echo '<script>alert("Đăng kí thành công.");
            window.location.href ="index.php?navstore=login";</script>';
            else{
                echo "Error: " . $addaccount . "<br>" . $conn->error;
            }                     
        }
    }
?>
<div class="container">
    <p class="text-left mt-2 mb-3">Đăng kí</p>
    <hr/>
    <div class="row justify-content-center">
        <div class="col-md-6 col-sm-10 mb-4 mt-5">
            <div class="form shadow border rounded p-3">
                <form action="" method="post">
                    <div class="text-center mb-4">
                        <img src="../img/logo.png" alt="Logo-Login" width = 70 height= 70></img>
                    </div> 
                    <div class="form-group">
                        <label for="first_name"> Họ và tên</label>
                        <div class="input-group mb-3">
                            <input id="name"type="text" name="name" class="form-control" placeholder="Họ và tên">
                                <div class="input-group-append"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh</label>
                        <div class="input-group mb-3">
                            <input type="date" id="birthday" name="birthday" class="form-control">
                        </div>
                        
                    </div>
                    <div class="form group">
                        <label for="gender">Giới tính</label>     
                    </div>
                    <div class="form-group text-center">
                        <div class="custom-control custom-radio custom-control-inline mr-2">
                            <input type="radio" class="custom-control-input" id="male" name="gender" value="Nam">
                            <label class="custom-control-label" for="male">Nam</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline ml-5">
                                <input type="radio" class="custom-control-input" id="female" name="gender" value="Nữ">
                                <label class="custom-control-label" for="female">Nữ</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email"> Email</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="email" placeholder="Email" name="email">
                        <div class="input-group-append"></div>
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password"  placeholder="Mật khẩu">
                    </div>
                    <div class="errorMessage my-3">
                        <?php
                            if(!empty($error)){
                                echo $error;
                            }
                        ?>  
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                        <button  style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-large btn-block text-white" name="register">Đăng kí</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>