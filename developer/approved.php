
<div class="approved-list  mt-2">
    <h2>Danh sách ứng dụng được duyệt</h2>
    <hr>
    <table id="tb-draft" class="table table-hover mt-3 mr-auto ml-auto border rounded shadow">
        <form action="action.php" method="POST"> 
        <thead>
            <tr style="background-color: rgb(255, 123, 0);">
                <th class="tc-id">ID</th>
                <th style="width: 60%;">Tên ứng dụng</th>
                <th style="width: 30%;">Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("../config/connection.php");
                $sql = "SELECT * FROM `application` WHERE DevID = '".$devID."' AND `status` = 'approved'";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="tc-id"><?php echo $row["ID"]?></td>
                    <td><?php echo $row["name"]?></td>
                    <td><a class="btn btn-primary" href="index.php?developer=approvingdetail&id=<?php echo $row["ID"]?>">Chi tiết</a>
                    <a href="action.php?unpublishAppID=<?php echo $row['ID']?>" class="btn btn-danger text-white">Gỡ</a></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
        </form>
    </table>
    <div class="modal" tabindex="-1" role="dialog" id="unpublish-app-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gỡ ứng dụng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn gỡ ứng dụng này không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id ="confirm-unpublish">Xác nhận</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                </div>
            </div>
        </div>
    </div>
</div>
