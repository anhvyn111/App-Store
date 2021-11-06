<?php
    if(isset($_POST['recharge'])){
        if(isset($_POST['seri'])){
            
        }
    }
    if(!isset($_SESSION['login'])){
        
        header("Location: index.php?navstore=login");
    }
    if(isset($_POST['editAvatar'])){
        if(isset($_FILES["avatarFile"])){
            if($_FILES["avatarFile"]["name"] != ''){
                $fileName = $row['id']."_".$_FILES["avatarFile"]["name"];
                $targetFile = "../uploads/user/avatar/" . $fileName;
                if($row['avatar'] != ""){
                    unlink("../uploads/user/avatar/".$row['avatar']);
                }
                move_uploaded_file($_FILES["avatarFile"]["tmp_name"],  $targetFile);
                $email = $_SESSION['login'];
                $sql = "UPDATE account SET avatar = '".$fileName."' WHERE email = '".$email."'";
                if($execute = mysqli_query($conn, $sql) == TRUE){
                    echo("<meta http-equiv='refresh' content='0'>");
                } 
            }    
        }       
        else{
            echo "Lỗi";
        }
    }
?>
<div class="container mt-2">
    <div class="row justify-content-center mt-5 mb-4">
        <div class="col-md-3 mt-2 border rounded">

            <div class="text-center mt-4">
                <form action ="" method='post' enctype="multipart/form-data">

            <?php
                if($row['avatar'] == ''){
            ?>
                    <input type="image" class="rounded-circle" src="../img/user.png" alt="Logo-Login" width = 70 height= 70> 

            <?php
                }
                else
                {
            ?>
                    <input type="image" class="rounded-circle" src="../uploads/user/avatar/<?php echo $row['avatar']?>" alt="Logo-Login" width = 70 height= 70/> 
            <?php
                }
            ?>
                    <div class = "mt-2 mb-2 ml-2 mr-2">
                        <input type="file" id='avatar-file' name="avatarFile"> 
                    </div>
                    <div> 
                        <button  class="btn text-white btn-sm" style="background-color: rgb(255, 123, 0);" type="submit" class="btn btn-default" name="editAvatar">Cập nhật</button>
                    </div>
                </form>

                    <h5 class = "mt-3"><b>ID: <?php echo $row['id']?></b></h5>
                    <h4 class="mt-1 mb-3"><b><?php echo htmlspecialchars($row['name'])?></b></h4>
            </div> 
            <hr>
            <a class="btn w-100 p-2" href='index.php?navstore=profile&action=infor'>Thông tin tài khoản</a>
            <hr>
            <a class="btn w-100 p-2" href='index.php?navstore=profile&action=changepassword'>Đổi mật khẩu</a>
            <hr>
            <a class="btn w-100 p-2" href='index.php?navstore=profile&action=buyhistory'>Ứng dụng đã mua</a>
            <hr>
            <a class="btn w-100 p-2"href='index.php?navstore=profile&action=recharge'>Nạp thẻ</a>
            <hr>
            <a class="btn w-100 p-2"href='index.php?navstore=profile&action=rechargetransaction'>Lịch sử nạp thẻ</a>
        </div>
        <div class="col-md-9 mt-2">
        <?php
            if($_GET['action'] == 'recharge'){
                include("recharge.php");
                echo '<script> document.title = "Nạp thẻ"</script>';
            }
            elseif($_GET['action'] == 'infor'){
                include("infor.php");
                echo '<script> document.title = "Thông tin tài khoản"</script>';

            }
            elseif($_GET['action'] == 'buyhistory'){
                include("buyhistory.php");
                echo '<script> document.title = "Lịch sử mua ứng dụng"</script>';
            }
            elseif($_GET['action'] == 'rechargetransaction'){
                include("rechargetransaction.php");
                echo '<script> document.title = "Lịch sử nạp thẻ"</script>';

            }
            elseif($_GET['action'] == 'changepassword'){
                include("changepassword.php");
                echo '<script> document.title = "Đổi mật khẩu"</script>';
            }
        ?>
        </div>
    </div>

</div>