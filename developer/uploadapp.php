<?php
    if(isset($_POST["submit-upload"])){
        $name = $_POST["appname"];
        $category = $_POST["selectbox1"];
        $shortDes = $_POST["shortDes"];
        $detailDes = $_POST["detailDes"];
        $price= $_POST["price"];
        if($name != "" && $category != "" && $shortDes != "" && $detailDes != "" && $price != "" && $_FILES["appIcon"]["size"] != 0 && $_FILES['appImgList']['size'] != 0 && $_FILES["appfile"]["size"] != 0){
            $status = 'processing';
            $message="Ứng dụng đã được lưu thành công và đang được chờ duyệt";
        }
        else{
            $status = 'draft';
            $message="Ứng dụng đã được lưu thành công vào bản nháp";
        }
        $execute = mysqli_query($conn, "SELECT MAX(ID) AS MaxID FROM `application`");
        $row = mysqli_fetch_assoc($execute);
        $appID = $row['MaxID'] + 1;
        if(isset($_FILES["appIcon"])){
            $iconImg = pathinfo($_FILES["appIcon"]["name"], PATHINFO_EXTENSION);     
            if($_FILES["appIcon"]["size"] != 0){
                if($iconImg == 'png' || $iconImg == 'jpg' || $iconImg == 'jpeg'){
                    $fileName1 = time().".".$iconImg;
                    $targetFile1 = "../uploads/application/icon/" . $fileName1;
                    move_uploaded_file($_FILES["appIcon"]["tmp_name"], $targetFile1);
                }
                else{
                    $error = "Icon không đúng định dạng ảnh";
                }
            }
            else{
                $fileName1 = "";
            }
        }  
        if(isset($_FILES["appfile"])){
            if($_FILES["appfile"]["size"] != 0){
                $path = pathinfo($_FILES["appfile"]["name"], PATHINFO_EXTENSION);
                $appfileName = $appID.".".pathinfo($_FILES["appfile"]["name"], PATHINFO_EXTENSION);
                if($path != 'zip'){
                    $error = "File ứng dụng phải có dạng .zip";
                }
                elseif($_FILES["appfile"]["size"] >= 15*1048576){
                    $error = "File ứng dụng chỉ được tối đa 15MB";
                }
                else{
                    if(empty($error)){
                        $targetAppFile = "../uploads/application/appfiles/" . $appfileName;
                        move_uploaded_file($_FILES["appfile"]["tmp_name"],  $targetAppFile);
                    }
                }
            } 
            else{
                $appfileName = "";
            }  
        }  
        if(empty($error)){
           
            $query1 = "INSERT INTO `application`(`name`, category, shortdes, detaildes, icon , price, DevID, `status`, app_file) VALUES ('".$name."','".$category."','".$shortDes."','".$detailDes."','".$fileName1."',".$price.",".$devID.",'".$status."','".$appfileName."')";
            if(mysqli_query($conn, $query1) == TRUE){
                if(isset($_FILES["appImgList"])){
                    $id = mysqli_insert_id($conn);
                    if($_FILES['appImgList']['size'] != 0){
                        $fileName2 = time()."_".$id;
                        $targetFile2 = "../uploads/application/detailimages/" .$fileName2;
                            foreach($_FILES["appImgList"]["name"] as $key => $value){
                                if(move_uploaded_file($_FILES["appImgList"]["tmp_name"][$key],$targetFile2."_".$value)){
                                    mysqli_query($conn, "INSERT INTO app_img(`name`,`id_app`) VALUES('".$fileName2."_".$value."',".$id.")");
                            }   
                        }      
                    } 
                }   
                echo "<script>alert('".$message."');
                window.location.href ='index.php?developer=draft';</script>";
            }  
        }
        
    }
?>


<div class="uploadapp mt-2">
    <h2>Đăng tải ứng dụng</h2>
    <hr>
    <form class="p-3" action=""  method = "POST" enctype="multipart/form-data">
        <div class=" table-responsive">
            <div>
                <?php
                if(!empty($error)){
                    echo '<p class="text-danger"><b>'.$error.'</b></p>';
                }
                ?>
            </div>
            <table class="table">
                <tr>
                    <th>Tên ứng dụng:</th>
                    <td><input type="text" class="form-control" id="appname" name="appname"></td>
                </tr>
                <tr>
                    <th>Thể loại: </th>
                    <td>
                        <select class="form-control form-control-md" name="selectbox1">
                        <?php
                            $query ="SELECT * FROM category";
                            $result = mysqli_query($conn, $query);
                            
                            while($row = mysqli_fetch_assoc($result)){
                        ?>
                            <option value="<?php echo $row['ID']?>"><?php echo $row["name"]?></option>
                        <?php
                            }        
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Mô tả ngắn:</th>
                    <td><input type="text" class="form-control" id="desription-short" name="shortDes"></td>
                </tr>  
                <tr>
                    <th class="">Mô tả chi tiết:</th>
                    <td><textarea class="form-control" id="ta-detailDes" rows="4" name="detailDes"></textarea></td>
                </tr> 
                <tr>
                    <th>Icon ứng dụng:<br>(Định dạng .jpg hoặc .png hoặc .jpeg)</th>
                    <td><input type="file" id="icon-app" name="appIcon"></td>
                </tr>
                <tr>
                    <th>Ảnh ứng dụng (Screenshot):</th>
                    <td><input type="file" id="app-img-list" multiple="mutiple" name="appImgList[]"></td>
                </tr>
                
                <tr id="price">
                    <th>Giá bán:</th>
                    <td><input type="number" class="form-control" id="desription-short" name="price" value="0"></td>
                </tr>
                <tr>
                    <th>File cài đặt:<br>(Định dạng .zip, tối đa 15MB)</th>
                    <td><input type="file" id="desription-short" name="appfile"></td>
                </tr> 
                <tr>
                    <th></th>
                    <td>
                        <button  class="btn text-white btn-lg btn-block btn-success" style="width: 150px;" type="submit" class="btn btn-default" name="submit-upload">Xác nhận</button>
                    </td>
                </tr>   
            </table>
        </div>
    </form>
</div>