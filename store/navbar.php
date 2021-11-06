<?php
    if(isset($_GET['logout'])&& $_GET['logout']==1){
        unset($_SESSION['login']);
        header("Location: index.php?navstore=home");
    }
?>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: rgb(255, 123, 0);">	
		<div class="container-fluid">
			<a class="navbar-brand d-none d-sm-block" href="../store/index.php?navstore=home">
				<img src="../img/logo.png" height="50" width="55"></img>
			</a>
			<form class="d-flex" action = "index.php" method="GET">
				<input class="form-control me-2 pr-1" type="search"  placeholder="Tìm kiếm" aria-label="Search" name="keyword">
				<button class="btn btn-outline-light ml-2" type="submit" name="navstore" value="search">Tìm</button>
			</form>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    			<span class="navbar-toggler-icon"></span>
  			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav me-auto mb-2 mb-lg-0 ml-3 mr-auto">
					<li class="nav-item ml-1 mr-1">
						<a class="nav-link active text-white" aria-current="page" href="../store/index.php?navstore=home"><b>Trang chủ</b></a>
					</li>
					<li class="nav-item dropdown ml-1 mr-1">
						<a class="nav-link active text-white dropdown-toggle" href="" id="Dropdown-Ranking" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<b>Bảng xếp hạng</b>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="../store/index.php?navstore=ranking&type=paid">Ứng dụng mua nhiều nhất</a>
						<a class="dropdown-item" href="../store/index.php?navstore=ranking&type=free">Ứng dụng tải nhiều nhất</a>
					</li>
				</ul>
				<ul class="navbar-nav">
					<?php
						if(isset($_SESSION['login'])){
							require("../config/connection.php");
							$user=$_SESSION["login"];
							$query = "SELECT * FROM account WHERE email ='$user'";
							$sql_query=mysqli_query($conn,$query);
							$row=mysqli_fetch_array($sql_query);	
					?>
					<div class="dropdown text-white">
						<a class ="btn text-white" href = "../store/index.php?navstore=profile&action=recharge">Số dư: <?php echo number_format($row["cash"])?> VNĐ  <i class="fa fa-plus mr-4 ml-1" aria-hidden="true"></i></a>
						<a class="btn  dropdown-toggle pb-2" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" style="background-color: rgb(255, 123, 0); color:white;" aria-expanded="false">
							<?php
								if($row['avatar'] == ''){				
							?>
							<img class="rounded-circle" src="../img/user.png" alt="Logo-Login" width = 40 height= 40></img>
							<?php
								}
								else{
							?>
							<img class="rounded-circle" src="../uploads/user/avatar/<?php echo $row['avatar']?>" alt="Logo-Login" width = 40 height= 40></img>
							<?php
								}
							?>
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
							<a class="dropdown-item" href="index.php?navstore=profile&action=infor">Thông tin tài khoản</a>
							<a class="dropdown-item" href="index.php?navstore=profile&action=buyhistory">Ứng dụng đã mua</a>
							<?php
								if($row["status"] == '0'){
							?>
							<a class="dropdown-item" href="../upgrade/upgrade.php">Nâng cấp nhà phát triển</a>
							<?php	
								}
								elseif($row["status"]== '1'){
							?>
									<a class="dropdown-item" href="../developer/index.php">Nhà phát triển của tôi</a>
							<?php
								}
							?>
							<a class="dropdown-item" href="../store/index.php?logout=1">Đăng xuất</a>
						</div>
					</div>
					<?php
						} 
						elseif(!isset($_SESSION["login"])){
					?>
					<li class="nav-item" id="nav-login">
						<a class="nav-link active text-white border rounded" aria-current="page" id="bt-login" href="index.php?navstore=login">Đăng nhập</a>
					</li>
					<?php
					}
					?>
				</ul>
			</div>	
		</div>
</nav>