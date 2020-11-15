<?php
include_once 'conn.php';
include_once 'functions.php';

//change username
if( isset($_GET['changeUsername'])){
    echo '
        <div class="modal fade" id="changeUsernameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Change Username</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Change Username Successful!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="settings.php"><button type="button" class="btn btn-primary">Return to Settings</button></a>
                    </div>
                </div>
            </div>
        </div>
    ';
}
//change password
if( isset($_GET['changePassword'])){
    echo '
        <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Change Password Successful!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="settings.php"><button type="button" class="btn btn-primary">Return to Settings</button></a>
                    </div>
                </div>
            </div>
        </div>
    ';
}

//login and insert temperature modal
if(isset($_POST['loginBtn'])){
    $loginVal = mysqli_real_escape_string($conn,$_POST['loginBtn']);
    
    //verification
    $sql= "SELECT * FROM list WHERE qrcode='$loginVal' OR idnum='$loginVal';";
    $object = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($object);
    $db_qrcode = $array['qrcode'];
    $db_idnum = $array['idnum'];

    $fname = $array['fname'];
    $lname = $array['lname'];
    $date = getDateToday();
    $time = getTimeToday();

    if(empty($loginVal)) {
        echo '<script>location.href="login.php?id_login_empty_error=true"</script>';
    }
    else if($loginVal != $db_qrcode && $loginVal != $db_idnum) {
        echo '<script>location.href="login.php?id_login_reg_error=true"</script>';
    }
    else {
        echo "<script>$('#loginModal').modal('show');</script>";
        echo '
            <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Log-in</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="POST" action="includes/process.php" autocomplete="off" class="form-group">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-auto">
                                        <p class="font-weight-bold">Status:</p>
                                        <p class="font-weight-bold">Name:</p>
                                        <p class="font-weight-bold">ID number:</p>
                                        <p class="font-weight-bold">Date:</p>
                                        <p class="font-weight-bold">Time:</p>
                                        <p class="font-weight-bold">Temperature:</p>
                                    </div>
                                    <div class="col">
                                        <p class="text-success">Verified<i class="fa fa-check-circle fa-lg ml-2"></i></p>
                                        <p>'.$fname.' '.$lname.'</p>
                                        <p>'.$db_idnum.'</p>
                                        <p>'.$date.'</p>
                                        <p>'.$time.'</p>
                                        <p><input id="inputTemp" type="text" class="form-control input-primary" name="temp" placeholder="Enter Body Temperature ( deg. C )"></p>
                                    </div>
                                </div>
                                <input name="fname" value="'.$fname.'" style="display:none;">
                                <input name="lname" value="'.$lname.'" style="display:none;">
                                <input name="idnum" value="'.$db_idnum.'" style="display:none;">
                                <input name="date" value="'.$date.'" style="display:none;">
                                <input name="time" value="'.$time.'" style="display:none;">
                                
                            </div>
                            <div class="modal-footer">
                                <a href="login.php"><button type="button" class="btn btn-secondary">Cancel</button></a>
                                <button type="submit" name="loginBtn" class="btn btn-primary">Log-in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        ';  
        }
}

//view qr code modal
if(isset($_POST['readId'])){
    $id = mysqli_real_escape_string($conn,$_POST['readId']);
    $sql = "SELECT * FROM list WHERE id='$id';";
    $object = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($object);

    $fname = $array['fname'];
    $lname = $array['lname'];
    $qrcode = $array['qrcode'];
    
    $qrcodeLoc="./images/qrcode/".$fname." ".$lname." ".$qrcode.".png";

    echo "<script>$('#viewQrCodeModal').modal('show');</script>";
    echo '
        <div class="modal fade" id="viewQrCodeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">QR Code</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <center class="mb-3">
                            <p class="font-weight-bold">Item #'.$_POST['itemNo'].'</p>
                            <div>
                                <img src="'.$qrcodeLoc.'" class="border shadow mb-1" style="width:200px;height:200px">
                            </div>
                            <a href="includes/process.php?downloadId='.$id.'"><button type="button" class="btn btn-primary w-50 mt-3">Download QR Code</button></a>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    ';
}

//UPDATE modals
if(isset($_POST['updateId'])){
    $id = mysqli_real_escape_string($conn,$_POST['updateId']);
    $itemNo = mysqli_real_escape_string($conn,$_POST['itemNo']);
    $currentPage = mysqli_real_escape_string($conn,$_POST['currentPage']);
    $limitRecords = mysqli_real_escape_string($conn,$_POST['limitRecords']);
    $sql = "SELECT * FROM list WHERE id='$id';";
    $object = mysqli_query($conn, $sql);
    $array = mysqli_fetch_assoc($object);
    $fname = $array['fname'];
    $lname = $array['lname'];
    $position = $array['position'];
    $others = $array['others'];
    $idnum = $array['idnum'];
    $age = $array['age'];
    $contact = $array['contact'];
    $address = $array['address'];
    $email = $array['email'];
    
    echo "<script>$('#updateModal').modal('show')</script>";
    echo "<script>$('#$position').attr('checked', 'checked')</script>";
    echo '
        <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="POST" action="includes/process.php" autocomplete="off" enctype="multipart/form-data" class="form-group">
                        <div class="modal-body">
                            <input name="updateId" value="'.$id.'" style="display:none;">
                            <input name="currentPage" value="'.$currentPage.'" style="display:none;">
                            <input name="limitRecords" value="'.$limitRecords.'" style="display:none;">
                            <p class="font-weight-bold">Item #'.$itemNo.'</p>
                            <!-- name -->
                            <div class="row align-items-center mb-3">
                                <div class="col-2"><label for="name" class="col-form-label">Name:</label></div>
                                <div class="col"><input type="text" id="name" class="form-control input-primary" name="fname" placeholder="First" value="'.$fname.'" autofocus></div>
                                <div class="col"><input type="text" class="form-control input-primary" name="lname" placeholder="Last" value="'.$lname.'"></div>
                            </div>
                            <!-- position -->
                            <div class="row align-items-center mb-3">
                                <div class="col-2">
                                    <label class="col-form-label">Position:</label>
                                </div>
                                <div class="col-2 ml-5 form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="Admin" value="Admin" >
                                    <label class="form-check-label" for="Admin">Admin</label>
                                </div>
                                <div class="col-2 form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="Patient" value="Patient">
                                    <label class="form-check-label" for="Patient">Patient</label>
                                </div>
                                <div class="col-1 form-check form-check-inline m-0 p-0">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="Others" value="Others">
                                    <label class="form-check-label" for="Others">Others</label>
                                </div>
                                <div class="col"><input type="text" class="form-control input-primary" name="others" placeholder="e.g., visitor, contractor" value="'.$others.'"></div>
                            </div>
                            <!--idnum and age-->
                            <div class="row align-items-center mb-3">
                                <div class="col-2"><label for="idnum" class="col-form-label">ID number:</label></div>
                                <div class="col"><input type="text" id="idnum" class="form-control input-primary" name="idnum" placeholder="" value="'.$idnum.'"></div>
                                <div class="col-1 p-0"><label for="age" class="col-form-label">Age:</label></div>
                                <div class="col"><input type="text" id="age" class="form-control input-primary" name="age" placeholder="" value="'.$age.'"></div>
                            </div>
                            <!-- email and contact-->
                            <div class="row align-items-center mb-3">
                                <div class="col-2"><label for="address" class="col-form-label">Email address:</label></div>
                                <div class="col"><input type="text" id="address" class="form-control input-primary" name="email" placeholder="" value="'.$email.'"></div>
                                <div class="col-1 p-0"><label for="contact" class="col-form-label">Contact number:</label></div>
                                <div class="col"><input type="text" id="contact" class="form-control input-primary" name="contact" placeholder="" value="'.$contact.'"></div>
                            </div>
                            <!-- address -->
                            <div class="row align-items-center mb-3">
                                <div class="col-2"><label for="address" class="col-form-label">Address:</label></div>
                                <div class="col"><textarea rows="2" id="address" class="form-control input-primary" name="address" placeholder="">'.$address.'</textarea></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="update" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    ';
}
if( isset($_GET['update'])){
    echo '
        <div class="modal fade" id="updateConfirmedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Update</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="font-weight-bold">Updated Successfully!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Return to Database</button>
                    </div>
                </div>
            </div>
        </div>
    ';
}

//DELETE modals
if(isset($_POST['deleteId']) ){
    echo "<script>$('#deleteConfirmationModal').modal('show');</script>";
    echo '
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p class="font-weight-bold">Are you sure you want to delete item #'.$_POST['itemNo'].' ?</p>
                        <p class="text-secondary">This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <a href="includes/process.php?deleteId='.$_POST['deleteId'].'&currentPage='.$_POST['currentPage'].'&limitRecords='.$_POST['limitRecords'].'"><button type="button" class="btn btn-danger">Delete</button></a>
                    </div>
                </div>
            </div>
        </div>
    ';
}
if(isset($_GET['delete']) ){
    echo '
        <div class="modal fade" id="deleteConfirmedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="font-weight-bold">Deleted Successfully!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Return to Database</button>
                    </div>
                </div>
            </div>
        </div>
    ';
}
?>