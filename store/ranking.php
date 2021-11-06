<?php
    $rankingID = $_GET['type'];
    if(!isset($_GET['type']) || isset($_GET['type']) && $_GET['type'] == ""){
        echo "<p class='mt-3 text-center mb-3'> Vui lòng cung cấp id cần tìm</p>";
    }
    if($rankingID == 'paid' || $rankingID == 'free'){
            if($_GET['type'] == 'paid'){
                $title = "Ứng dụng mua nhiều nhất";
                $sql = "SELECT ID_app,(SELECT `name` FROM `application` WHERE `application`.ID = `buyapp_history`.ID_app) AS `name`,
                 (SELECT `icon` FROM `application` WHERE `application`.ID = `buyapp_history`.ID_app) AS `icon`,
                (SELECT `DevID` FROM `application` WHERE `application`.ID = `buyapp_history`.ID_app) AS `DevID`,
                (SELECT `price` FROM `application` WHERE `application`.ID = `buyapp_history`.ID_app) AS `price`,
                (SELECT AVG(rate) FROM rating_app WHERE rating_app.ID_app = `buyapp_history`.ID_app) AS rate,
                 COUNT(ID_app) AS amount FROM  buyapp_history GROUP BY ID_app ORDER BY amount DESC";
                $execute = mysqli_query($conn, $sql);
            }
            elseif($rankingID == 'free'){
                $title = "Ứng dụng tải nhiều nhất";
                $sql = "SELECT ID_app,(SELECT `name` FROM `application` WHERE `application`.ID = `freeapp_history`.ID_app) AS `name`, 
                (SELECT `icon` FROM `application` WHERE `application`.ID = `freeapp_history`.ID_app) AS `icon`,
                (SELECT `DevID` FROM `application` WHERE `application`.ID = `freeapp_history`.ID_app) AS `DevID`,
                (SELECT `price` FROM `application` WHERE `application`.ID = `freeapp_history`.ID_app) AS `price`,
                (SELECT AVG(rate) FROM rating_app WHERE rating_app.ID_app = `freeapp_history`.ID_app) AS rate,
                 COUNT(ID_app) AS amount FROM  freeapp_history GROUP BY ID_app ORDER BY amount DESC";
                $execute = mysqli_query($conn, $sql);
            }
?>

<div id="ranking" class="container mt-5 mb-5">
    <h3><b><?php echo $title?></b></h3>
    <hr>
    <div class="row">
    <?php
          while($rowApp = mysqli_fetch_assoc($execute)){
        ?>
        <div class="col-6 col-sm-6 col-md-4 col-lg-2">
          <div class="card card-app p-2 shadow">
              <a href="index.php?navstore=appdetail&id=<?php echo $rowApp["ID_app"]?>"><img class= "card-img-top" src="../uploads/application/icon/<?php echo $rowApp["icon"]?>"  style="width: 140px; height: 130px;"></a>
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
    <?php
    }
    else{
        echo "Không tìm thấy id bạn cần tìm";
    }
    ?>
