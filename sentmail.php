<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
function SentMailApproveApp($email, $name, $appName){
    require('vendor/autoload.php');
    $mail = new PHPMailer(true);                          
    try {
        $mail->CharSet = "UTF-8"; 
        $mail->SMTPDebug = 2;                              
        $mail->isSMTP();                                    
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                              
        $mail->Username = 'nguynanhvy@gmail.com';           
        $mail->Password = 'cygunwvrzeejrhtu';                                          
        $mail->Port = 587;                                     
        $mail->setFrom('nguynanhvy@gmail.com', 'NAV Store');
        $mail->addAddress($email, $name);    
        $mail->isHTML(true);                               
        $mail->Subject = 'Phê duyệt ứng dụng';
        $mail->Body    = 'Xin chức mừng, ứng dụng <b>'.$appName.'</b> của bạn đã được phê duyệt. Ứng dụng đang được hiển thị trên cửa hàng.';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    } 
}
function SentMailDenyApp($email, $name,$appName, $content){
    require('vendor/autoload.php');
    $mail = new PHPMailer(true);                          
    try {
        $mail->CharSet = "UTF-8"; 
        $mail->SMTPDebug = 2;                              
        $mail->isSMTP();                                    
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                              
        $mail->Username = 'nguynanhvy@gmail.com';           
        $mail->Password = 'cygunwvrzeejrhtu';                                          
        $mail->Port = 587;                                     
        $mail->setFrom('nguynanhvy@gmail.com', 'NAV Store');
        $mail->addAddress($email, $name);    
        $mail->isHTML(true);                               
        $mail->Subject = 'Phê duyệt ứng dụng';
        $mail->Body    = '<p>Rất tiếc, ứng dụng <b>'.$appName.'</b> của bạn đã bị từ chối.<br>Lí do: '.$content.'.</br></p>';
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    } 
}
function SentMailBuyApp($email, $name, $appName, $cost, $date){
    require('vendor/autoload.php');
    $mail = new PHPMailer(true);                          
    try {
        $mail->CharSet = "UTF-8"; 
        $mail->SMTPDebug = 2;                              
        $mail->isSMTP();                                    
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                              
        $mail->Username = 'nguynanhvy@gmail.com';           
        $mail->Password = 'cygunwvrzeejrhtu';                                          
        $mail->Port = 587;                                     
        $mail->setFrom('nguynanhvy@gmail.com', 'NAV Store');
        $mail->addAddress($email, $name);    
        $mail->isHTML(true);                               
        $mail->Subject = 'Mua ứng dụng';
        $mail->Body = "<p> Bạn đã mua thành công ứng dụng <b>".$appName."</b><br>Tên ứng dung: <b>".$appName."</b><br>Giá: <b>".$cost."</b><br>Ngày mua: ".$date."<br>Cảm ơn bạn đã tin tưởng và ủng hộ NAV Store!!!</p>";
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    } 
  }
  function SentRecoveryMailDenyApp($email, $name,$token){
    require('vendor/autoload.php');
    $mail = new PHPMailer(true);                          
    try {
        $mail->CharSet = "UTF-8"; 
        $mail->SMTPDebug = 2;                              
        $mail->isSMTP();                                    
        $mail->Host = 'smtp.gmail.com';  
        $mail->SMTPAuth = true;                              
        $mail->Username = 'nguynanhvy@gmail.com';           
        $mail->Password = 'cygunwvrzeejrhtu';                                          
        $mail->Port = 587;                                     
        $mail->setFrom('nguynanhvy@gmail.com', 'NAV Store');
        $mail->addAddress($email, $name);    
        $mail->isHTML(true);                               
        $mail->Subject = 'Khôi phục mật khẩu';
        $mail->Body    = "<p>Xin chào ".$name.",<br>Click vào <a href='http://adminnavstore.epizy.com/store/index.php?navstore=resetpassword&email=".$email."&token=".$token."'>đây</a><br>Cảm ơn bạn đã tin tưởng và ủng hộ NAV Store!!!</p>";
        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    } 
}
?>