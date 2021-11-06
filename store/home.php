<?php 
			if(isset($_GET['navstore']) && $_GET['navstore'] == 1){
				unset($_SESSION['login']);
			}
?>

<div class="container mt-5 mb-5"> 
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
      <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="../img/Lol.jpg" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="../img/Pubg.jpg" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="../img/Freefire.jpg" alt="Third slide">
      </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <?php
    $sqlCategory = "SELECT category, (SELECT `name` FROM category WHERE category.ID = `application`.category) AS `name`
     FROM `application` GROUP BY category";
    $executeCategory = mysqli_query($conn, $sqlCategory);
    while($rowCategory = mysqli_fetch_assoc($executeCategory)){
      $category = $rowCategory['category'];
      $sqlApp = "SELECT ID, icon, `name`, DevID, price,(SELECT AVG(rate) FROM rating_app WHERE rating_app.ID_app = `application`.ID) AS rate FROM `application` WHERE category = '".$category."' AND `status` = 'approved'";
      $executeApp = mysqli_query($conn, $sqlApp);
  ?>
  <div id="application" class="mt-5 mb-3">
    <div class="container-fluid">
      <div class="row">
        <h3 class="mr-auto"><img src="../img/application.png" width=35 height=35></img> <?php echo $rowCategory['name']?></h3>
        <a href="index.php?navstore=category&id=<?php echo $rowCategory['category']?>" style="color:rgb(255, 123, 0); font-size:17px;"><b>Xem thêm</b></a>  
      </div>
    <div class="scrolling-wrapper row flex-row flex-nowrap mt-21 pb-4 pt-2">
        <?php
          while($rowApp = mysqli_fetch_assoc($executeApp)){
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
                  <span class="fa fa-star checked card-rating float-left"> <?php echo round($rowApp['rate'], PHP_ROUND_HALF_UP)?></span>
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
  <hr>
  <?php
    }
  ?>
</div>
