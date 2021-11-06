 <div class="maincontent">
    <?php
        if(isset($_GET['navstore'])){
            $index = $_GET['navstore'];
        }
        else {
            $index = '';
            include("home.php");
        }
        if ($index == 'login'){
            echo '<script> document.title = "Đăng nhập";</script>';
            include("Login.php");
        }
        elseif ($index == 'home'){
            include("home.php");
        }
        elseif ($index == 'register'){
            include("register.php");
            echo '<script> document.title = "Đăng ký";</script>';
        }
        elseif($index =='appdetail'){
            include("appdetail.php");
        }
        elseif($index == 'forgotpassword'){
            include("forgotpwd.php");
            echo '<script> document.title = "Quên mật khẩu";</script>';
        }
        elseif($index == 'resetpassword'){
            include("resetpassword.php");
            echo '<script> document.title = "Quên mật khẩu";</script>';
        }
        elseif($index == 'profile'){
            if(!isset($_GET['action'])){
                header("Location: index.php?navstore=profile&action=infor");
            }
            else{
                include("profile.php");
            }
        }
        elseif($index == 'buyapp'){
            include("buyapp.php");
        }
        elseif($index == 'ranking'){
            include("ranking.php"); 
        }
        elseif($index == 'category'){
            include("category.php");
        }
        elseif($index == 'search'){
            include("search.php");
        }
        elseif($index == 'developer'){
            include("developer.php");
        }
    ?>
</div>