<?php
include 'includes/modal.php';
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
    <!-- main body -->
    <main class="col p-0">
        <!-- main nav --> 
        <?php include 'mainNav.php'; ?>
        <!-- bg-primary container -->
        <div class="container bg-primary p-4 rounded-lg" style="width:750px;">
            <div class="d-flex align-items-center mb-4">
                <a href="index.php"><button class="btn btn-dark btn-sm"><i class="fa fa-long-arrow-left mr-2"></i>Back</button></a>
                <h4 class="text-white ml-auto"><i class="fa fa-cog mr-1"></i>Settings</h4>
            </div>
            <!-- content -->
            <div class="d-flex bg-light p-5 rounded-lg fadeIn" style="display:none;">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Change Username</a>
                    <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Change Password</a>
                </div>
                <div class="tab-content ml-5 pl-5" id="v-pills-tabContent">
                    <!-- Change username -->
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        <form class="form-group" id="changeUsernameForm" autocomplete="off">
                            <label for="currentUsername" class="col-form-label">Current Username</label>
                            <input type="text" id="currentUsername" class="form-control input-primary mt-1" autofocus>
                            <p id="errCurrentUsername" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Username does not exists.</p>

                            <label for="newUsername" class="col-form-label mt-2">New Username</label>
                            <input type="text" id="newUsername" class="form-control input-primary mt-1">
                            <p id="errNewUsername" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Username already exists.</p>

                            <label for="pwd" class="col-form-label mt-2">Password:</label>
                            <input type="password" id="pwd" class="form-control input-primary mt-1">
                            <p id="errPwd" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Try again. Wrong password.</p>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary" >Change Username</button>
                                <input type="reset" class="btn text-primary" value="Cancel changes">
                            </div>
                            <p id="errEmpty" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Fill-out empty field.</p>
                        </form>
                    </div>
                    <!-- change password -->
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        <form class="form-group" id="changePasswordForm" autocomplete="off" >
                            <label for="username" class="col-form-label">Username</label>
                            <input type="text" id="username" class="form-control input-primary mt-1">
                            <p id="errUsername" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Username does not exists.</p>

                            <label for="currentPwd" class="col-form-label">Current Password</label>
                            <input type="password" id="currentPwd" class="form-control input-primary mt-1">
                            <p id="errCurrentPwd" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Try again. Wrong password.</p>

                            <label for="newPwd" class="col-form-label mt-2">New Password</label>
                            <input type="password" id="newPwd" class="form-control input-primary mt-1">

                            <label for="confirmNewPwd" class="col-form-label mt-2">Confirm New Password</label>
                            <input type="password" id="confirmNewPwd" class="form-control input-primary mt-1">
                            <p id="errConfirmNewPwd" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Password does not match.</p>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary" >Change Password</button>
                                <input type="reset" class="btn text-primary" value="Cancel changes">    
                            </div>
                            <p id="errEmptyChangePwd" class="mt-1 error_msg"><i class="fa fa-exclamation-circle mr-2"></i>Fill-out empty field.</p>
                        </form>
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
<div id="data"></div>

<?php
if( isset($_GET['changeUsername'])){
    echo "<script>$('#changeUsernameModal').modal('show');</script>";
}
if( isset($_GET['changePassword'])){
    echo "<script>$('#changePasswordModal').modal('show');</script>";
}
?>
<!-- 
for future update
add account
<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
    <form method="POST" autocomplete="off" enctype="multipart/form-data" class="form-group">
        <label for="currentPwd" class="col-form-label">Name</label>
        <input type="text" id="currentPwd" class="form-control input-primary mt-1" name="currentPwd" required>

        <label for="currentPwd" class="col-form-label">Role</label>
        <input type="text" id="currentPwd" class="form-control input-primary mt-1" name="currentPwd" required>

        <label for="currentPwd" class="col-form-label">Username</label>
        <input type="text" id="currentPwd" class="form-control input-primary mt-1" name="currentPwd" required>

        <label for="newPwd" class="col-form-label mt-2">Password</label>
        <input type="text" id="newPwd" class="form-control input-primary mt-1" name="newPwd" required>

        <label for="newPwd" class="col-form-label mt-2">Confirm Password</label>
        <input type="text" id="newPwd" class="form-control input-primary mt-1" name="newPwd" required>

        <div class="mt-4">
            <button type="submit" name="changePwd" class="btn btn-primary" >Add account</button>
            <input type="reset" class="btn text-primary" value="Cancel changes">    
        </div>
    </form>
</div>
account management
<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
    Displays all account. 
</div>
-->
</body>
</html>