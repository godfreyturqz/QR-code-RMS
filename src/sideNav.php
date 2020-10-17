<style>
    .sidebar-link{
        color: #b6cdff;
        font-size: 18px;
    }
    .sidebar-link:hover{
        color: white;
        background-color: #1F4E79;
    }
</style>
<nav id="sidebar" class="p-0 flex-column" style="background-color:#293142;height:938px;width:300px;display:none;">
    <div class="m-3 mb-4">
        <img src="images/logo.png" alt="logo" style="width:50px;">
        <span class="text-white ml-3">Name of organization</span>
    </div>
    <a href="index.php" class="nav-link ml-3 sidebar-link"><i class="fa fa-home fa-lg mr-3"></i>Home</a>
    <a href="register.php" class="nav-link ml-3 sidebar-link"><i class="fa fa-user-circle-o mr-3"></i>Register</a>
    <a href="login.php" class="nav-link ml-3 sidebar-link"><i class="fa fa-sign-in mr-3"></i> Log-in</a>
    <a href="timerecords.php" class="nav-link ml-3 sidebar-link"><i class="fa fa-clock-o mr-3"></i>Time Records</a>
    <a href="database.php?page=1&limitRecords=10" class="nav-link ml-3 sidebar-link"><i class="fa fa-database mr-3"></i>User Records</a>
    <a href="settings.php" class="nav-link ml-3 sidebar-link"><i class="fa fa-cog mr-3"></i>Settings</a>
    <a href="includes/logout.php" class="nav-link ml-3 sidebar-link"><i class="fa fa-sign-out mr-3"></i>Logout</a>
</nav>