
<div class="approve mt-2">
    <h2>Duyệt ứng dụng</h2>
    <hr>
    <table class="table table-hover mt-3 mr-auto ml-auto border rounded shadow" style="width: 80%"> 
        <thead>
            <tr style="background-color: rgb(255, 123, 0);">
                <th class="tc-id" style="width: 100px;">ID</th>
                <th style="width: 700px;">Tên ứng dụng</th>
                <th style="width: 120px;">Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("../config/connection.php");
                $sql = "SELECT * FROM `application` WHERE `status` = 'processing'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="tc-id"><?php echo htmlspecialchars($row["ID"])?></td>
                    <td><?php echo htmlspecialchars($row["name"])?></td>
                    <td><a class="btn btn-primary" href="index.php?admin=approvedetail&id=<?php echo $row["ID"]?>">Chi tiết</a></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
