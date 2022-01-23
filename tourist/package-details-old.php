<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (!isset($_SESSION['tourist'])) {
    header('location:../signin.php');
} else {
    $pid = intval($_GET['pid']);
    if (isset($_POST['submit'])) {
        $pname = $_POST['packagename'];
        $ptype = $_POST['packagetype'];
        $plocation = $_POST['packagelocation'];
        $pprice = $_POST['packageprice'];
        $pfeatures = $_POST['packagefeatures'];
        $pdetails = $_POST['packagedetails'];
        $pimage = $_FILES["packageimage"]["name"];
        $sql = "update TblTourPackages set PackageName=:pname,PackageType=:ptype,PackageLocation=:plocation,PackagePrice=:pprice,PackageFetures=:pfeatures,PackageDetails=:pdetails where PackageId=:pid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':pname', $pname, PDO::PARAM_STR);
        $query->bindParam(':ptype', $ptype, PDO::PARAM_STR);
        $query->bindParam(':plocation', $plocation, PDO::PARAM_STR);
        $query->bindParam(':pprice', $pprice, PDO::PARAM_STR);
        $query->bindParam(':pfeatures', $pfeatures, PDO::PARAM_STR);
        $query->bindParam(':pdetails', $pdetails, PDO::PARAM_STR);
        $query->bindParam(':pid', $pid, PDO::PARAM_STR);
        $query->execute();
        $msg = "Package Updated Successfully";
    }

?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>TMS | Tourist Package Creation</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script type="application/x-javascript">
            addEventListener("load", function() {
                setTimeout(hideURLbar, 0);
            }, false);

            function hideURLbar() {
                window.scrollTo(0, 1);
            }
        </script>
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/morris.css" type="text/css" />
        <link href="css/font-awesome.css" rel="stylesheet">
        <script src="js/jquery-2.1.4.min.js"></script>
        <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
        <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
        <style>
            .errorWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #dd3d36;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }

            .succWrap {
                padding: 10px;
                margin: 0 0 20px 0;
                background: #fff;
                border-left: 4px solid #5cb85c;
                -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
                box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            }
        </style>

    </head>

    <body>
        <div class="page-container">
            <!--/content-inner-->
            <div class="left-content">
                <div class="mother-grid-inner">
                    <!--header start here-->
                    <?php include('includes/header.php'); ?>

                    <div class="clearfix"> </div>
                </div>
                <!--heder end here-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Package Details</li>
                </ol>
                <!--grid-->
                <div class="grid-form">

                    <!---->
                    <div class="grid-form1">
                        <h3>Book Package</h3>
                        <?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">

                                <?php
                                $pid = intval($_GET['pid']);
                                $sql = "SELECT * from TblTourPackages where PackageId=:pid";
                                $query = $dbh->prepare($sql);
                                $query->bindParam(':pid', $pid, PDO::PARAM_STR);
                                $query->execute();
                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                $cnt = 1;
                                if ($query->rowCount() > 0) {
                                    foreach ($results as $result) {    ?>

                                        <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Name</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagename" id="packagename" placeholder="Create Package" value="<?php echo htmlentities($result->PackageName); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Type</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagetype" id="packagetype" placeholder=" Package Type eg- Family Package / Couple Package" value="<?php echo htmlentities($result->PackageType); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Location</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagelocation" id="packagelocation" placeholder=" Package Location" value="<?php echo htmlentities($result->PackageLocation); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Price in USD</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packageprice" id="packageprice" placeholder=" Package Price is USD" value="<?php echo htmlentities($result->PackagePrice); ?>">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Features</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control1" name="packagefeatures" id="packagefeatures" placeholder="Package Features Eg-free Pickup-drop facility" value="<?php echo htmlentities($result->PackageFetures); ?>">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="focusedinput" class="col-sm-2 control-label">Package Details</label>
                                                <div class="col-sm-8">
                                                    <textarea class="form-control" rows="5" cols="50" name="packagedetails" id="packagedetails" placeholder="Package Details"><?php echo htmlentities($result->PackageDetails); ?></textarea>
                                                </div>
                                            </div>

                                    <?php }
                                } ?>
                                    <?php
                                    $user = $_SESSION['tourist'];
                                    $packagecheck = $_GET['pid'];
                                    $conn = mysqli_connect('localhost', 'root', '', 'tms');
                                    $checkapp = "SELECT * FROM `tblbooking` WHERE `PackageId`='$packagecheck' AND `UserEmail`='$user'";
                                    $checkappquery = mysqli_query($conn, $checkapp);
                                    $checkapprows = mysqli_num_rows($checkappquery);
                                    if ($checkapprows >= 1) {
                                    } else {
                                    ?>
                                        <div class="form-group">
                                            <label for="focusedinput" class="col-sm-2 control-label">From Date</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control1" name="fromdate" id="fromdate">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="focusedinput" class="col-sm-2 control-label">To Date</label>
                                            <div class="col-sm-8">
                                                <input type="date" class="form-control1" name="todate" id="todate">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="focusedinput" class="col-sm-2 control-label">Transaction Code</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control1" name="transactioncode" id="transactioncode" style="text-transform: uppercase;">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="focusedinput" class="col-sm-2 control-label">Description</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" rows="5" cols="50" name="tourdescription" id="tourdescription" placeholder="Please describe about your trip"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-8 col-sm-offset-2">
                                                <button type="submit" class="btn-danger btn" name="makebooking"> Make Booking Now</button>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>
                            </div>

                            </form>

                            <?php

                            if (isset($_POST['makebooking'])) {
                                $fromdate = mysqli_real_escape_string($conn, $_POST['fromdate']);
                                $todate = mysqli_real_escape_string($conn, $_POST['todate']);
                                $transactioncode = mysqli_real_escape_string($conn, $_POST['transactioncode']);
                                $tourdescription = mysqli_real_escape_string($conn, $_POST['tourdescription']);
                                $codelength = strlen($transactioncode);
                                if (empty($fromdate) || empty($todate) || empty($transactioncode) || empty($tourdescription)) {
                                    echo "<script>alert('Provide all the details');</script>";
                                } else if (!preg_match("/^[a-zA-z0-9 ]*$/", $transactioncode)) {
                                    echo "<script>alert('Transaction code will only have numericals and aplhabetic characters only');</script>";
                                } else if ($codelength != 10) {
                                    echo "<script>alert('Transaction code must have 10 characters');</script>";
                                } else {
                                    $conn = mysqli_connect('localhost', 'root', '', 'tms');
                                    $checkcode = "SELECT * FROM `tblbooking` WHERE `transaction_code`='$transactioncode'";
                                    $checkcodequery = mysqli_query($conn, $checkcode);
                                    $checkcoderows = mysqli_num_rows($checkcodequery);
                                    if ($checkcoderows >= 1) {
                                        echo "<script>alert('Transaction code already exists');</script>";
                                    } else {
                                        $user = $_SESSION['tourist'];
                                        $packagecheck = $_GET['pid'];
                                        $booknow = "INSERT INTO `tblbooking`(`PackageId`, `UserEmail`, `FromDate`, `ToDate`, `Comment`, `transaction_code`, `transaction_status`) VALUES ('$packagecheck', '$user', '$fromdate','$todate','$tourdescription','$transactioncode','waiting')";
                                        $querybooking = mysqli_query($conn, $booknow);
                                        if ($querybooking) {
                                            echo "<script>window.location.href='my-bookings.php';</script>";
                                        }
                                    }
                                }
                            }


                            ?>



                            <div class="panel-footer">

                            </div>
                            </form>
                        </div>
                    </div>
                    <!--//grid-->

                    <!-- script-for sticky-nav -->
                    <script>
                        $(document).ready(function() {
                            var navoffeset = $(".header-main").offset().top;
                            $(window).scroll(function() {
                                var scrollpos = $(window).scrollTop();
                                if (scrollpos >= navoffeset) {
                                    $(".header-main").addClass("fixed");
                                } else {
                                    $(".header-main").removeClass("fixed");
                                }
                            });

                        });
                    </script>
                    <!-- /script-for sticky-nav -->
                    <!--inner block start here-->
                    <div class="inner-block">

                    </div>
                    <!--inner block end here-->
                    <!--copy rights start here-->
                    <?php include('includes/footer.php'); ?>
                    <!--COPY rights end here-->
                </div>
            </div>
            <!--//content-inner-->
            <!--/sidebar-menu-->
            <?php include('includes/sidebarmenu.php'); ?>
            <div class="clearfix"></div>
        </div>
        <script>
            var toggle = true;

            $(".sidebar-icon").click(function() {
                if (toggle) {
                    $(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
                    $("#menu span").css({
                        "position": "absolute"
                    });
                } else {
                    $(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
                    setTimeout(function() {
                        $("#menu span").css({
                            "position": "relative"
                        });
                    }, 400);
                }

                toggle = !toggle;
            });
        </script>
        <!--js -->
        <script src="js/jquery.nicescroll.js"></script>
        <script src="js/scripts.js"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src="js/bootstrap.min.js"></script>
        <!-- /Bootstrap Core JavaScript -->

    </body>

    </html>
<?php } ?>