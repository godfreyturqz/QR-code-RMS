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
                    <a class="nav-link" href="database.php" >View all logs</a>
                </div>
                <div class="tab-content ml-4 w-75" id="v-pills-tabContent">
                    <!-- login form -->
                    <div class="tab-pane fade show active " id="v-pills-first" role="tabpanel" aria-labelledby="v-pills-first-tab">
                        <center>
                            <h5>Scan <strong class="text-primary">QR Code</strong> or</h5>
                            <h5>Enter <strong class="text-primary">ID number</strong></h5>
                            <div class="alert alert-success" role="alert">Logged-in!
                                <button class="close float-right" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <div class="my-5">
                                <?php
                                    if(isset($_GET['id_login_success'])){
                                        $idnum = mysqli_real_escape_string($conn, $_GET['id_login_success']);
                                        $sql= "SELECT * FROM list WHERE idnum='$idnum';";
                                        $object = mysqli_query($conn, $sql);
                                        $array = mysqli_fetch_assoc($object);
                                        $qrcode = $array['qrcode'];
                                        echo '<img src="images/qr code/'.$qrcode.'.png" alt="qrcode" style="width:200px;height:200px">';
                                    }
                                    else{
                                        echo '<img src="images/qr code/default.png" alt="qrcode" style="width:200px;height:200px">';
                                    }
                                ?>
                            </div>
                            <form id="loginForm" autocomplete="off">
                                <input type="text" class="form-control input-primary text-center rounded-pill " id="inputautofocus" name="loginVal" placeholder="QR Code or ID number" style="width:250px;">
                                <button type="submit" name="loginBtn" class="btn"><i class="fa fa-sign-in mr-1"></i>Log-in</button>
                            </form>
                            
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
            
                    <!-- popUps -->
                    <div class="bg-white p-0 rounded-lg fadeIn" style="display:none;">
                        <?php
                            if(isset($_GET['id_login_empty_error'])){
                                echo '
                                    <div class="row m-0">
                                        <div class="col-2 bg-danger rounded-left d-flex justify-content-center"><i class="fa fa-exclamation-circle fa-lg text-white align-self-center"></i></div>
                                        <div class="col">
                                            <p class="text-danger font-weight-bold">Try again.</p>
                                            <p class="text-secondary">Fill up empty field.</p>
                                        </div>
                                    </div>
                                ';
                            }
                            else if(isset($_GET['id_login_reg_error'])){
                                echo '
                                    <div class="row m-0">
                                        <div class="col-2 bg-danger rounded-left d-flex justify-content-center"><i class="fa fa-exclamation-circle fa-lg text-white align-self-center"></i></div>
                                        <div class="col">
                                            <p class="text-danger font-weight-bold">User not registered.</p>
                                            <p class="text-secondary">Register <a href="register.php" class="text-decoration-none">here</a></p>
                                        </div>
                                    </div>
                                ';
                            }
                            else if(isset($_GET['id_login_success'])){
                                echo '
                                    <div class="row m-0">
                                        <div class="col-2 bg-green rounded-left d-flex justify-content-center"><i class="fa fa-check-circle fa-lg text-white align-self-center"></i></div>
                                        <div class="col">
                                            <p class="text-green font-weight-bold">Success</p>
                                            <p class="text-secondary">Logged-in.</p>
                                        </div>
                                    </div>
                                    
                                ';
                            }
                        ?>
                    </div>



                
                
                

            
            <!-- footer -->
            <?php include 'footer.php'; ?>
        </div>
    </main>
</div>



<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap-5.0.0-alpha1/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<div id="modal"></div>

</body>
</html>