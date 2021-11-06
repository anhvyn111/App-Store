<div class="giftcode mt-2">
    <h2>Quản lí mã nạp</h2>
    <hr>    
    <div>
        <h4>Tạo mã nạp</h4>
    
        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Số lượng:</label>
            <div class="col-sm-6">
                <input type="number" style="width: 50%;" id ="amount-giftcode" class="form-control" name ="amount">
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Mệnh giá:</label>
            <div class="col-sm-6">
                <select class="form-control" style="width: 50%;" id ="cost-giftcode">
                    <option value="50000">50,000 VNĐ</option>
                    <option value="100000">100,000 VNĐ</option>
                    <option value="200000">200,000 VNĐ</option>
                    <option value="500000">500,000 VNĐ</option>
                </select>
            </div>
            <div class="col-sm-4"></div>
        </div>
        <div class="form-group row ml-3">
            <div class="col-sm-2"></div>
            <div class="col-sm-4">
                <button class="btn btn-success" type="submit" style="width: 5rem;" onclick="CreateGiftcode()">Tạo</button>
            </div>
        </div>
    </div>
    <div class="alert alert-danger" id="alert-error-gifcode" role="alert">
        Đã có lỗi xảy ra, vui lòng kiểm tra lại số lượng và mệnh giá!
    </div>
    <table class="table table-hover mt-3 mr-auto ml-auto border rounded shadow"> 
        <thead>
            <tr style="background-color: rgb(255, 123, 0);">
                <th>Ngày phát hành</th>
                <th>Mã thẻ</th>
                <th>Mệnh giá</th>    
                <th>Tình trạng</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("../config/connection.php");
                $sql = "SELECT * FROM giftcode ORDER BY ID DESC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td class="tc-id"><?php echo $row["date"]?></td>
                    <td><?php echo $row["seri"]?></td>
                    <td><?php echo number_format($row["cost"])?> VNĐ</td>
                    <?php
                        if($row["status"] == 1){
                    ?>
                    <td style="color: green;">Chưa được nạp</td>
                    <?php
                        }
                        else{
                    ?>
                    <td style="color: red;">Đã được nạp</td>
                </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
    
</div>
