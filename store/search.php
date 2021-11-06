<?php
    if(!isset($_GET['keyword']) || isset($_GET['keyword']) && $_GET['keyword'] == ""){
        echo "<p class='mt-3 text-center mb-3'> Vui lòng cung cấp từ khóa cần tìm</p>";
    }
    else{
        $keyword = $_GET['keyword'];  
        $sql = "SELECT ID, `name`, icon, DevID, price,(SELECT AVG(rate) FROM rating_app WHERE rating_app.ID_app = `application`.ID) AS rate, (SELECT `name` FROM developer WHERE developer.ID = `application`.DevID) AS devName FROM `application` WHERE `name` LIKE '%".$keyword."%' AND `status` = 'approved'";
        $execute = mysqli_query($conn, $sql);
        if(mysqli_num_rows($execute) < 1 ){
            echo "<p class='mt-3 text-center mb-3'> Không tìm thấy kết quả nào.<br>
            Hãy thử các từ khóa khác nhé!</p>";    
        }
        else{
?>

<div id="ranking" class="container mt-5 mb-5">
    <h3><b> Kết quả tìm kiếm: "<?php echo $keyword?>"</b></h3>
    <hr>
    <div class="row">
    <?php
          while($rowApp = mysqli_fetch_assoc($execute)){
        ?>
        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
          <div class="card card-app p-2 shadow">
              <a href="index.php?navstore=appdetail&id=<?php echo $rowApp["ID"]?>"><img class= "card-img-top" src="../uploads/application/icon/<?php echo $rowApp["icon"]?>"  style="width: 140px; height: 130px;"></a>
              <div class="mt-2">
                <h6 style="font-size: 14px;"><b><?php echo $rowApp["name"]?></b></h6>
                <h6 class="card-publisher" style="font-size: 12px;"><a href="index.php?navstore=developer&id=<?php echo $rowApp['DevID']?>" style="color: black;"><?php echo $rowApp["devName"]?></a></h6>
                <div class="inline-block">
                    <span class="fa fa-star checked card-rating"> <?php echo round($rowApp['rate'], PHP_ROUND_HALF_UP)?></span>
                    <?php
                        if($rowApp['price'] == 0){
                    ?>
                        <span style="font-size: 13px; float: right;">Miễn phí</span>
                    <?php
                        } 
                        else{
                    ?>
                        <span style="font-size: 13px; float: right;"><?php echo number_format(htmlspecialchars($rowApp['price']))?> VNĐ</span>

                    <?php
                        }
                    ?>
                </div>
              </div>
          </div>
        </div>
        <?php
            }
        ?>
    </div>
</div>  
<?php
        }
    }
?>