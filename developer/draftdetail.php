
<?php
    function CheckAppInfo($conn, $id){
        //Load table application
        $sqlApp = "SELECT * FROM `application` WHERE ID = $id";
        $executeApp = mysqli_query($conn, $sqlApp);
        $rowApp = mysqli_fetch_assoc($executeApp);
        //Load table app_img
        $sqlAppImg = "SELECT * FROM `app_img` WHERE ID_app = ".$id."";
        $executeAppImg = mysqli_query($conn, $sqlAppImg);
        $countAppImg = mysqli_num_rows($executeAppImg);
        if($countAppImg > 0 && $rowApp["name"] != '' && $rowApp["category"] != '' && $rowApp["shortdes"] !='' && $rowApp["detaildes"] != '' && $rowApp["icon"] != '' && $rowApp["price"] != '' && $rowApp["app_file"] != ''){
            $sqlUpdateStatus = "UPDATE `application` SET `status` = 'processing' WHERE ID = ".$id."";
            $executeUpdateStatus = mysqli_query($conn, $sqlUpdateStatus); 
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
    if(isset($_POST["submit-draftdetail"])){   
        $appid = $_GET["id"];
        $name = $_POST["appname"];
        $category = $_POST["selectbox"];
        $shortDes = $_POST["shortDes"];
        $detailDes = $_POST["detailDes"];       
        $price = $_POST["price"];
        $status = 'draft'; 
        //Load Application data
        $sql = "SELECT * FROM `application` WHERE ID = ".$appid."";
        $execute = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($execute);
        //Upload Icon  
        if(isset($_FILES["appIcon"])){
            $iconImg = $_FILES["appIcon"]["name"];
            $path = pathinfo($_FILES["appIcon"]["name"], PATHINFO_EXTENSION);
            if($_FILES["appIcon"]["size"] != 0){
                if($path == 'png' || $path == 'jpg' || $path == 'jpeg'){
                    if(!empty($row1["icon"])){
                        unlink("../uploads/application/icon/".$row["icon"]);
                    }
                    $fileName1 = $appid.".".pathinfo($_FILES["appIcon"]["name"], PATHINFO_EXTENSION);
                    $targetFile1 = "../uploads/application/icon/" . $fileName1;
                    move_uploaded_file($_FILES["appIcon"]["tmp_name"], $targetFile1);
                    $UpdateIcon = mysqli_query($conn, "UPDATE `application` SET icon ='".$fileName1."' WHERE ID = $appid");
                }
                else{
                    $error = "Icon ứng dụng đã bị sai định dạng";
                }
               
            }
            else{
                $error = "File ứng dụng không phải định dạng .zip";
            }  
        }    
        //Upload App File
        if(isset($_FILES["appfile"]) &&  $_FILES["appfile"]["name"] != ''){
            $path = pathinfo($_FILES["appfile"]["name"], PATHINFO_EXTENSION);
            if($path != 'zip'){
                $error = "File ứng dụng không phải định dạng .zip";
            }
            elseif($_FILES["appfile"]["size"] >= 15*1048576){
                $error = "File ứng dụng chỉ được tối đa 15MB";
            }
            else{
                if(!empty($row1["app_file"])){
                    unlink("../uploads/application/appfiles/".$row["app_file"]);
                }
                $appfileName = $appid.".".pathinfo($_FILES["appfile"]["name"], PATHINFO_EXTENSION);
                $targetAppFile = "../uploads/application/appfiles/" . $appfileName;
                move_uploaded_file($_FILES["appfile"]["tmp_name"],  $targetAppFile);
                $UpdateAppFile = mysqli_query($conn, "UPDATE `application` SET app_file ='".$appfileName."' WHERE ID = $appid");
            }   
        } 
        if(empty($error)){
            //Upload App Images
            if(isset($_FILES["appImgList"]) && $_FILES['appImgList']['size'] != 0){
                $fileName2 = $appid."_".strtolower($name);
                $targetFile2 = "../uploads/application/detailimages/" .$fileName2;
                foreach($_FILES["appImgList"]["name"] as $key => $value){
                    if(move_uploaded_file($_FILES["appImgList"]["tmp_name"][$key],$targetFile2."_".$value)){
                            mysqli_query($conn, "INSERT INTO app_img(`name`,`id_app`) VALUES('".$fileName2."_".$value."',".$appid.")");
                    }
                }
            }
            $data = $price.$iconUpdate.$appfileUpdate;
            $query = "UPDATE `application` SET `name` = '".$name."', category = '".$category."', shortdes = '".$shortDes."', detaildes = '".$detailDes."', price = $price WHERE ID = $appid";
            if(mysqli_query($conn, $query) == TRUE){
                
                $updateStatus = CheckAppInfo($conn, $appid);
                if($updateStatus == TRUE){
                    echo "<script>alert('Ứng dụng đã được lưu và được chuyển danh sách đợi duyệt!');
                    window.location.href ='index.php?developer=approving';</script>";
                    }
                else{
                    echo "<script>alert('Ứng dụng đã được cập nhật thành công!');
                        window.location.href ='index.php?developer=draft';</script>";
                }
            }  
        }
    }    
    $queryApp = "SELECT ID, name, category, shortdes, detaildes, icon, screenshot, price, DevID, app_file,
    (SELECT `name` FROM category WHERE category.ID = `application`.category) AS nameCategory  FROM `application` WHERE ID =".$_GET["id"]." AND DevID = '".$devID."' AND `status` = 'draft'";
    $excuteApp = mysqli_query($conn, $queryApp);
    $row = mysqli_fetch_array($excuteApp);

    if(mysqli_num_rows($excuteApp) == 0){
        echo "ID ứng dụng không tồn tại trong danh sách của bạn";
    }
    else{
?>
<div class="uploadapp mt-2">
    <h2>Chi tiết bản nháp</h2>
    <hr>
    <div class="table-responsive">
        <div>
            <?php
            if(!empty($error)){
                echo '<p class="text-danger"><b>'.$error.'</b></p>';
            }
            ?>
        </div>
        <form class="p-3" action=""  method = "POST" enctype="multipart/form-data">
            <table class="table">
                <tr>
                    <th>ID ứng dụng:</th>
                    <td><label><?php echo $_GET["id"] ?></label></td>
                </tr>
                <tr>
                    <th>Tên ứng dụng:</th>
                    <td><input type="text" class="form-control" id="appname" name="appname" value ="<?php echo $row["name"]?>"></td>
                </tr>
                <tr>
                    <th>Thể loại: </th>
                    <td>
                        <select class="form-control form-control-md" name="selectbox">
                            <option value="<?php echo $row['category']?>"><?php echo $row["nameCategory"]?></option>
                            <hr>
                        <?php
                            require("../config/connection.php");
                            $query ="SELECT * FROM category WHERE `ID` != '".$row["category"]."'";
                            $result = mysqli_query($conn, $query);
                            
                            while($rowdata = mysqli_fetch_assoc($result)){
                        ?>
                            <option value="<?php echo $rowdata['ID']?>"><?php echo $rowdata["name"]?></option>
                        <?php
                            }        
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Mô tả ngắn:</th>
                    <td><input type="text" class="form-control" id="desription-short" name="shortDes" value ="<?php echo $row["shortdes"]?>"></td>
                </tr>  
                <tr>
                    <th class="">Mô tả chi tiết:</th>
                    <td><textarea class="form-control" id="ta-detailDes" rows="4" name="detailDes" value=""><?php echo $row["detaildes"]?></textarea></td>
                </tr> 
                <tr>
                    <th>Icon ứng dụng:<br>(Định dạng .jpg hoặc .png hoặc .jpeg)</th>
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
                    <input type="file" id="icon-app" name="appIcon"></td>
                </tr>
                <tr id = "draft-img-list">
                    <th>Ảnh ứng dụng (Screenshot):<br>(Định dạng .jpg hoặc .png hoặc .jpeg)</th>
                    <td id="td-detail-img" style="height: 100px;">    
                    <?php
                        $sqlAppImg = "SELECT * FROM app_img WHERE ID_app = ".$_GET['id']."";
                        $exAppImg = mysqli_query($conn, $sqlAppImg);
                        if(mysqli_num_rows($exAppImg) > 0){
                            while($rowAppImg=mysqli_fetch_assoc($exAppImg)){
                    ?>
                        <div class="mt-2" id="imgID_<?php echo $rowAppImg['ID'] ?>">
                            <img class="card-img-top" src="../uploads/application/detailimages/<?php echo $rowAppImg["name"]?>" alt="Card image cap" style="width: 150px;">
                            <button type="button" class="btn btn-danger link btn-draft-deleteimg" onclick="delete_img('<?php echo $rowAppImg['ID']?>','<?php echo $rowAppImg['name']?>')">Xóa</button>
                        <hr>
                        </div>
                        
                    <?php
                            }
                        }
                    ?>
                    <input type="file" id="app-img-list" multiple="mutiple" name="appImgList[]">
                    </td>
                </tr>   
                <tr id="draft-price">
                    <th>Giá bán:</th>
                    <td><input type="number" class="form-control" id="desription-short" name="price" value ="<?php echo $row["price"]?>"></td>
                </tr>
                <tr>
                <tr>
                    <th>File cài đặt:<br>(Định dạng .zip, tối đa 15MB)</th>
                    <?php 
                        if($row['app_file'] != ""){
                    ?>
                    <td>
                        <a href="../uploads/application/appfiles/<?php echo $row["app_file"]?>"><?php echo $row["app_file"] ?></a>
                        <input type="file" id="desription-short" name="appfile">
                    </td>
                    <?php      
                        }
                        else{
                    ?>
                    <td><input type="file" id="desription-short" name="appfile"></td>
                    <?php
                        }
                    ?>
                </tr> 
                    <th></th>
                    <td>
                        <button  class="btn text-white btn-lg btn-block btn-success" style="width: 150px;" type="submit" class="btn btn-default" name="submit-draftdetail">Xác nhận</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<?php
}
?>
