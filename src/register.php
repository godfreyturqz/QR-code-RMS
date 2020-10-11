<?php
include_once 'includes/conn.php';
include 'phpqrcode/qrlib.php';
/*
CREATE TABLE list(
	id int not null PRIMARY KEY AUTO_INCREMENT,
    fname varchar(256) not null,
    lname varchar(256) not null,
    position varchar(256) not null,
    others varchar(256) not null,
    idnum varchar(256) not null,
    age varchar(256) not null,
    contact varchar(256) not null,
    address varchar(256) not null,
    email varchar(256) not null,
    qrcode varchar(256) not null,
    regdate varchar(256) not null,
    regtime varchar(256) not null,
    regupdate varchar(256) not null
);
*/
$error_msg=''; $isRegister='';
$file='images/qr code/default.jpg';
$fname='';$lname='';$position='';$others='';$idnum='';$age='';$contact='';$address='';$email='';

if (isset($_POST['register'])) {
    $fname = mysqli_real_escape_string($conn,$_POST['fname']);
    $lname = mysqli_real_escape_string($conn,$_POST['lname']);
    $position = mysqli_real_escape_string($conn,$_POST['flexRadioDefault']);
    $others = mysqli_real_escape_string($conn,$_POST['others']);
    $idnum = mysqli_real_escape_string($conn,$_POST['idnum']);
    $age = mysqli_real_escape_string($conn,$_POST['age']);
    $contact = mysqli_real_escape_string($conn,$_POST['contact']);
    $address = mysqli_real_escape_string($conn,$_POST['address']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);

    //idnum duplicate verification
    $sql= "SELECT * FROM list WHERE idnum='$idnum';";
    $object = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($object);
    $db_idnum = $array['idnum'];

    if(empty($fname) || empty($lname) || empty($position) ||empty($idnum) || empty($age) || empty($contact) || empty($address) || empty($email)) {
        $error_msg = "<i class='fa fa-exclamation-circle'></i>"." Fill up the blank field.";
    }
    else if ( $position=="Others" && empty($others)) {
        $error_msg = "<i class='fa fa-exclamation-circle'></i>"." Fill up the blank field.";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "<i class='fa fa-exclamation-circle'></i>"." Invalid E-mail address.";
    }
    else if($idnum == $db_idnum) {
        $error_msg = "<i class='fa fa-exclamation-circle'></i>"." ID number already exists.";
    }
    else {
        $qrcode = uniqid();
        $filenameExt = $qrcode.".png";
        $path = 'images/qr code/';
        $file = $path.$filenameExt;
        //$text = "Name: ".$name."\nID#: ".$idnum."\nAge: ".$age."\nContact#: ".$contact."\nAddress: ".$address."\nEmail: ".$email;
        QRcode::png($qrcode, $file, 'M', 8, 1);
        //png($filename, $filepath, 'L or M or H or Q', pixel size, frame size)
        date_default_timezone_set("Asia/Manila");
        $dt = new DateTime();
        $date = $dt->format('Y-m-d');
        $time = $dt->format('H:i:s');
        $sql = "INSERT INTO list (fname, lname, position, others, idnum , age, contact, address, email, qrcode, regdate, regtime) VALUES ('$fname','$lname','$position','$others','$idnum','$age','$contact','$address','$email','$qrcode','$date','$time');";
        mysqli_query($conn, $sql);
        $isRegister = true;

        //idnum duplicate verification
        $sql= "SELECT * FROM list WHERE idnum='$idnum';";
        $object = mysqli_query($conn, $sql);
        $array = mysqli_fetch_assoc($object);
        $id = $array['id'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'head.php'; ?>
    <style>
        a:hover{
            background-color: #1F4E79;
        }
        
    </style>
</head>
<body>
<div class="row m-0">
    <!-- side nav -->
    <?php include 'sideNav.php'; ?>
    <!-- main content -->
    <main class="col p-0">
        <!-- main nav --> 
        <?php include 'mainNav.php'; ?>
        <!-- registration form --> 
        <div class="container w-50 bg-primary mt-5 pb-5 shadow-lg rounded-lg" >
            <!-- header -->
            <div class="d-flex p-3 pt-4">
                <a href="index.php"><button class="btn btn-dark btn-sm text-white mr-1"><i class="fa fa-chevron-circle-left "></i> Back to Home</button></a>
                <a href="register.php"><button class="btn btn-dark btn-sm text-white"><i class="fa fa-refresh "></i> Refresh</button></a>
                <h3 class="text-white ml-auto"><i class=" fa fa-user-plus"></i> Registration</h3>
            </div>
            <!-- Registration form -->
            <div class="mx-3 p-5 bg-white rounded-lg fadeIn border" style="display:none;">
                <form method="POST" autocomplete="off" enctype="multipart/form-data" class="form-group">
                <!-- name -->
                <div class="row align-items-center mb-3">
                    <div class="col-2"><label for="name" class="col-form-label">Name:</label></div>
                    <div class="col"><input type="text" id="name" class="form-control input-primary" name="fname" placeholder="First" value="<?=$fname;?>" autofocus></div>
                    <div class="col"><input type="text" class="form-control input-primary" name="lname" placeholder="Last" value="<?=$lname;?>"></div>
                </div>
                <!-- position -->
                <div class="row align-items-center mb-3">
                    <div class="col-2"><label class="col-form-label">Position:</label></div>
                    <div class="col-2 ml-5 form-check form-check-inline m-0 p-0">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="Admin" checked>
                        <label class="form-check-label" for="flexRadioDefault1">Admin</label>
                    </div>
                    <div class="col-2 form-check form-check-inline m-0 p-0">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="Patient">
                        <label class="form-check-label" for="flexRadioDefault2">Patient</label>
                    </div>
                    <div class="col-1 form-check form-check-inline m-0 p-0">
                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="Others">
                        <label class="form-check-label " for="flexRadioDefault3">Others</label>
                    </div>
                    <div class="col">
                        <input type="text" class="form-control input-primary" name="others" placeholder="e.g., visitor, contractor" value="<?=$others;?>">
                    </div>
                </div>
                <!--idnum and age-->
                <div class="row align-items-center mb-3">
                    <div class="col-2"><label for="idnum" class="col-form-label">ID number:</label></div>
                    <div class="col"><input type="text" id="idnum" class="form-control input-primary" name="idnum" placeholder="" value="<?=$idnum;?>"></div>
                    <div class="col-1 p-0"><label for="age" class="col-form-label">Age:</label></div>
                    <div class="col"><input type="text" id="age" class="form-control input-primary" name="age" placeholder="" value="<?=$age;?>"></div>
                </div>
                <!-- email and contact-->
                <div class="row align-items-center mb-3">
                    <div class="col-2"><label for="address" class="col-form-label">Email address:</label></div>
                    <div class="col"><input type="text" id="address" class="form-control input-primary" name="email" placeholder="" value="<?=$email;?>"></div>
                    <div class="col-1 p-0"><label for="contact" class="col-form-label">Contact number:</label></div>
                    <div class="col"><input type="text" id="contact" class="form-control input-primary" name="contact" placeholder="" value="<?=$contact;?>"></div>
                </div>
                <!-- address -->
                <div class="row align-items-center mb-3">
                    <div class="col-2"><label for="address" class="col-form-label">Address:</label></div>
                    <div class="col"><textarea rows="2" id="address" class="form-control text-capitalize input-primary" name="address" placeholder=""><?=$address;?></textarea></div>
                </div>
                <!-- button  -->
                <div class="row align-items-center mb-3">
                    <div class="col-2"><label class="col-form-label"></label></div>
                    <div class="col">
                        <button type="submit" name="register" class="btn btn-primary btn-block mb-3" >Submit</button>
                        <!-- errorMSG  -->
                        <p class="text-danger"><?=$error_msg; ?></p>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- footer -->
        <?php include 'footer.php'; ?>
    </main>
</div>

<!-- registration modal --> 
<div class="modal fade" id="registerConfirmedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Record Management System</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-success">Successfully added to database <i class="fa fa-exclamation-circle"></i></p>
                <div class="row">
                    <center class="col">
                        <img src="<?= $file;?>" class="border mb-1" style="width:200px;height:200px">
                        <a href="includes/process.php?downloadId=<?= $id;?>"><button type="button" class="btn btn-primary btn-block">Download QR Code</button></a>
                    </center>
                    <div class="col">
                        <p><span class="text-secondary font-weight-bold">Name: </span><?= $fname." ".$lname;?> </p>
                        <p><span class="text-secondary font-weight-bold">Position: </span><?= $position;?> </p>
                        <p><span class="text-secondary font-weight-bold">ID number: </span><?= $idnum;?> </p>
                        <p><span class="text-secondary font-weight-bold">Age: </span><?= $contact;?> </p>
                        <p><span class="text-secondary font-weight-bold">Address: </span><?= $address;?> </p>
                        <p><span class="text-secondary font-weight-bold">Email address: </span><?= $email;?> </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="register.php"><button type="button" class="btn btn-primary">Add new</button></a>
                <a href="index.php"><button type="button" class="btn btn-primary">Return to Home</button></a>
            </div>
        </div>
    </div>
</div>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap-5.0.0-alpha1/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>

<?php
if( $isRegister){
    echo "<script>$('#registerConfirmedModal').modal('show')</script>";
}
?>

</body>
</html>

