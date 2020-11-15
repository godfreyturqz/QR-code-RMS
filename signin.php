<?php
/*
CREATE TABLE signin(
	id int not null PRIMARY KEY AUTO_INCREMENT,
    username varchar(256) not null,
    pwd varchar(256) not null,
    qrcode varchar(256) not null
);
INSERT INTO signin (username, pwd) VALUES('admin','123456');
*/
session_start();
session_unset();
session_destroy();
include 'includes/conn.php';
$username='';
if (isset($_POST['signin']) ) {
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);

    $errEmptyUsername = false;
    $errEmptyPwd = false;
    $errAuth = false;

    if(empty($username) && empty($pwd)) {
        $errEmptyUsername = true;
        $errEmptyPwd = true;
    }
    else if(empty($username)) {
        $errEmptyUsername = true;
    }
    else if(empty($pwd)) {
        $errEmptyPwd = true;
    }
    else {
        $sql= "SELECT * FROM signin WHERE username='$username';";
        $object = mysqli_query($conn, $sql);
        $rowcount = mysqli_num_rows($object);
        if($rowcount < 1){
            $errAuth = true;
        }
        else{
            $array = mysqli_fetch_assoc($object);
            $db_username = $array['username'];
            $db_pwd = $array['pwd'];
            $pwd_verification = password_verify($pwd, $db_pwd);
            if( $username != $db_username || $pwd_verification == false) {
                $errAuth = true;
            }
            else{
                session_start();
                $_SESSION['']= $db_username;
                header("location:index.php?signin=true");
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style>
        .label{
            font-size: 14px;
            position: absolute;
            left: 10px;
            bottom: 50px;
            padding: 0px 5px;
            background-color: white;
            display:none;
        }
    </style>
</head>
<body style="background-color:white;">

<div class="d-flex justify-content-center mt-5 p-5">
    <form method="POST" autocomplete="off" class="border p-5 m-5 rounded-lg shadow-lg" style="width:450px;">
        <div class="mb-5">
            <h1><span class="text-primary">Sign</span>-in</h1>
            <span>to continue</span>
        </div>
        <div class="form-group position-relative">
            <label for="username" class="label" id="usernameLabel">Username</label>
            <!-- <input type="text" class="form-control p-3 input-primary" id="username" name="username" placeholder="Username" value="<?=$username;?>"> -->
            <input type="text" class="form-control p-3 input-primary" id="username" name="username" placeholder="Username" value="godfrey-turqueza">
        </div>
        <p class="text-danger mb-3 mt-1" style="font-size:14px;display:none;bottom:100px;" id="errEmptyUsername"><i class="fa fa-exclamation-circle mr-2"></i>Enter a username</p>
        
        <div class="form-group mt-4 position-relative">
            <label for="pwd" class="label" id="pwdLabel">Password</label>
            <input type="password" class="form-control p-3 input-primary" id="pwd" name="pwd" placeholder="Password" value="**********">
        </div>
        <p class="text-danger mt-1" style="font-size:14px;display:none;" id="errEmptyPwd"><i class="fa fa-exclamation-circle mr-2"></i>Enter a password</p>
        <p class="text-danger mt-1" style="font-size:14px;display:none;" id="errAuth"><i class="fa fa-exclamation-circle mr-2"></i>Try again. Wrong username or password.</p>
        <div class="mt-5">
            <span ><a href="signin.php" style="text-decoration:none;">Forgot password?</a></span>
            <button type="submit" class="btn btn-sm btn-primary float-right font-weight-bold px-4" id="signin" name="signin"><a href="index.php" style="text-decoration:none;color:#FFF;">Continue</a></button>
        </div>
    </form>
</div>

<script src="lib/jquery-3.5.1.min.js"></script>
<script>
    $('#username').focus()
    $('#username').removeAttr('placeholder')
    $('#usernameLabel').fadeIn()

    $('input').focus(function(){
        var id = $(this).attr('id')
        $(this).removeAttr('placeholder')
        $('#'+id+'Label').fadeIn()
    })
    $('#username').blur(function(){
        $(this).attr("placeholder", "Username")
        var value = $(this).val()
        if( !value ){
            $('#usernameLabel').hide()
        }
    })
    $('#pwd').blur(function(){
        $(this).attr("placeholder", "Password")
        var value = $(this).val()
        if( !value ){
            $('#pwdLabel').hide()
        }
    })
</script>
<script>
    var errEmptyUsername = '<?php echo $errEmptyUsername; ?>';
    var errEmptyPwd = '<?php echo $errEmptyPwd; ?>';
    var errAuth = '<?php echo $errAuth; ?>';

    if(errEmptyPwd == true){
        $('#pwd').addClass('input-danger')
        $('#errEmptyPwd').show()
        $('#pwd').focus()
    }
    if(errEmptyUsername == true ){
        $('#username').addClass('input-danger')
        $('#errEmptyUsername').show()
        $('#username').focus()
    }
    if(errAuth == true){
        $('#username, #pwd').addClass('input-danger')
        $('#errAuth').show()
        $('#pwd').focus()
    }
</script>
</body>
</html>