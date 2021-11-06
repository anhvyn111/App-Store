<?php
    require("../config/connection.php");
    require("../sentmail.php");
    //Add Category
    if(isset($_POST["categoryName"])){
        $categoryName = $_POST["categoryName"];
        $sql = "INSERT INTO category(`name`) VALUES ('".$categoryName."')";
        $execute = mysqli_query($conn, $sql);
        if($execute == TRUE){
            header("Location: index.php?admin=category");
        }     
    }
    if(isset($_POST["editCategoryName"])){
        $categoryID = $_POST["categoryID"];
        $editCategoryName = $_POST["editCategoryName"];
        $sql = "UPDATE category SET `name`='".$editCategoryName."' WHERE ID =".$categoryID."";
        $execute = mysqli_query($conn, $sql);
        if($execute == TRUE){
            header("Refresh: 2");
        }  
    }
    if(isset($_POST["deleteCategory"])){
        $categoryID = $_POST["deleteCategory"];
        $sql = "DELETE FROM category WHERE ID =".$categoryID."";
        $excute = mysqli_query($conn, $sql);
        if($execute == TRUE){
            header("Refresh: 0");
        }  
    }
    if(isset($_POST["acceptApproveApp"])){
        if(!isset($_POST["ApprovedID"])){
            echo "Co loi xay ra";
        }
        else{
            $id = $_POST["ApprovedID"];
            $sql = "UPDATE `application` SET `status` = 'approved' WHERE ID = ".$id."";
            $sql1 = "SELECT * FROM `application` WHERE ID = ".$id."";
            $execute1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_array($execute1);
            $sql2 = "SELECT * FROM `developer` WHERE ID = ".$row1['DevID']."";
            $execute2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_array($execute2);
            if($row1 == TRUE && $row2 == TRUE){
                $execute = mysqli_query($conn, $sql);   
                if($execute == TRUE){
                    header("Location: index.php?admin=approve");         
                    SentMailApproveApp($row2['per_email'], $row2['name'], $row1['name']); 
                }                     
            }
        }
    }
    if(isset($_POST["denyApproveApp"])){
        if(isset($_POST["ApprovedID"]) && isset($_POST["contentDenyApprove"]) && !empty($_POST["contentDenyApprove"])){
            
            $id = $_POST["ApprovedID"];
            $content = $_POST["contentDenyApprove"];
            $sql = "UPDATE `application` SET `status` = 'denied' WHERE ID = ".$id."";
            $sql1 = "SELECT * FROM `application` WHERE ID = ".$id."";
            $execute1 = mysqli_query($conn, $sql1);
            $row1 = mysqli_fetch_array($execute1);
            $sql2 = "SELECT * FROM `developer` WHERE ID = ".$row1['DevID']."";
            $execute2 = mysqli_query($conn, $sql2);
            $row2 = mysqli_fetch_array($execute2);
            if($row1 == TRUE && $row2 == TRUE){
                $execute = mysqli_query($conn, $sql);   
                if($execute == TRUE){
                    header("Location: index.php?admin=approve");
                    SentMailDenyApp($row2['per_email'], $row2['name'], $row1['name'], $content);         
                }                     
            }
        }
        else{
            echo '<script>alert("Đã xảy ra lỗi, vui lòng kiểm tra và thử lại");
            window.history.back();</script>';
        }
    }

    function generateRandomString($length, $characters) {
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    // Create Giftcode
    if(isset($_POST["amountGiftcode"]) && isset($_POST["costGiftcode"])){
        $amount = $_POST["amountGiftcode"];
        $cost = $_POST["costGiftcode"];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y H:i:s");
        $checkSeriExist = mysqli_query($conn, "SELECT * FROM giftcode");
        $row = mysqli_fetch_assoc($checkSeriExist);  
        $seri = generateRandomString(16,'0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
        for($i = 0; $i < $amount; $i++){
            do{
                $seri = generateRandomString(16,'0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
            } while($row["seri"] == $seri);  
            $sql = "INSERT INTO giftcode(`date`, seri, cost, `status`) VALUES ('".$date."','".$seri."',".$cost.", 1)";
            $execute = mysqli_query($conn, $sql);
            if($execute == FALSE){
                    echo "<alert>Đã có lỗi xảy ra</alert>";
            }   
        }
    }
?>