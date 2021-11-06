<div class="category mt-2 ">
    <h2>Quản lí thể loại</h2>
    <hr>
    <button class="btn btn-success btn-md ml-2 mt-1 mb-3" onclick="AddCategory()">Thêm</button>
    <!-- Success Alert-->
    <div class="alert alert-success alert-dismissable" id = "alert-add-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Thêm thành công!</strong> Thể loại đã được thêm vào
    </div>
    <div class="alert alert-primary alert-dismissable" id = "alert-edit-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Chỉnh sửa thành công!</strong>
    </div>
    <table id="categoryTable" class="table table-hover mt-3"> 
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên thể loại</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
                include("../config/connection.php");
                $sql = "SELECT * FROM category ORDER BY ID DESC";
                $result = $conn->query($sql);
                while ($row = $result->fetch_assoc()) {
                ?>
                <tr id="category-id-<?php echo $row['ID']?>">
                    <td><?php echo $row["ID"]?></td>
                    <td><?php echo $row["name"]?></td>
                    <td><button class="btn btn-primary" id="edit-category" onclick="EditCategory(<?php echo $row['ID']?>,'<?php echo $row['name']?>')">Sửa</button>  <button class="btn btn-danger" onclick="DeleteCategory(<?php echo $row['ID']?>)">Xóa</button></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
<!--Add Modal -->
<div class="modal fade" id="modal-add-category" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Thêm thể loại</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control" id="category-name" name="category-name">
            <div id = "message-add-error"></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-success" id="btn-add-category">Thêm</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
      </div> 
    </div>
  </div>

 <!--Edit Modal -->
 <div class="modal fade" id="modal-edit-category" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Chỉnh sửa thông tin thể loại</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <input type="text" class="form-control" id="category-name-edit" name="category-name-edit">
            <div id = "message-add-error"></div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="btn-edit-category">Chỉnh sửa</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
      </div> 
    </div>
  </div>

  <!--Delete Modal -->
    <div class="modal fade" id="modal-delete-category" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Xóa thể loại</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
            <p>Bạn có chắc muốn xóa thể loại này không?</p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="btn-delete-category" data-dismiss="modal">Xóa</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        </div>
      </div> 
    </div>
  </div>


