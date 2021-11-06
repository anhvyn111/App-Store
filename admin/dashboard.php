<div class="dashboard mt-2">
    <h2>Tổng quan</h2>
    <hr>
    <div class="row" >
        <?php
         include("../config/connection.php");
         $sqlUser = "SELECT COUNT(ID) AS amountUser FROM account";
         $executeUser = mysqli_query($conn, $sqlUser);
         $rowUser = mysqli_fetch_assoc($executeUser);
        ?>
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card border-left-success border shadow py-2 ml-auto mr-auto">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Người dùng</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo $rowUser['amountUser']?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
         include("../config/connection.php");
         $sqlCategory = "SELECT COUNT(ID) AS amountCategory FROM category";
         $executeCategory = mysqli_query($conn, $sqlCategory);
         $rowCategory = mysqli_fetch_assoc($executeCategory);
        ?>
        <div class="col-md-6 col-lg-6 mb-4">
            <div class="card border-left-success shadow py-2 ml-auto mr-auto">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Thể loại</div>
                            <div class="h3 mb-0 font-weight-bold text-gray-800"><?php echo $rowCategory['amountCategory']?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
        <h4>Số Ứng dụng của từng thể loại</h4>
        <table id="categoryTable" class="table table-hover mt-3 ml-1 border shadow"> 
            <thead>
                <tr style="background-color: orange;">
                    <th>Thể loại</th>
                    <th>Số lượng ứng dụng</th>
                </tr>
            </thead>
            <tbody>
                <?php
                   
                    $sql = "SELECT  COUNT(name) AS amountCategory,(SELECT `name` FROM category WHERE category.ID = `application`.category) AS categoryName FROM `application` GROUP BY category";
                    $result = $conn->query($sql);
                    while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row["categoryName"]?></td>
                        <td><?php echo $row["amountCategory"]?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        </div>
        
        <div class="col-md-6">
            <h4>Ứng dụng tải nhiều nhất</h4>
            <table id="categoryTable" class="table table-hover mt-3 ml-1 border shadow"> 
            <thead>
                <tr style="background-color: orange;">
                    <th>Tên ứng dụng</th>
                    <th>Số lượt tải</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sqlFreeApp = "SELECT COUNT(ID) AS downAmount,(SELECT `name` FROM `application` WHERE `application`.ID = `freeapp_history`.ID_app) AS appName FROM `freeapp_history` GROUP BY ID_app ORDER BY downAmount DESC";
                    $resultFreeApp = $conn->query($sqlFreeApp);
                    while ($rowFreeApp = $resultFreeApp->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rowFreeApp["appName"]?></td>
                        <td><?php echo $rowFreeApp["downAmount"]?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        </div>
        <div class="col-md-6">
            <h4>Ứng dụng mua nhiều nhất</h4>
            <table id="categoryTable" class="table table-hover mt-3 ml-1 border shadow"> 
            <thead>
                <tr style="background-color: orange;">
                    <th>Tên ứng dụng</th>
                    <th>Số lượt mua</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include("../config/connection.php");
                    $sqlBuyApp = "SELECT COUNT(ID) AS buyAmount,(SELECT `name` FROM `application` WHERE `application`.ID = `buyapp_history`.ID_app) AS appName FROM `buyapp_history` GROUP BY ID_app ORDER BY buyAmount DESC";
                    $resultBuyApp = $conn->query($sqlBuyApp);
                    while ($rowBuyApp = $resultBuyApp->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rowBuyApp["appName"]?></td>
                        <td><?php echo $rowBuyApp["buyAmount"]?></td>
                    </tr>
                <?php
                    }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</div>