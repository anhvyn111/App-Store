<?php
    $user = $_SESSION['login'];
    $sqlTrans = "SELECT `date`,ID_app, cost,(SELECT `name` FROM `application` WHERE `application`.ID = buyapp_history.ID_app) AS nameApp  FROM buyapp_history WHERE user = '".$user."'  ORDER BY ID DESC";
    $executeTrans = mysqli_query($conn, $sqlTrans);
?>
<table class="table table-hover mt-3 border rounded shadow table-responsive"> 
        <thead>
            <tr style="background-color: rgb(255, 123, 0);">
                <th style="width: 300px;">Ngày mua</th>
                <th style="width: 300px;">Tên ứng dụng</th>
                <th style="width: 400px;">Giá mua</th>
            </tr>
        </thead>
        <tbody>
            <?php
               
                while ($rowTrans = mysqli_fetch_assoc($executeTrans)) {
                ?>
                <tr>
                <td class="tc-id"><?php echo $rowTrans["date"]?></td>

                    <td class="tc-id"><?php echo $rowTrans["nameApp"]?>(<?php echo $rowTrans['ID_app']?>)</td>
                    <td><?php echo number_format($rowTrans["cost"])?> VNĐ</td>
                </tr>
            <?php
                }
            ?>
        </tbody>
</table>
<?php
    if(mysqli_num_rows($executeTrans) < 1){
?>
        <p class="text-center">Bạn vẫn chưa có giao dịch mua ứng dụng.</p>
<?php
    }
?>
