<?php
    session_start();
    require("../config/connection.php");
    if(isset($_POST["deleteImgID"])){
        $id = $_POST["deleteImgID"];
        $name = $_POST["name"];
        $sqlDeleteImgID ="DELETE FROM app_img WHERE ID = ".$id." AND name ='".$name."'";
        $resultDeleteImg = mysqli_query($conn, $sqlDeleteImgID);
        if($resultDeleteImg == TRUE){
            unlink("../uploads/application/detailimages/".$name);
        }
    }
    // Delete Draft ID
    if(isset($_POST["deleteDraftID"])){
        $draftID = $_POST["deleteDraftID"]; 
        $sqlDeteleDraftID = "DELETE FROM `application` WHERE ID = ".$draftID."";
        $resultDeleteDraft = mysqli_query($conn, $sqlDeteleDraftID);
        $checkImgList = mysqli_query($conn, "SELECT * FROM app_img WHERE ID_app = ".$draftID."");
        if(mysqli_num_rows($checkImgList) > 0){
            while ($rowImgList = mysqli_fetch_array($checkImgList)){
                unlink('../'.$row["name"]);
            }
        }
    }
    if(isset( $_SESSION['Dev']) && isset($_GET['unpublishAppID'])){
        $devID =  $_SESSION['Dev'];
        $appID = $_GET['unpublishAppID'];
        $execute = mysqli_query($conn, "SELECT * FROM `application` WHERE DevID = $devID AND ID = $appID");
        if(mysqli_num_rows($execute) < 1){
            echo '<script>alert("Ứng dụng không nằm trong danh sách của bạn");
         window.location.href ="../store/index.php?navstore=home";</script>';
        }
        else{
            $stmt= $conn->prepare("UPDATE `application` SET `status` = 'removed' WHERE ID = ?");
            $stmt->bind_param("s", $appID);
            if($stmt->execute()){
                header("Location: index.php?developer=approved");
            }
        }
    }
    if(isset( $_SESSION['Dev']) && isset($_GET['publishAppID'])){
        $devID =  $_SESSION['Dev'];
        $appID = $_GET['publishAppID'];
        $execute = mysqli_query($conn, "SELECT * FROM `application` WHERE DevID = $devID AND ID = $appID");
        if(mysqli_num_rows($execute) < 1){
            echo '<script>alert("Ứng dụng không nằm trong danh sách của bạn");
         window.location.href ="../store/index.php?navstore=home";</script>';
        }
        else{
            $stmt= $conn->prepare("UPDATE `application` SET `status` = 'approved' WHERE ID = ?");
            $stmt->bind_param("s", $appID);
            if($stmt->execute()){
                header("Location: index.php?developer=removed");
            }
        }
    }
?>
