<?php
    $user = $_SESSION['login'];
    $sqlTrans = "SELECT * FROM recharge_history WHERE user = '".$user."'  ORDER BY ID DESC";
    $executeTrans = mysqli_query($conn, $sqlTrans);
?>
<table class="table table-hover mt-3 border rounded shadow table-responsive"> 
        <thead>
            <tr style="background-color: rgb(255, 123, 0);">
                <th style="width: 300px;">Ngày nạp</th>
                <th style="width: 300px;">Số seri</th>
                <th style="width: 400px;">Mệnh giá</th>
            </tr>
        </thead>
        <tbody>
            <?php
               
                while ($rowTrans = mysqli_fetch_assoc($executeTrans)) {
                ?>
                <tr>
                <td class="tc-id"><?php echo $rowTrans["Date"]?></td>

                    <td class="tc-id"><?php echo $rowTrans["Seri"]?></td>
                    <td><?php echo number_format($rowTrans["Cost"])?> VNĐ</td>
                </tr>
            <?php
                }
            ?>
        </tbody>
</table>
<?php
    if(mysqli_num_rows($executeTrans) < 1){
?>
        <p class="text-center">Bạn vẫn chưa có giao dịch mã nạp.</p>
<?php
    }
?>
