<div class="approvinglist mt-2">
    <h2>Danh sách chờ duyệt</h2>
    <hr>
    <table id="tb-draft" class="table table-hover mt-3 mr-auto ml-auto border rounded shadow"> 
        <thead>
            <tr style="background-color: rgb(255, 123, 0);">
                <th>ID</th>
                <th>Tên ứng dụng</th>
                <th>Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("../config/connection.php");
                $sql = "SELECT * FROM `application` WHERE DevID = '".$devID."' AND `status` = 'processing'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row["ID"]?></td>
                    <td><?php echo $row["name"]?></td>
                    <td><a class="btn btn-primary" href="index.php?developer=approvingdetail&id=<?php echo $row["ID"]?>">Chi tiết</a></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
