<?php
    $appID = $_GET['id'];
    if(isset($_SESSION['login'])){
        $user = $_SESSION['login'];
    }
    if(isset($_POST['PostReview'])){
        if(!isset($_SESSION['login'])){
            header("Location: index.php?navstore=home");
        }
        else{
            $rating = $_POST['rating'];
            $ratingContent = $_POST['ratingContent'];
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $date = date("d-m-Y H:i:s");
            $stmt = $conn->prepare("UPDATE rating_app SET `date` = ?, content = ?, rate = ? WHERE ID_app = ? AND user = ?");
            $stmt->bind_param("ssiis", $date, $ratingContent, $rating, $appID, $user);
            if($stmt->execute()){
                echo("<meta http-equiv='refresh' content='2'>");
            }
            if($stmt->affected_rows == 0){
                $stmt = $conn->prepare("INSERT INTO rating_app(`date`, ID_app, content, rate, user) VALUES (?, ?, ? , ? , ?)");
                $stmt->bind_param("sisis", $date, $appID, $ratingContent, $rating, $user);
                if($stmt->execute()){
                    echo("<meta http-equiv='refresh' content='2'>");
                }
            }
        }
    }

    $sql = "SELECT ID, `name`,category, shortdes, detaildes, icon, DevID, price, app_file,
    (SELECT `name` FROM category WHERE category.ID = `application`.category) AS categoryName,
    (SELECT `name` FROM developer WHERE developer.ID = `application`.DevID) AS devname,
    (SELECT COUNT(ID_app) FROM  buyapp_history WHERE buyapp_history.ID_app = `application`.ID)  AS amountPaid,
    (SELECT COUNT(ID_app) FROM  freeapp_history WHERE freeapp_history.ID_app = `application`.ID)  AS amountFree
    FROM `application` WHERE ID = ".$_GET['id']." AND `status` = 'approved' LIMIT 1";
    $execute = mysqli_query($conn, $sql);
    if(mysqli_num_rows($execute) < 1){
        echo '<p class="text-center mt-3"> Ứng dụng không tồn tại.</p>';
    }
    else{
    $row = mysqli_fetch_assoc($execute);
    $appname = $row["name"];
    echo '<script> document.title = "'.$appname.'"</script>';
    $_SESSION['download_file'] = array();
    $uid = uniqid();
    $fileDir = '../uploads/application/appfiles/';
    $filePath = $fileDir.$row['app_file'];
    $_SESSION['download_file'][$uid] = $filePath;
    $_SESSION['AppID'] = $row['ID'];
?>
<div class="container-appdetail shadow border mt-5 mb-5">
    <div class="app-detail row mt-3">
        <div class="col-lg-3">
            <img src="../uploads/application/icon/<?php echo htmlspecialchars($row['icon'])?>" style = "width: 128px; height: 128px;"></img>
        </div>    
        <div class="col-lg-6 mt-2">
            <h4><?php echo htmlspecialchars($row["name"])?></h4>
            <a href="index.php?navstore=developer&id=<?php echo $row['DevID']?>" style="color: black;"><p><?php echo htmlspecialchars($row['devname'])?></p></a>
            <a href="index.php?navstore=category&id=<?php echo $row['category']?>" style="color: black;"><p><?php echo htmlspecialchars($row['categoryName'])?></p></a>
            <p>Dung lượng: <?php echo round(filesize($filePath)/1048576, PHP_ROUND_HALF_UP)?> MB</p>
            <?php
                if($row['price'] == 0){
            ?>
            <span class="fa fa-download">      <?php echo $row['amountFree']?> lượt tải về</span>
            <?php
                }
                else{
            ?>
            <span class="fa fa-user">      <?php echo $row['amountPaid']?> lượt mua</span>
            <?php
                }
            ?>
        </div>
        <div class="col-lg-3 align-self-lg-end">
            <?php
            if(isset($_SESSION["login"])){
                if($row['price'] > 0){
                    $id = $_SESSION['login'];
                    $sqlCheckApp = "SELECT * FROM `buyapp_history` WHERE ID_app = ".$_GET['id']." AND user = '".$id."'";
                    $executeCheckApp = mysqli_query($conn, $sqlCheckApp);
                    if($countCheckApp = mysqli_num_rows($executeCheckApp) <= 0){
            ?>
            <a type="button" id="btn-buyapp" href="index.php?navstore=buyapp&id=<?php echo htmlspecialchars($row['ID'])?>" class=" btn-download btn text-white btn-lg"><?php echo number_format($row['price'])?> VNĐ</a>
            <?php
                    }
                    else{
            ?>
            <a type="button" href="download.php?fileID=<?php echo htmlspecialchars($uid)?>" class=" btn-download btn text-white btn-lg">Tải về</a>
            <?php
                    }
                }
                else{
            ?>
            <a type="button" href="download.php?fileID=<?php echo htmlspecialchars($uid)?>&type=0" class=" btn-download btn text-white btn-lg">Tải về</a>
            <?php
                }
            }
            else
            {
                if($row['price'] > 0){
            ?>
                <a type="button" href="index.php?navstore=login" class=" btn-download btn text-white btn-lg"><?php echo number_format($row['price'])?> VNĐ</a>
            <?php
                }
                else
                {
            ?>
                <a type="button" href="index.php?navstore=login" class=" btn-download btn text-white btn-lg">Tải về</a>
            <?php
                } 
            }
            ?>
        </div>
    </div>
    <div style ="height: 25 rem;"class = "detail-img row flex-row flex-nowrap mt-5 ml-auto mr-auto">
    <?php
        $sqlImgApp = "SELECT * FROM app_img WHERE ID_app = ".$_GET['id']."";
        $executeImgApp = mysqli_query($conn, $sqlImgApp);
        while($rowImgApp = mysqli_fetch_assoc($executeImgApp))
        {
    ?>
        <div class="col-md-6 col-12 col-sm-12 col-lg-4 app-img">
            <img src="../uploads/application/detailimages/<?php echo htmlspecialchars($rowImgApp['name'])?>" alt="<?php echo htmlspecialchars($rowImgApp['ID'])?>"></img>
        </div>
        <?php
        }
        ?>
    </div>
    <div class="app-short-description mt-5 ml-3 mr-3">
        <p><b><?php echo str_replace("\n", "<br>", $row['shortdes'])?></b></p>
    </div>
    <div class="app-detail-description mt-2 ml-3 mr-3">
        <p> <?php echo substr(str_replace("\n", "<br>",$row['detaildes']), 0, 200).'<span id="dots">...</span><span id="more">'.substr(str_replace("\n", "<br>",$row['detaildes']), 200, strlen($row['detaildes']))?></span></p>
        <button class ="btn btn-success text-white" onclick="ReadMore()" id="myBtn">Đọc thêm</button>
    </div>
    <hr>
    <?php include("ratingapp.php");?>
</div>
<?php
    }
        $sql = "SELECT ID, `name`, icon, DevID, price  FROM `application` WHERE category = ".$row['category']." AND `status` = 'approved' AND ID != ".$row['ID']."";
        $execute = mysqli_query($conn, $sql);
        if(mysqli_num_rows($execute) > 0 ){
?>
<div class="container">
    <h5>Ứng dụng cùng thể loại</h5>
    <div class=" scrolling-wrapper row flex-row flex-nowrap mt-21 pb-4 pt-2">
            <?php

            while($rowApp = mysqli_fetch_assoc($execute)){
            ?>
            <div class="col-lg-2">
            <div class="card card-app p-2 shadow">
                <a href="index.php?navstore=appdetail&id=<?php echo htmlspecialchars($rowApp["ID"])?>"><img class= "card-img-top" src="../uploads/application/icon/<?php echo htmlspecialchars($rowApp["icon"])?>"  style="width: 140px; height: 130px;"></a>
                <div class="mt-2">
                    <h6><b><?php echo htmlspecialchars($rowApp["name"])?></b></h6>
                    <?php
                    $sqlDeveloper = "SELECT * FROM developer WHERE ID = ".$rowApp['DevID']."";
                    $executeDeveloper = mysqli_query($conn, $sqlDeveloper);
                    $rowDeveloper = mysqli_fetch_assoc($executeDeveloper);
                    ?>
                    <p class="card-publisher"><a href="index.php?navstore=developer&id=<?php echo $rowDeveloper['ID']?>" style="color: black;"><?php echo htmlspecialchars($rowDeveloper["name"])?></a></p>
                    <div class="inline-block">
                    <span class="fa fa-star checked card-rating float-left"> 3.5</span>
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
</div>
<?php
    }
    $sql = "SELECT ID, `name`, icon, DevID, price  FROM `application` WHERE DevID = ".$row['DevID']." AND `status` = 'approved' AND ID != ".$row['ID']."";
    $execute = mysqli_query($conn, $sql);
    if(mysqli_num_rows($execute) > 0 ){
?>
<div class="container">
    <h5>Ứng dụng cùng nhà phát triển</h5>
    <div class=" scrolling-wrapper row flex-row flex-nowrap mt-21 pb-4 pt-2">
            <?php

            while($rowApp = mysqli_fetch_assoc($execute)){
            ?>
            <div class="col-lg-2">
            <div class="card card-app p-2 shadow">
                <a href="index.php?navstore=appdetail&id=<?php echo htmlspecialchars($rowApp["ID"])?>"><img class= "card-img-top" src="../uploads/application/icon/<?php echo htmlspecialchars($rowApp["icon"])?>"  style="width: 140px; height: 130px;"></a>
                <div class="mt-2">
                    <h6><b><?php echo htmlspecialchars($rowApp["name"])?></b></h6>
                    <?php
                    $sqlDeveloper = "SELECT * FROM developer WHERE ID = ".$rowApp['DevID']."";
                    $executeDeveloper = mysqli_query($conn, $sqlDeveloper);
                    $rowDeveloper = mysqli_fetch_assoc($executeDeveloper);
                    ?>
                    <p class="card-publisher"><a href="index.php?navstore=developer&id=<?php echo $rowDeveloper['ID']?>" style="color: black;"><?php echo htmlspecialchars($rowDeveloper["name"])?></a></p>
                    <div class="inline-block">
                    <span class="fa fa-star checked card-rating float-left"> 3.5</span>
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
</div>
<?php
    }
?>
  <!--Add Rating Modal -->
  <div class="modal fade" id="modal-rating" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <form action ="" method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Đánh giá</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="rating-modal-body">
                <div class="row">
                    <label for="ratingContent">Nội dung: </label>
                    <textarea class="form-control" id="ratingContent-modal" rows="5" name="ratingContent"></textarea>
                </div>
                
                <div>
                    <label for="rating">Đánh giá: </label>
                    <div class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                        <input type="radio" id="star5" class="rating" name="rating" value="5" /><label for="star5" title="5 star"><span class="fa fa-star"></span></label>
                        <input type="radio" id="star4" class="rating" name="rating" value="4" /><label for="star4" title="4 star"><span class="fa fa-star"></span></label>
                        <input type="radio" id="star3" class="rating" name="rating" value="3" /><label for="star3" title="3 star"><span class="fa fa-star"></span></label>
                        <input type="radio" id="star2" class="rating" name="rating" value="2" /><label for="star2" title="2 star"><span class="fa fa-star"></span></label>
                        <input type="radio" id="star1" class="rating" name="rating" value="1" /><label for="star1" title="1 star"><span class="fa fa-star"></span></label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" id="btn-post-rating" name="PostReview">Đăng tải</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
            </div>
        </div> 
      </form>
    </div>
  </div>
