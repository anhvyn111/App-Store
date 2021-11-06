<div class="container mb-3">
        <h4><b>Đánh giá</b></h4>
        <?php
        if(isset($user)){
            $executeMyRating = mysqli_query($conn, "SELECT `date`, content, rate, user,(SELECT `name` FROM account WHERE account.email = user) AS username , (SELECT avatar FROM account WHERE account.email = user) AS avatar FROM rating_app WHERE ID_app = $appID AND user ='".$user."'");
            $countMyRating = mysqli_num_rows($executeMyRating);
            if($countMyRating > 0){
                $rowMyRating = mysqli_fetch_assoc($executeMyRating);
        ?>
        <div>
            <h6 class="ml-4">Đánh giá của bạn</h6>
            <div class="row ml-5 mr-5">
                <?php
                if($rowMyRating['avatar'] == ''){
                ?>
                    <img class="rounded-circle mr-2" src="../img/user.png" width=50 height=50>
                <?php
                    }
                    else{
                ?>
                    <img class="rounded-circle mr-2" src="../uploads/user/avatar/<?php echo $rowMyRating['avatar']?>" width=50 height=50>
                <?php
                    }
                ?>
                <div class="ml-3">
                    <h6><b><?php echo $rowMyRating['username']?></b></h6>
                    <div class = "row ml-2">
                        <p><?php echo $rowMyRating['rate']?> <i class= "fa fa-star" style="color: #ffca08;"></i></p>
                        <p class="ml-3" style="font-size: 13px;"><?php echo $rowMyRating['date']?></p>
                    </div>
                </div>
                <div class="ml-auto">
                    <i class="btn fa fa-edit" data-toggle="modal" id="edit-rating" onclick="EditRating('<?php echo $rowMyRating['content']?>',<?php echo $rowMyRating['rate']?>)" data-target="#modal-rating"></i>
                </div>
            </div>
            <div class="row ml-5 mr-5">
                <div class="mr-2"></div>
                <p style="font-size: 15px;"><?php echo htmlspecialchars($rowMyRating['content'])?></p>
            </div>
        </div>
        <?php
            }
        }
            $sql = "SELECT `date`, content, rate, user,
            (SELECT `name` FROM account WHERE account.email = user) AS username, 
            (SELECT avatar FROM account WHERE account.email = user) AS avatar FROM rating_app WHERE ID_app = $appID ORDER BY ID DESC";
            $executeRating = mysqli_query($conn, $sql);
            $countRating = mysqli_num_rows($executeRating);
            if($countRating > 0){
                $executeRatingTotal = mysqli_query($conn, "SELECT AVG(rate)  AS ratingAVG, COUNT(ID) AS countUser FROM rating_app WHERE ID_app = $appID");
                $rowRatingTotal = mysqli_fetch_assoc($executeRatingTotal);
        ?>
        
        <div class="card text-center ml-auto mr-auto mb-5">
            <div class="card-header">
                <h4>Reviews</h4>
                <?php 
                    if( isset($countMyRating) && $countMyRating == 0){
                        if(isset($countCheckApp) && $countCheckApp > 0){

                        }
                        else{
                ?>
                <button type="button" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#modal-rating">
                    Đánh giá
                </button>
                <?php
                        }
                }
                ?>
            </div>
            <div class="card-body">
                <h3 class="card-title"><?php echo round($rowRatingTotal['ratingAVG'], PHP_ROUND_HALF_UP)?><i class="fa fa-star" style="color: #ffca08;"></i></h3>
                <p class="card-text"> <i class="fa fa-user"></i> <?php echo $rowRatingTotal['countUser']?> đánh giá</p>
            </div>
        </div>
        <?php
            while($rowRating = mysqli_fetch_assoc($executeRating)){
                    if(isset($rowMyRating) && $rowRating['user'] == $rowMyRating['user']){

                    }
                    else{
        ?>
            <div>
                <div class="row ml-5 mr-5 ">
                <?php    
                if($rowRating['avatar'] == ''){
                ?>
                    <img class="rounded-circle mr-2" src="../img/user.png" width=50 height=50>
                <?php
                    }
                    else{
                ?>
                    <img class="rounded-circle mr-2" src="../uploads/user/avatar/<?php echo $rowRating['avatar']?>" width=50 height=50>
                <?php
                    }
                ?>
                    <div class="ml-3">
                        <h6><b><?php echo $rowRating['username']?></b></h6>
                        <div class = "row ml-2">
                            <p><?php echo $rowRating['rate']?> <i class= "fa fa-star" style="color: #ffca08;"></i></p>
                            <p class="ml-3" style="font-size: 13px;"><?php echo $rowRating['date']?></p>
                        </div>
                    </div>
                </div>
                <div class="row ml-5 mr-5">
                    <div class="mr-2"></div>
                    <p style="font-size: 15px;"><?php echo htmlspecialchars($rowRating['content'])?></p>
                </div>
            </div>
        <?php
            }
        }
    }
    else{ 
    ?>
    <div class="text-center">
        <p> Chưa có đánh giá</p>
        <?php
        if(isset($user)){
            if(isset($countMyRating) && $countMyRating == 0){
                if(isset($countCheckApp) && $countCheckApp > 0){
                    //nothing
                }
                else{
        ?>
        <button type="button" class="btn btn-primary ml-auto" data-toggle="modal" data-target="#modal-rating">
            Đánh giá
        </button>
        <?php
        }
    }
}
        ?>
    </div>
    <?php
    }
        ?>
    </div>