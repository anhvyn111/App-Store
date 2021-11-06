<?php
     include("../config/connection.php");
     $sql = "SELECT * FROM `application` WHERE DevID = '".$devID."' AND `status` = 'draft'";
     $result = $conn->query($sql);
     if(isset($_GET["developer"]) && isset($_GET["id"])){
        $sqlAppId = "SELECT * FROM `application` WHERE DevID = '".$devID."' AND `status` = 'draft' AND ID = ".$_GET["id"]."";
        $resultCheckId = $conn->query($sql);
        if(mysqli_num_rows == 0){
        }
     }
?>


<div class="mt-2">
    <h2>Bản nháp</h2>
    <hr>
    <table id="tb-draft" class="table table-hover mt-3 mr-auto ml-auto border rounded shadow"> 
        <thead>
            <tr style="background-color: rgb(255, 123, 0);">
                <th>ID</th>
                <th style="width: 70%;">Tên ứng dụng</th>
                <th>Tùy chọn</th>
            </tr>
        </thead>
        <tbody>
            <?php
               
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr id="draft-id-<?php echo $row['ID']?>">
                    <td class="tc-id"><?php echo $row["ID"]?></td>
                    <td><?php echo htmlspecialchars($row["name"])?></td>
                    <td><a class="btn btn-primary mr-1" href="index.php?developer=draftdetail&id=<?php echo $row["ID"]?>">Bổ sung</a><button class="btn btn-danger" onclick="DeleteDraftID(<?php echo $row['ID']?>)">Xóa</button></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <div class="modal" tabindex="-1" role="dialog" id="delete-draft-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xóa bảng nháp</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Bạn có chắc muốn xóa bản nháp này không?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id ="btn-confirm-delete-draft">Xóa</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Không</button>
                </div>
            </div>
        </div>
    </div>
</div>