<?php
    if(isset($_POST['editInforUser'])){
        if(!isset($_POST['userName']) || !isset($_POST['userBirthday']) || !isset($_POST['userGender'])){
            $error = '<div class="alert alert-danger ">Vui lòng nhập đầy đủ thông tin.</div>';        
        }
        else{
            $userName = $_POST['userName'];
            $userBirthday = $_POST['userBirthday'];
            $userGender = $_POST['userGender'];
            if($userName == '' || $userBirthday == '' || $userGender == ''){
                $error = '<div class="alert alert-danger ">Vui lòng nhập đầy đủ thông tin.</div>';
            }
            else{
                $sql = "UPDATE account SET `name` = '".$userName."', birthday = '".$userBirthday."', gender = '".$userGender."'";
                if($execute = mysqli_query($conn, $sql)){
                    echo '<div class="alert alert-success">Cập nhật thông tin thành công!</div>';
                    echo("<meta http-equiv='refresh' content='1'>");
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
                        <label for="first_name"> Họ và tên</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($row['name'])?>" name="userName">
                                <div class="input-group-append"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="birthday">Ngày sinh</label>
                        <div class="input-group mb-3">
                            <input type="date" name="userBirthday" data-date-format="DD MMMM YYYY" value = '<?php echo $row['birthday']?>'class="form-control">
                        </div>
                        
                    </div>
                    <div class="form group">
                        <label for="gender">Giới tính</label>     
                    </div>
                    <div class="form-group text-center">    
                    <?php 
                        if($row["gender"]== 'Nam'){
                    ?>
                        <div class="custom-control custom-radio custom-control-inline mr-2">
                            <input type="radio" class="custom-control-input" id="male" name="userGender" value="Nam" checked>
                            <label class="custom-control-label" for="male">Nam</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline ml-5">
                            <input type="radio" class="custom-control-input" id="female" name="userGender" value="Nữ">
                            <label class="custom-control-label" for="female">Nữ</label>
                        </div>
                    <?php
                        }
                        else{
                    ?>
                        <div class="custom-control custom-radio custom-control-inline mr-2">
                            <input type="radio" class="custom-control-input" id="male" name="userGender" value="Nam">
                            <label class="custom-control-label" for="male">Nam</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline ml-5">
                            <input type="radio" class="custom-control-input" id="female" name="userGender" value="Nữ" checked>
                            <label class="custom-control-label" for="female">Nữ</label>
                        </div>
                    <?php   
                        }
                    ?>
                    </div>
                    <div class="errorMessage my-3">
                        <?php
                            if(!empty($error)){
                                echo $error;
                            }
                        ?>  
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                        <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="editInforUser">Cập nhật</button>
                    </div>
                </form>
</div>