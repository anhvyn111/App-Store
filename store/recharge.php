<?php
if(isset($_POST['recharge'])){      
        $seri = $_POST['seri'];
        $id =$_SESSION['login'];
        if($seri == ''){
            $error = '<div class="alert alert-danger ">Vui lòng nhập seri</div>';
        }
        else{
            $sqlCheckCode= "SELECT * FROM giftcode WHERE seri = '".$seri."' AND `status`= 1 LIMIT 1";
            $executeCheckCode = mysqli_query($conn, $sqlCheckCode);
            if($count = mysqli_num_rows($executeCheckCode) > 0){
                $rowGiftcode = mysqli_fetch_assoc($executeCheckCode);
                $cost = $rowGiftcode['cost'];
                $sqlRecharge = "UPDATE account SET cash = cash + $cost WHERE email = '".$id."'";
                $executeRecharge = mysqli_query($conn, $sqlRecharge);
                if($executeRecharge == TRUE){
                    $sql = "UPDATE giftcode SET  `status` = 0 WHERE seri = '".$seri."'";
                    if($execute = mysqli_query($conn, $sql)){
                        date_default_timezone_set('Asia/Ho_Chi_Minh');
                        $date = date("d-m-Y H:i:s");
                        $sql = "INSERT INTO `recharge_history`(`Date`, Seri, Cost, user) VALUES ('".$date."','".$seri."', $cost,'".$id."')";
                        if($execute = mysqli_query($conn, $sql)){
                            $error = '<div class="alert alert-success ">Bạn đã nạp thành công Mã Thẻ '.number_format($cost).'</div>';
                            echo("<meta http-equiv='refresh' content='2'>");
                        }
                        else{
                            echo("Error description: " . mysqli_error($conn));
                        }
                    }
                    else{
                        $error = '<div class="alert alert-danger ">Thất bại</div>';
                    }
                }
                else{
                    $error = '<div class="alert alert-danger ">Thất bại</div>';
                }
            }
            else{
                $error = '<div class="alert alert-danger ">Seri đã sử dụng hoặc không chính xác.</div>';
            }
        }
}
?>
<div class=" border p-3 rounded">
    <form action="" method="POST">
        <div class="text-center">
            <img src="../img/logo.png" alt="Logo-Login" width = 70 height= 70></img>    
            <h4 class="mt-3"><b>Nạp thẻ</b></h4>
        </div> 
        <div>
        <div class="form-group mt-5 mb-4">
            <label>Số seri:</label>
            <input type="text" class="form-control" id="recharge-seri" placeholder="Seri" name="seri">
        </div>
        <div class="errorMessage my-3">
            <?php
                if(!empty($error)){
                    echo $error;
                }
            ?>  
        </div>
        <div class="d-grid gap-2 col-6 mx-auto mt-4 mb-4 text-center">
            <button  class="btn text-white btn-lg btn-block" style="background-color: rgb(255, 123, 0);" type="submit" name="recharge" class="btn btn-default">Nạp</button>
        </div>
    </form>
</div>

 <!--Success Modal -->


