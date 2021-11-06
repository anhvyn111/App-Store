<?php
    $queryApp = "SELECT * FROM `application` WHERE ID =".$_GET['id']." AND DevID = ".$devID." AND `status` = 'processing'";
    $excuteApp = mysqli_query($conn, $queryApp);
    $row = mysqli_fetch_array($excuteApp);
    if(mysqli_num_rows($excuteApp) < 1){
        echo "ID ứng dụng không tồn tại trong danh sách của bạn";
    }
    else{    
?>
<div class="uploadapp mt-2">
    <h2>Chi tiết ứng dụng chờ duyệt</h2>
    <hr>
    <div class="row justify-content-center table-responsive">
        <table style="width: 800px; height: 1100px;" class="mr-auto ml-auto table">
                <tr>
                    <th style="width: 200px;">ID ứng dụng:</th>
                    <td><label><?php echo $_GET["id"] ?></label></td>
                </tr>
                <tr>
                    <th>Tên ứng dụng:</th>
                    <td><?php echo $row["name"]?></td>
                </tr>
                <tr>
                    <th>Thể loại: </th>
                    <td>
                        <?php echo $row["category"]?>
                    </td>
                </tr>
                <tr>
                    <th>Mô tả ngắn:</th>
                    <td><?php echo $row["shortdes"]?></td>
                </tr>  
                <tr>
                    <th class="">Mô tả chi tiết:</th>
                    <td><pre><?php echo $row["detaildes"]?><pre></td>
                </tr> 
                <tr>
                    <th>Icon ứng dụng:</th>
                    <td>
                    <?php
                        if($row["icon"]!=""){
                    ?>
                    <div class="mb-2">
                    <img src="../uploads/application/icon/<?php echo $row['icon']?>" width="150px">
                    </div>
                    <?php
                    }
                    ?>
                </tr>
                <tr id = "draft-img-list">
                    <th>Ảnh ứng dụng (Screenshot):</th>
                    <td id="td-detail-img" style="height: 100px;">    
                    <?php
                        $sqlAppImg = "SELECT * FROM app_img WHERE ID_app = ".$_GET['id']."";
                        $exAppImg = mysqli_query($conn, $sqlAppImg);
                        if(mysqli_num_rows($exAppImg) > 0){
                            while($rowAppImg=mysqli_fetch_assoc($exAppImg)){
                    ?>
                        <div class="mt-2" id="imgID_<?php echo $rowAppImg['ID'] ?>">
                            <img class="card-img-top" src="../uploads/application/detailimages/<?php echo $rowAppImg["name"]?>" alt="Card image cap" style="width: 150px;">
                        <hr>
                        </div>   
                    <?php
                            }
                        }
                    ?>
                    </td>
                </tr>   
                <tr id="draft-price">
                    <th>Giá bán:</th>
                    <td><?php echo number_format($row["price"])?> VNĐ</td>
                </tr>
                <tr>
                <tr>
                    <th>File cài đặt:</th>
                    <td><a href="../uploads/application/appfiles/<?php echo $row["app_file"]?>">Click vào đây để tải về</a></td>
        </table>
    </div>
</div>
<?php
}
?>