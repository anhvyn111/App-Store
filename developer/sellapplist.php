<?php
     include("../config/connection.php");
     
     if(isset($_GET["developer"])){
        $sql = "SELECT date, `name`, cost, user, DevID FROM `buyapp_history` INNER JOIN `application` ON  `application`.`ID` = `buyapp_history`.`ID_app`  AND DevID = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $devID);
        if($stmt->execute()){
            $result = $stmt->get_result();
        } 
     }
?>


<div class="mt-2">
    <h2>Xem đơn hàng</h2>
    <hr>
        <table id="tb-draft" class="table table-hover mt-3 mr-auto ml-auto border rounded shadow table-responsive-lg"> 
            <thead>
                <tr style="background-color: rgb(255, 123, 0);">
                    <th>Thời gian</th>
                    <th>Tên ứng dụng</th>
                    <th>Người mua</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                <?php
                        while($rowBuyApp = $result->fetch_assoc()){
                ?>
                    <tr>
                        <td><?php echo $rowBuyApp["date"]?></td>
                        <td><?php echo $rowBuyApp['name']?></td>
                        <td><?php echo $rowBuyApp["user"]?></td>
                        <td><?php echo number_format($rowBuyApp['cost'])?> VNĐ</td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
</div>