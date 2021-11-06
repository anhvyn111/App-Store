<?php
    require("../sentmail.php");
    if(!isset($_SESSION['login'])){
        header("Location: index.php?navstore=login");
    }
    if(!isset($_GET['id'])){
        echo "<p class='text-center mt-4'>Vui lòng cung cấp ID ứng dụng</p>";
    }
    elseif(isset($_GET['id'])){
        $appID = $_GET['id'];
        $user = $_SESSION['login'];
        $sql = "SELECT * FROM buyapp_history WHERE ID_app = $appID AND user = '".$user."'";
        $execute = mysqli_query($conn, $sql);
        if(mysqli_num_rows($execute) > 0){
            echo '<script>alert("Bạn đã mua ứng dụng này rồi.");
            window.location.href ="../store/index.php?navstore=home";</script>';
        }
        else{
            $sql = "SELECT * FROM `application` WHERE ID = $appID";
            $execute = mysqli_query($conn, $sql);
            $rowApp = mysqli_fetch_assoc($execute);
    }
    if(isset($_POST['comfirmBuy'])){
        if($row['cash'] < $rowApp['price']){
            $error = '<div class="alert alert-danger ">Số dư của bạn không đủ. Vui lòng nạp thêm.</div>';
        }
        else{
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("d-m-Y H:i:s");
            $sql = "INSERT INTO buyapp_history(`date`, ID_app, cost, user) VALUES ('".$date."', ".$appID.", ".$rowApp['price'].",'".$user."')";
            if($executeBuy = mysqli_query($conn, $sql)){
                $appPrice = $rowApp['price'];
                $sql = "UPDATE account SET cash = cash - $appPrice WHERE email = '".$user."'";
                if($execute = mysqli_query($conn, $sql) == TRUE){
                    SentMailBuyApp($user, $row['name'], $rowApp['name'], number_format($rowApp['price']), $date);
                    echo '<script>alert("Mua ứng dụng thành công !!");
                    window.location.href ="../store/index.php?navstore=appdetail&id='.$appID.'";</script>';
                }
            }
        }
    }
    
?>
<div class="container mt-2">
    <p class="text-left mt-2 mb-3">Mua ứng dụng</p>
    <hr/>
    <div class="row justify-content-center">
        <div class="col-md-6 mb-4">
            <form class="shadow border p-3 rounded" action=""  method = "POST">
                <div class="text-center">
                    <img class="rounded"src="../uploads/application/icon/<?php echo $rowApp['icon']?>" alt="Logo-Login" width = 70 height= 70></img>
                </div> 
                <div class="text-center mt-3">
                    <p>ID: <b><?php echo $rowApp['ID'] ?></b></p>
                </div>
                <div class="text-center">
                    <p>Ứng dụng: <b><?php echo $rowApp['name']?></b></p>
                </div>
                <div class="text-center">
                    <p>Giá: <b><?php echo number_format($rowApp['price'])?> VNĐ</b></p>
                </div>
                <div class="errorMessage my-3">
                    <?php
                        if(!empty($error)){
                            echo $error;
                        }
                    ?>  
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
                    <button  class="btn text-white btn-md btn-success" type="submit" class="btn btn-default" name="comfirmBuy">Mua</button>
                    <a type="submit" href="index.php?navstore=appdetail&id=<?php echo $rowApp['ID']?>" class="btn text-white btn-md " style="background-color: gray;" type="submit" class="btn btn-default" name="login">Trở về</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
    }
?>