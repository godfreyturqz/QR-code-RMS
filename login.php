<?php
include_once 'includes/conn.php';
include_once 'includes/functions.php';
/*
CREATE TABLE login(
	id int not null PRIMARY KEY AUTO_INCREMENT,
    fname varchar(256) not null,
    lname varchar(256) not null,
    idnum varchar(256) not null,
    date varchar(256) not null,
    time varchar(256) not null,
    temp varchar(256) not null
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
                <h4 class="text-white ml-auto"><i class="fa fa-sign-in mr-1"></i>Log-in</h4>
            </div>
            <!-- content -->
            <div class="d-flex bg-white p-5 rounded-lg fadeIn" style="display:none;">
                <!-- pills -->
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-first-tab" data-toggle="pill" href="#v-pills-first" role="tab" aria-controls="v-pills-first" aria-selected="true">Log-in form</a>
                    <a class="nav-link" id="v-pills-second-tab" data-toggle="pill" href="#v-pills-second" role="tab" aria-controls="v-pills-second" aria-selected="false">Recent logs</a>
                    <a class="nav-link" href="database.php?page=1&limitRecords=10" >View all logs</a>
                </div>
                <div class="tab-content ml-4 w-75" id="v-pills-tabContent">
                    <!-- login form -->
                    <div class="tab-pane fade show active " id="v-pills-first" role="tabpanel" aria-labelledby="v-pills-first-tab">
                        <center class="position-relative">
                            <!-- feedback -->
                            <?php
                                if(isset($_GET['id_login_empty_error'])){
                                    echo '
                                        <div class="alert alert-danger w-50" role="alert" style="position:absolute;top:170px;left:113px;">
                                            <i class="fa fa-exclamation-circle fa-lg mr-2"></i>Try again.
                                            <button class="close float-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                    ';
                                }
                                else if(isset($_GET['id_login_reg_error'])){
                                    echo '
                                        <div class="alert alert-danger w-50" role="alert" style="position:absolute;top:170px;left:113px;">
                                            <i class="fa fa-exclamation-circle fa-lg mr-2"></i>User not registered.
                                            <button class="close float-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                    ';
                                }
                                else if(isset($_GET['id_login_success'])){
                                    echo '
                                        <div class="alert alert-success w-50" role="alert" style="position:absolute;top:170px;left:113px;">
                                            <i class="fa fa-check-circle fa-lg mr-2"></i>Logged-in.
                                            <button class="close float-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                    ';
                                }
                            ?>
                            <h5>Scan <strong class="text-primary">QR Code</strong> or</h5>
                            <h5>Enter <strong class="text-primary">ID number</strong></h5>
                            <div class="my-5">
                                <?php
                                    if(isset($_GET['id_login_success'])){
                                        $idnum = mysqli_real_escape_string($conn, $_GET['id_login_success']);
                                        $sql= "SELECT * FROM list WHERE idnum='$idnum';";
                                        $object = mysqli_query($conn, $sql);
                                        $array = mysqli_fetch_assoc($object);
                                        $qrcode = $array['qrcode'];
                                        echo '<img src="images/qrcode/'.$qrcode.'.png" style="width:200px;height:200px">';
                                    }
                                    else{
                                        echo '<img src="images/qrcode/default.png" style="width:200px;height:200px">';
                                    }
                                ?>
                            </div>
                            <form id="loginForm" autocomplete="off">
                                <input type="text" class="form-control input-primary text-center rounded-pill " id="inputautofocus" name="loginVal" placeholder="QR Code or ID number" style="width:250px;">
                                <button type="submit" name="loginBtn" class="btn"><i class="fa fa-sign-in mr-1"></i>Log-in</button>
                            </form>
                            <p class="text-secondary mt-2">Not registered? click <a href="register.php" class="text-decoration-none">here</a></p>
                        </center> 
                    </div>
                    <!-- recent logs -->
                    <div class="tab-pane fade" id="v-pills-second" role="tabpanel" aria-labelledby="v-pills-second-tab">
                        <p class="text-secondary">10 most recent logs as of Today ( <?=getDateToday();?> )</p>
                        <table class="table table-hover">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Item</th>
                                    <th>Name</th>
                                    <th>ID #</th>
                                    <th>Time</th>
                                    <th>Temp.</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $date = getDateToday();
                                    $sql = "SELECT * FROM login WHERE date='$date' ORDER BY id DESC LIMIT 10;";
                                    $object = mysqli_query($conn, $sql);
                                    $itemNo = 0;
                                    while ($row = mysqli_fetch_assoc($object)):?>
                                    <tr>
                                        <td><?php echo $itemNo += 1;?></td>
                                        <td><?php echo $row["fname"]." ".$row['lname'];?></td>
                                        <td><?php echo $row["idnum"];?></td>
                                        <td><?php echo $row["time"];?></td>
                                        <td><?php echo $row["temp"];?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                        <center>----------  Nothing follows  ----------</center>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <?php include 'footer.php'; ?>
    </main>
</div>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap-5.0.0-alpha1/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<div id="modal"></div>

</body>
</html>