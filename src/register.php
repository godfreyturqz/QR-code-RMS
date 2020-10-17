<?php
include 'includes/conn.php';
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
</head>
<body>
<div class="row m-0">
    <!-- side nav -->
    <?php include 'sideNav.php'; ?>
    <!-- main content -->
    <main class="col p-0">
        <!-- main nav --> 
        <?php include 'mainNav.php'; ?>
        <!-- bg-primary container -->
        <div class="container bg-primary p-4 rounded-lg" style="width:750px;">
            <!-- header -->
            <div class="d-flex align-items-center mb-4">
                <a href="index.php"><button class="btn btn-dark btn-sm"><i class="fa fa-long-arrow-left mr-2"></i>Back</button></a>
                <h4 class="text-white ml-auto"><i class="fa fa-user-circle-o mr-1"></i>Register</h4>
            </div>
            <!-- Registration form -->
            <div class="p-5 bg-light rounded-lg dp-none fadeIn" >
                <form id="regForm" autocomplete="off" enctype="multipart/form-data" class="form-group">
                    <!-- name -->
                    <div class="row align-items-center mb-3">
                        <div class="col-2"><label for="fname" class="col-form-label">Name:</label></div>
                        <div class="col"><input type="text" id="fname" class="form-control input-primary" name="fname" placeholder="First"></div>
                        <div class="col"><input type="text" id="lname" class="form-control input-primary" name="lname" placeholder="Last" ></div>
                    </div>
                    <!-- position -->
                    <div class="row align-items-center mb-3">
                        <div class="col-2"><label class="col-form-label">Position:</label></div>
                        <div class="col-2 ml-5 form-check form-check-inline m-0 p-0">
                            <input class="form-check-input input-primary" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="Admin" checked>
                            <label class="form-check-label" for="flexRadioDefault1">Admin</label>
                        </div>
                        <div class="col-2 form-check form-check-inline m-0 p-0">
                            <input class="form-check-input input-primary" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="Patient">
                            <label class="form-check-label" for="flexRadioDefault2">Patient</label>
                        </div>
                        <div class="col-1 form-check form-check-inline m-0 p-0">
                            <input class="form-check-input input-primary" type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="Others">
                            <label class="form-check-label" for="flexRadioDefault3">Others</label>
                        </div>
                        <div class="col">
                            <input type="text" id="others" class="form-control input-primary" name="others" placeholder="e.g., visitor, contractor" >
                        </div>
                    </div>
                    <!--idnum and age-->
                    <div class="row align-items-center mb-3">
                        <div class="col-2"><label for="idnum" class="col-form-label">ID number:</label></div>
                        <div class="col"><input type="text" id="idnum" class="form-control input-primary" name="idnum" placeholder="" ></div>
                        

                        <div class="col-1 p-0"><label for="age" class="col-form-label">Age:</label></div>
                        <div class="col"><input type="text" id="age" class="form-control input-primary" name="age" placeholder="" ></div>
                    </div>
                    <!-- email and contact-->
                    <div class="row align-items-center mb-3">
                        <div class="col-2"><label for="email" class="col-form-label">Email address:</label></div>
                        <div class="col"><input type="text" id="email" class="form-control input-primary" name="email" placeholder="" ></div>

                        <div class="col-1 p-0"><label for="contact" class="col-form-label">Contact number:</label></div>
                        <div class="col"><input type="text" id="contact" class="form-control input-primary" name="contact" placeholder="" ></div>
                    </div>
                    <!-- address -->
                    <div class="row align-items-center mb-3">
                        <div class="col-2"><label for="address" class="col-form-label">Address:</label></div>
                        <div class="col"><textarea rows="2" id="address" class="form-control input-primary" name="address" placeholder=""></textarea></div>
                    </div>
                    <!-- button  -->
                    <div class="row align-items-center mb-3">
                        <div class="col-2"><label class="col-form-label"></label></div>
                        <div class="col">
                            <button type="submit" id="regBtn" name="regBtn" class="btn btn-primary btn-block" >Submit</button>
                            <!-- errorMSG  -->
                            <p id="errEmpty" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Fill-out the required field.</p>
                            <p id="errIdnum" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>ID number already exists.</p>
                            <p id="errEmail" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Invalid E-mail address.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- footer -->
        <?php include 'footer.php'; ?>
    </main>
</div>

<!-- registration success modal --> 
<div class="modal fade" id="registerConfirmedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Register</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <?php
                    $idnum = $_GET['idnum'];
                    $sql= "SELECT * FROM list WHERE idnum='$idnum';";
                    $object = mysqli_query($conn, $sql);
                    $array = mysqli_fetch_assoc($object);
                    $id = $array['id'];
                    $fname = $array['fname'];
                    $lname = $array['lname'];
                    $position = $array['position'];
                    $age = $array['age'];
                    $email = $array['email'];
                    $contact = $array['contact'];
                    $address = $array['address'];
                    $qrcode = $array['qrcode'];
                    $file='images/qrcode/'.$qrcode.'.png';
                ?>
                <div class="row">
                    <div class="col">
                        <p class="font-weight-bold">Status:</p>
                        <p class="font-weight-bold">Name:</p>
                        <p class="font-weight-bold">Position:</p>
                        <p class="font-weight-bold">ID number:</p>
                        <p class="font-weight-bold">Age:</p>
                        <p class="font-weight-bold">Email address:</p>
                        <p class="font-weight-bold">Contact number:</p>
                        <p class="font-weight-bold">Address:</p>
                    </div>
                    <div class="col">
                        <p class="text-success">Registered<i class="fa fa-check-circle fa-lg ml-2"></i></p>  
                        <p><?= $fname." ".$lname;?></p>
                        <p><?= $position;?></p>
                        <p><?= $idnum;?></p>
                        <p><?= $age;?></p>
                        <p><?= $email;?></p>
                        <p><?= $contact;?></p>
                        <p><?= $address;?></p>
                    </div>
                    <center class="col">
                        <img src="<?= $file;?>" class="border shadow mb-1" style="width:200px;height:200px">
                        <!-- download button -->
                        <a href="includes/process.php?downloadId=<?= $id;?>"><button type="button" class="btn btn-primary btn-block">Download QR Code</button></a>
                    </center>
                </div>
            </div>
            <div class="modal-footer">
                <a href="register.php"><button class="btn btn-primary">Add new</button></a>
                <a href="index.php"><button class="btn btn-primary">Return to Home</button></a>
            </div>
        </div>
    </div>
</div>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap-5.0.0-alpha1/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<script>$('#fname').focus()</script>
<div id="data"></div>

<?php
if( isset($_GET['register'])){
    echo "<script>$('#registerConfirmedModal').modal('show');</script>";
}
?>

</body>
</html>

