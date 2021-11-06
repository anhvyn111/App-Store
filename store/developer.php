<?php
    if(!isset($_GET['id']) || isset($_GET['id']) && $_GET['id'] == ""){
        echo "<p class='mt-3 text-center mb-3'> Vui lòng cung cấp id cần tìm</p>";
    }
    else{
        $devID = $_GET['id'];  
        $sql = "SELECT ID, `name`, icon, DevID, price, (SELECT AVG(rate) FROM rating_app WHERE rating_app.ID_app = `application`.ID) AS rate  FROM `application` WHERE DevID = ".$devID." AND `status` = 'approved'";
        $execute = mysqli_query($conn, $sql);
        if(mysqli_num_rows($execute) < 1 ){
            echo "<p class='mt-3 text-center mb-3'> Thể loại không tồn tại.</p>";    
        }
        else{
            $sqlCategory = "SELECT `name` FROM developer WHERE ID = $devID";
            $executeCategory = mysqli_query($conn, $sqlCategory);
            $rowCategory = mysqli_fetch_assoc($executeCategory);
?>

<div id="ranking" class="container mt-5 mb-5">
    <h3><b>Nhà phát triển: <?php echo $rowCategory['name']?></b></h3>
    <hr>
    <div class="row">
    <?php
          while($rowApp = mysqli_fetch_assoc($execute)){
        ?>
        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
          <div class="card card-app p-2 shadow">
              <a href="index.php?navstore=appdetail&id=<?php echo $rowApp["ID"]?>"><img class= "card-img-top" src="../uploads/application/icon/<?php echo $rowApp["icon"]?>"  style="width: 140px; height: 130px;"></a>
              <div class="mt-2">
                <h6><b><?php echo $rowApp["name"]?></b></h6>
                <?php
                  $sqlDeveloper = "SELECT * FROM developer WHERE ID = ".$rowApp['DevID']."";
                  $executeDeveloper = mysqli_query($conn, $sqlDeveloper);
                  $rowDeveloper = mysqli_fetch_assoc($executeDeveloper);
                ?>
                <p class="card-publisher"><a href="#" style="color: black;"><?php echo $rowDeveloper["name"]?></a></p>
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
        <?php
            }
        ?>
    </div>
</div>  
<?php
        }
    }
?>