<?php
    require("../config/connection.php");
    session_start();
    if(!isset($_SESSION['login'])){
        header('Location: index.php?navstore=login');
    }
    if(!isset($_GET['fileID'])){
        die("Vui lòng cung cấp file");
    }
    if(!isset($_SESSION['download_file'])){
        die("Không có nội dung để tải");
    }
    $id = $_GET['fileID'];
    $filePath = $_SESSION['download_file'][$id];
    if(!file_exists($filePath)){
        die("Ứng dụng không tồn tại");
    } 
    if(isset($_GET['type']) && $_GET['type'] == '0'){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("d-m-Y H:i:s");
        $stmt = $conn->prepare("INSERT INTO `freeapp_history`(`date`, ID_app, user) VALUES (?,?,?)");
        $stmt->bind_param("sis", $date, $_SESSION['AppID'], $_SESSION['login']);
        $result = $stmt->execute();
        echo "Thành công";
    }
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Disposition: attachment; filename="'.basename($filePath).'"');
    header('Content-Length: ' . filesize($filePath));
    header('Pragma: public'); 
    flush();  
    readfile($filePath);

    die();
?>