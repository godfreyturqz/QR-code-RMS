<?php
include_once 'includes/conn.php';
include 'includes/functions.php';
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
    <!--main content-->
    <main class="col p-0">
        <!--main nav--> 
        <?php include 'mainNav.php'; ?>
        <!--cards-->
        <div class="d-flex justify-content-center fadeIn dp-none">
            <div class="bg-white p-4 m-2 shadow-lg rounded-lg" style="width:250px;">
                <div class="row">
                    <div class="col-4"><i class="fa fa-address-card fa-3x text-purple"></i></div>
                    <div class="col"><h3 class="font-weight-bold"><?= countRegTotal(); ?></h3></div>
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col"><h6 class="text-secondary">TOTAL ITEMS ON RECORDS</h6></div>
                </div>
            </div>
            <div class="bg-white p-4 m-2 shadow-lg rounded-lg" style="width:250px;">
                <div class="row">
                    <div class="col-4"><i class="fa fa-bed fa-3x text-primary"></i></div>
                    <div class="col"><h3 class="font-weight-bold"><?= countPatientTotal(); ?></h3></div>
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col"><h6 class="text-secondary">PATIENT</h6></div>
                </div>
            </div>
            <div class="bg-white p-4 m-2 shadow-lg rounded-lg" style="width:250px;">
                <div class="row">
                    <div class="col-4"><i class="fa fa-user fa-3x text-green"></i></div>
                    <div class="col"><h3 class="font-weight-bold"><?= countAdminTotal(); ?></h3></div>
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col"><h6 class="text-secondary">ADMIN</h6></div>
                </div>
            </div>
            <div class="bg-white p-4 m-2 shadow-lg rounded-lg" style="width:250px;">
                <div class="row">
                    <div class="col-4"><i class="fa fa-users fa-3x text-dark"></i></div>
                    <div class="col"><h3 class="font-weight-bold"><?= countOthersTotal(); ?></h3></div>
                </div>
                <div class="row">
                    <div class="col-4"></div>
                    <div class="col"><h6 class="text-secondary">OTHERS</h6></div>
                </div>
            </div>
        </div>
        <!--table container-->
        <div class="p-2">
            <!--table-->
            <table id="table" class="table table-hover bg-white">
                <thead class="bg-primary">
                    <tr>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="id" data-colOrder="desc">#</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="fname" data-colOrder="desc">Name</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="position" data-colOrder="desc">Position</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="idnum" data-colOrder="desc">ID number</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="age" data-colOrder="desc">Age</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="contact" data-colOrder="desc">Contact</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="address" data-colOrder="desc">Address</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="email" data-colOrder="desc">Email</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="regdate" data-colOrder="desc">Registration</a></th>
                        <th scope="col"><a href="#" class="columnSort text-decoration-none text-white" data-colName="qrcode" data-colOrder="desc">QR Code</a></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    <?php
                        // $limit = isset($_POST['limitRecords']) ? $_GET['limitRecords'] : 10;
                        // $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $limit = $_GET['limitRecords'];
                        $page = $_GET['page'];
                        $start = ($page -1) * $limit;
                        $total = countRegTotal();
                        $pages = ceil($total / $limit);
                        //echo $pages;

                        $prevPage = $page - 1 ;
                        if ($prevPage == 0){
                            $prevPage = 1;
                        }
                        $nextPage= $page + 1 ;
                        if ($nextPage > $pages){
                            $nextPage = $pages;
                        }
                        $itemNo = $start;
                        $sql = "SELECT * FROM list ORDER BY id DESC LIMIT $start, $limit;";
                        $object = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($object)):?>
                        <tr>
                            <?php $id = $row["id"];?>
                            <td><?php echo $itemNo += 1;?></a></td>
                            <td><?php echo $row["fname"]." ".$row['lname'];?></td>
                            <td><?php echo $row["position"]." ".$row['others'];?></td>
                            <td><?php echo $row["idnum"];?></td>
                            <td><?php echo $row["age"];?></td>
                            <td><?php echo $row["contact"];?></td>
                            <td><?php echo $row["address"];?></td>
                            <td><?php echo $row["email"];?></td>
                            <td><?php echo $row["regdate"]." ".$row["regtime"];?></td>
                            <td><?php echo $row["qrcode"];?></td>
                            <!-- process -->
                            <td class="d-flex align-items-center">
                                <button class="btn btn-sm btn-outline fa fa-qrcode readBtn" data-id="<?= $id; ?>" data-itemNo="<?= $itemNo; ?>"></button>
                                <button class="btn btn-sm btn-outline fa fa-pencil updateBtn" data-id="<?= $id; ?>" data-itemNo="<?= $itemNo; ?>" data-currentPage="<?= $_GET['page']; ?>" data-limitRecords="<?= $_GET['limitRecords']; ?>"></button>
                                <button class="btn btn-sm btn-outline fa fa-trash deleteBtn" data-id="<?= $id; ?>" data-itemNo="<?= $itemNo; ?>" data-currentPage="<?= $_GET['page']; ?>" data-limitRecords="<?= $_GET['limitRecords']; ?>"></button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
                <!-- back button -->
                <div class="mb-3">
                    <a href="index.php"><button class="btn btn-dark btn-sm"><i class="fa fa-long-arrow-left mr-2"></i>Back</button></a>
                    <a href="database.php?page=1&limitRecords=10"><button class="btn btn-dark btn-sm"><i class="fa fa-refresh mr-2"></i>Reload</button></a>
                </div>
                <!-- process -->
                <div class="d-flex bg-white p-3 mb-2 rounded-lg">
                    <div class="d-flex align-items-center mr-auto ">
                        <!--search bar-->
                        <div class="mr-3">
                            <form method="POST" id="searchForm" autocomplete="off">
                                <div class="input-group">
                                    <input id="search" type="text" class="form-control input-primary" placeholder="Search" name="searchVal">
                                    <div class="input-group-append"><button class="btn btn-primary" type="submit" name="searchBtn"><i class="fa fa-search"></i></button></div>
                                </div>
                            </form>
                        </div>
                        <!--limit records-->
                        <div class="mr-3">
                            <form method="GET" id="limitRecordsForm">
                                <select class="form-select input-primary" name="limitRecords" id="limitRecords">
                                    <option disabled selected>Limit records</option>
                                    <?php foreach([10, 20, 30, 40, 50] as $limit): ?>
                                    <option value="<?=$limit;?>"  <?php if( $_GET['limitRecords'] == $limit) {echo'selected'; }?>> <?=$limit;?> </option>
                                    <?php endforeach; ?>
                                    <option value="<?=$total;?>">Display all</option>
                                </select>
                                <input type="text" name="page" value="1" style="display:none;">
                            </form>
                        </div>
                        <!--CSV-->
                        <div class="mr-3">
                            <form action="includes/process.php" method="POST">
                                <button type="submit" name="export" class="btn border"><i class="fa fa-download text-primary"></i> CSV Export</button>
                            </form>
                        </div>
                        <!--Addnew-->
                        <div class="mr-3">
                            <a href="register.php" ><button type="button" class="btn border"><i class="fa fa-user-plus text-primary"></i> Add new</button></a>
                        </div>
                        <!-- display dashboard -->
                        <!-- <div class="form-check form-switch">
                            <input class="form-check-input input-primary" type="checkbox" id="flexSwitchCheckChecked" checked>
                            <label class="form-check-label" for="flexSwitchCheckChecked">Display Dashboard</label>
                        </div> -->
                    </div>
                    <!--prev next button-->
                    <a href="database.php?page=<?=$prevPage; ?>&limitRecords=<?=$_GET['limitRecords'];?>"><button class="btn border shadow"><i class="fa fa-chevron-circle-left text-primary"></i> Previous</button></a>
                    <a href="database.php?page=<?=$nextPage;?>&limitRecords=<?=$_GET['limitRecords'];?>"><button class="btn border shadow">Next <i class="fa fa-chevron-circle-right text-primary"></i></button></a>
                </div>
            </table>
        </div>
        
    </main>
</div>

<script src="lib/jquery-3.5.1.min.js"></script>
<script src="lib/bootstrap-5.0.0-alpha1/js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
<div id="data"></div>

<?php
if( isset($_GET['update'])){
    echo "<script>$('#updateConfirmedModal').modal('show');</script>";
}
if( isset($_GET['delete'])){
    echo "<script>$('#deleteConfirmedModal').modal('show');</script>";
}
?>

</body>
</html>