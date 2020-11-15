<?php
include_once 'conn.php';
include_once 'functions.php';
include '../lib/phpqrcode/qrlib.php';
//echo "error on if statement";

//register
if (isset($_POST['regBtn'])) {
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $position = mysqli_real_escape_string($conn,$_POST['position']);
    $others = mysqli_real_escape_string($conn,$_POST['others']);
    $idnum = mysqli_real_escape_string($conn,$_POST['idnum']);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $link = mysqli_real_escape_string($conn,$_POST['link']);

    //idnum duplicate verification
    $sql= "SELECT * FROM list WHERE idnum='$idnum';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    if(empty($fname) || empty($lname) || empty($position) ||empty($idnum) || empty($age) || empty($contact) || empty($address) || empty($email)) {
        echo '
            <script>
                $("#errEmpty").show()
                $("#errIdnum").hide()
                $("#errEmail").hide()
            </script>
        ';
    }
    else if($rowcount >= 1) {
        echo '
            <script>
                $("#errIdnum").show()
                $("#idnum").addClass("input-danger")
                $("#errEmpty").hide()
                $("#errEmail").hide()
            </script>
        ';
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '
            <script>
                $("#errEmail").show()
                $("#email").addClass("input-danger")
                $("#errEmpty").hide()
                $("#errIdnum").hide()
            </script>
        ';
    }
    else {
        $uniqId = uniqid();
        $qrcodeFileName = $fname." ".$lname." ".$uniqId;
        $filenameExt = $qrcodeFileName.".png";
        $path = '../images/qrcode/';
        $file = $path.$filenameExt;
        $qrcodeValue = $fname." ".$lname." ".$link;
        //$text = "Name: ".$name."\nID#: ".$idnum."\nAge: ".$age."\nContact#: ".$contact."\nAddress: ".$address."\nEmail: ".$email;
        QRcode::png($qrcodeValue, $file, 'M', 9, 1);
        //png($filename, $filepath, 'L or M or H or Q', pixel size, frame size)
        $date = getDateToday();
        $time = getTimeToday();
        $sql = "INSERT INTO list (fname, lname, position, others, idnum , age, contact, address, email, qrcode, regdate, regtime) 
                VALUES ('$fname','$lname','$position','$others','$idnum','$age','$contact','$address','$email','$uniqId','$date','$time');";
        mysqli_query($conn, $sql);

        echo '<script>location.href="register.php?register=true&idnum='.$idnum.'"</script>' ;
    }
}

//settings-change username
if (isset($_POST['changeUsernameBtn'])){
    $currentUsername = mysqli_real_escape_string($conn,$_POST['currentUsername']);
    $newUsername = mysqli_real_escape_string($conn,$_POST['newUsername']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);

    $sql = "SELECT * FROM signin WHERE username='$currentUsername';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    $array = mysqli_fetch_assoc($object);
    $db_pwd = $array['pwd'];
    $pwd_verification = password_verify($pwd, $db_pwd);

    $sql = "SELECT * FROM signin WHERE username='$newUsername';";
    $object = mysqli_query($conn, $sql);
    $rowcountNew = mysqli_num_rows($object);

    if ( empty($currentUsername) || empty($newUsername) || empty($pwd)){
        echo '
            <script>
                $("#errEmpty").show()
                $("#errCurrentUsername").hide()
                $("#errNewUsername").hide()
                $("#errPwd").hide()</script>
            </script>
        ';
    }
    else if ($rowcount == 0) {
        echo '
            <script>
                $("#errCurrentUsername").show()
                $("#currentUsername").addClass("input-danger").focus()
                $("#errNewUsername").hide()
                $("#errPwd").hide()
                $("#errEmpty").hide()
            </script>
        ';
    }
    else if ($rowcountNew >= 1) {
        echo '
            <script>
                $("#errNewUsername").show()
                $("#newUsername").addClass("input-danger").focus()
                $("#errCurrentUsername").hide()
                $("#errPwd").hide()
                $("#errEmpty").hide()
            </script>
        ';
    }
    else if ($pwd_verification == false){
        echo '
            <script>
                $("#errPwd").show()
                $("#pwd").addClass("input-danger").focus()
                $("#errCurrentUsername").hide()
                $("#errNewUsername").hide()
                $("#errEmpty").hide()
            </script>
        ';
    }
    else {
        $sql = "UPDATE signin
                SET username='$newUsername'
                WHERE username ='$currentUsername';";
        mysqli_query($conn, $sql);
        // echo '
        //     <script>
        //         $("#errNewUsername").hide()
        //         $("#errCurrentUsername").hide()
        //         $("#errPwd").hide()
        //         $("#errEmpty").hide()
        //     </script>
        // ';
        echo '<script>location.href="settings.php?changeUsername=true"</script>' ;
    }
}

//settings-change password
if (isset($_POST['changePasswordBtn'])){
    $username = mysqli_real_escape_string($conn,$_POST['username']);
    $currentPwd = mysqli_real_escape_string($conn,$_POST['currentPwd']);
    $newPwd = mysqli_real_escape_string($conn,$_POST['newPwd']);
    $confirmNewPwd = mysqli_real_escape_string($conn,$_POST['confirmNewPwd']);

    $sql = "SELECT * FROM signin WHERE username='$username';";
    $object = mysqli_query($conn, $sql);
    $rowcount = mysqli_num_rows($object);

    $array = mysqli_fetch_assoc($object);
    $db_pwd = $array['pwd'];
    $pwd_verification = password_verify($currentPwd, $db_pwd);

    if ( empty($username) || empty($currentPwd) || empty($newPwd) || empty($confirmNewPwd)){
        echo '
            <script>
                $("#errEmptyChangePwd").show()
                $("#errUsername").hide()
                $("#errCurrentPwd").hide()
                $("#errConfirmNewPwd").hide()
            </script>
        ';
    }
    else if ($rowcount == 0) {
        echo '
            <script>
                $("#errUsername").show()
                $("#username").addClass("input-danger").focus()
                $("#errEmptyChangePwd").hide()
                $("#errCurrentPwd").hide()
                $("#errConfirmNewPwd").hide()
            </script>
        ';
    }
    else if ($pwd_verification == false){
        echo '
            <script>
                $("#errCurrentPwd").show()
                $("#currentPwd").addClass("input-danger").focus()
                $("#errEmptyChangePwd").hide()
                $("#errUsername").hide()
                $("#errConfirmNewPwd").hide()
            </script>
        ';
    }
    else if ($newPwd != $confirmNewPwd) {
        echo '
            <script>
                $("#errConfirmNewPwd").show()
                $("#newPwd").addClass("input-danger").focus()
                $("#confirmNewPwd").addClass("input-danger")
                $("#errUsername").hide()
                $("#errCurrentPwd").hide()
                $("#errEmptyChangePwd").hide()
            </script>
        ';
    }
    else {
        $pwd_hashed = password_hash("$newPwd", PASSWORD_DEFAULT);
        $sql = "UPDATE signin
                SET pwd='$pwd_hashed'
                WHERE username ='$username';";
        mysqli_query($conn, $sql);
        echo '<script>location.href="settings.php?changePassword=true"</script>' ;
    }
}

//login
if (isset($_POST['loginBtn']) ) {
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $idnum = mysqli_real_escape_string($conn,$_POST['idnum']);
    $date = mysqli_real_escape_string($conn,$_POST['date']);
    $time = mysqli_real_escape_string($conn,$_POST['time']);
    $temp = mysqli_real_escape_string($conn,$_POST['temp']);

    $sql = "INSERT INTO login(fname, lname, idnum, date, time, temp) VALUES ('$fname','$lname','$idnum','$date','$time','$temp');";
    mysqli_query($conn, $sql);
    header("location:../login.php?id_login_success=$idnum");
}


//userrecords-update
if (isset($_POST['update'])){
    $id = mysqli_real_escape_string($conn,$_POST['updateId']);
    $currentPage = mysqli_real_escape_string($conn,$_POST['currentPage']);
    $limitRecords = mysqli_real_escape_string($conn,$_POST['limitRecords']);
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $position = mysqli_real_escape_string($conn,$_POST['flexRadioDefault']);
    $others = mysqli_real_escape_string($conn,$_POST['others']);
    $idnum = mysqli_real_escape_string($conn,$_POST['idnum']);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    $sql = "UPDATE list
            SET fname='$fname', lname='$lname', position='$position', others='$others', idnum='$idnum', age='$age', contact='$contact', address='$address', email='$email'
            WHERE id ='$id';";
    mysqli_query($conn, $sql);
    header("location:../database.php?page=$currentPage&limitRecords=$limitRecords&update=true");
}
//userrecords-delete
if(isset($_GET['deleteId'])){
    $id = mysqli_real_escape_string($conn, $_GET['deleteId']);
    $currentPage = mysqli_real_escape_string($conn, $_GET['currentPage']);
    $limitRecords = mysqli_real_escape_string($conn, $_GET['limitRecords']);

    $sql = "SELECT * FROM list WHERE id='$id';";
    $object = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($object);
    $idnum = $array['idnum'];

    $sql = "DELETE FROM list WHERE id='$id';";
    mysqli_query($conn, $sql);

    $sql = "DELETE FROM login WHERE idnum='$idnum';";
    mysqli_query($conn, $sql);
    
    header("location:../database.php?page=$currentPage&limitRecords=$limitRecords&delete=true");
}

//userrecords-export 
if (isset ($_POST['export'])){
    header('Content-type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=data.csv');
    $output = fopen("php://output", "w");
    fputcsv($output, array('DB key','First name','Last name','Position','Others','ID number','Age','Contact','Address','Email','QR Code','Reg date','Reg time'));
    $sql = "SELECT * FROM list ORDER BY id";
    $object = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($object) ){
        fputcsv($output, $row);
    }
    fclose($output);
}
//userrecords-download
if (isset ($_GET['downloadId'])){
    $id = mysqli_real_escape_string($conn,$_GET['downloadId']);
    $sql = "SELECT * FROM list WHERE id='$id';";
    
    $object = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($object);

    $fname = $array['fname'];
    $lname = $array['lname'];
    $qrcode = $array['qrcode'];
    
    $qrcodeLoc="../images/qrcode/".$fname." ".$lname." ".$qrcode.".png";
    // $qrcodeLoc = "../images/qrcode/".$array['qrcode'].".png";

    header('Content-type: image/png');
    header("Cache-Control: no-store, no-cache");  
    header('Content-Disposition: attachment; filename="QR-Code.png"');
    readfile($qrcodeLoc);
}
//userrecords-search
if (isset($_POST['searchBtn'])) {
    $itemNo = 0;
    $search =  $_POST['searchBtn'];
    $sql = "SELECT * FROM list
            WHERE fname LIKE '%$search%' OR lname LIKE '%$search%' OR position LIKE '%$search%' OR others LIKE '%$search%' 
                    OR idnum LIKE '%$search%' OR contact LIKE '%$search%' OR address LIKE '%$search%' OR email LIKE '%$search%' OR qrcode LIKE '%$search%'
            ORDER BY id DESC;";
    $object = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($object)) {
        $id = $row['id'];
        $itemNo += 1;
        echo'
            <tr>
                <td>'.$itemNo.'</td>
                <td>'.$row['fname']." ".$row['fname'].'</td>
                <td>'.$row['position']." ".$row['others'].'</td>
                <td>'.$row['idnum'].'</td>
                <td>'.$row['age'].'</td>
                <td>'.$row['contact'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['regdate']." ".$row['regtime'].'</td>
                <td>'.$row['qrcode'].'</td>
                <td class="d-flex align-items-center">
                    <button class="btn btn-sm btn-outline fa fa-qrcode readBtn" data-id="'.$id.'" data-itemNo="'.$itemNo.'"></button>
                    <button class="btn btn-sm btn-outline fa fa-pencil updateBtn" data-id="'.$id.'" data-itemNo="'.$itemNo.'" data-currentPage="1" data-limitRecords="10"></button>
                    <button class="btn btn-sm btn-outline fa fa-trash deleteBtn" data-id="'.$id.'" data-itemNo="'.$itemNo.'" data-currentPage="1" data-limitRecords="10"></button>
                </td>
            </tr>
        ';
    }
    //crud functions of buttons are enabled
    echo'<script src="js/custom.js"></script>';
}
//userrecords-sort
if(isset($_POST['colOrder']) ){
    $colName = $_POST['colName'];
    $colOrder = $_POST['colOrder'];
    if($colOrder == 'desc'){
        $colOrder = 'asc';
    }
    else{
        $colOrder = 'desc';
    }
    echo'
        <thead class="bg-primary">
            <tr>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="id" data-colOrder="'.$colOrder.'">#</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="fname" data-colOrder="'.$colOrder.'">Name</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="position" data-colOrder="'.$colOrder.'">Position</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="idnum" data-colOrder="'.$colOrder.'">ID number</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="age" data-colOrder="'.$colOrder.'">Age</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="contact" data-colOrder="'.$colOrder.'">Contact</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="address" data-colOrder="'.$colOrder.'">Address</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="email" data-colOrder="'.$colOrder.'">Email</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="regdate" data-colOrder="'.$colOrder.'">Registration</a></th>
                <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="qrcode" data-colOrder="'.$colOrder.'">QR Code</a></th>
                <th scope="col"></th>
            </tr>
        </thead>
    ';
    $limit = isset($_POST['limitRecords']) ? $_POST['limitRecords'] : 10;
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $start = ($page -1) * $limit;
    $total = countRegTotal();
    $pages = ceil($total / $limit);
    $prevPage = $page - 1 ;
    if ($prevPage == 0){
        $prevPage = 1;
    }
    $nextPage= $page + 1 ;
    if ($nextPage > $pages){
        $nextPage = $page;
    }
    $itemNo = $start;
    $sql = "SELECT * FROM list ORDER BY $colName $colOrder;";
    $object = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($object)) {
        $id = $row['id'];
        $itemNo += 1;
        echo'
            <tr>
                <td>'.$itemNo.'</td>
                <td>'.$row['fname']." ".$row['lname'].'</td>
                <td>'.$row['position']." ".$row['others'].'</td>
                <td>'.$row['idnum'].'</td>
                <td>'.$row['age'].'</td>
                <td>'.$row['contact'].'</td>
                <td>'.$row['address'].'</td>
                <td>'.$row['email'].'</td>
                <td>'.$row['regdate']." ".$row['regtime'].'</td>
                <td>'.$row['qrcode'].'</td>
                <td class="d-flex align-items-center">
                    <button class="btn btn-sm btn-outline fa fa-qrcode readBtn" data-id="'.$id.'" data-itemNo="'.$itemNo.'"></button>
                    <button class="btn btn-sm btn-outline fa fa-pencil updateBtn" data-id="'.$id.'" data-itemNo="'.$itemNo.'" data-currentPage="1" data-limitRecords="10"></button>
                    <button class="btn btn-sm btn-outline fa fa-trash deleteBtn" data-id="'.$id.'" data-itemNo="'.$itemNo.'" data-currentPage="1" data-limitRecords="10"></button>
                </td>
            </tr>
        ';
    }
    echo'<script src="js/custom.js"></script>';
}



?>

