<?php
include 'includes/functions.php';
session_start();
$signup_login_id = $_SESSION[''];
if (empty($signup_login_id)) {
  session_unset();
  session_destroy();
  header("location:signin.php?signin_to_continue");
}
else{
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
        <!-- cards -->        
        <div class="container mb-4 fadeIn dp-none" style="width:750px;">
            <div class="row">
                <h5 class="text-dark">Daily Updates</h5>
                <div class="col bg-white p-4 shadow-lg rounded-lg" style="width:250px;">
                    <div class="row">
                        <div class="col-3 align-items-center"><i class="fa fa-address-card fa-3x text-purple"></i></div>
                        <div class="col ml-4">
                            <h3 class="font-weight-bold"><?= countRegToday(); ?></h3>
                            <h6 class="text-secondary">New Registration</h6>
                        </div>
                    </div>
                </div>
                <div class="col bg-white p-4 ml-2 shadow-lg rounded-lg" style="width:250px;">
                    <div class="row">
                        <div class="col-2"><i class="fa fa-user fa-3x text-green"></i></div>
                        <div class="col ml-4">
                            <h3 class="font-weight-bold"><?= countAttendanceToday(); ?></h3>
                            <h6 class="text-secondary">Recent log-in</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- icons -->  
        <div class="container py-5 bg-primary shadow-lg rounded-lg" style="width:750px;">
            <div class="d-flex justify-content-center">
                <div class="flex-column m-1">
                    <a href="register.php"><button class="btn btn-primary p-4">
                        <i class="fa fa-user-circle-o fa-3x p-5 pb-3"></i>
                        <h4>Register</h4>
                    </button></a>
                </div>
                <div class="flex-column m-1">
                    <a href="login.php"><button class="btn btn-primary p-4">
                        <i class="fa fa-sign-in fa-3x p-5 pb-3"></i>
                        <h4>Log-in</h4>
                    </button></a>
                </div>
                <div class="flex-column m-1">
                    <a href="settings.php"><button class="btn btn-primary p-4">
                        <i class="fa fa-cog fa-3x p-5 pb-3"></i>
                        <h4>Settings</h4>
                    </button></a>
                </div>
            </div>
            <div class="d-flex flex-wrap justify-content-center">
                <div class="flex-column m-1">
                    <a href="search.php"><button class="btn btn-primary p-4">
                        <i class="fa fa-clock-o fa-3x p-5 pb-3"></i>
                        <h4>Time Records</h4>
                    </button></a>
                </div>
                <div class="flex-column m-1">
                    <a href="database.php?page=1&limitRecords=10"><button class="btn btn-primary p-4">
                        <i class="fa fa-database fa-3x p-5 pb-3"></i>
                        <h4>User Records</h4>
                    </button></a>
                </div>
                <!-- dummy -->
                <div class="flex-column m-1 v-hidden">
                    <a href="#"><button class="btn btn-primary p-4">
                        <i class="fa fa-database fa-3x p-5 pb-3"></i>
                        <h4>dummy</h4>
                    </button></a>
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

</body>
</html>
<?php   }//else ?>
