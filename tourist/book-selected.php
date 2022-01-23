<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (!isset($_SESSION['tourist'])) {
    header('location:../signin.php');
} else {
    // code for cancel
    if (isset($_REQUEST['bkid'])) {
        $bid = intval($_GET['bkid']);
        $status = 2;
        $cancelby = 'a';
        $payment = 'Cancelled';
        $sql = "UPDATE tblbooking SET status=:status,CancelledBy=:cancelby,transaction_status=:payment WHERE  BookingId=:bid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':cancelby', $cancelby, PDO::PARAM_STR);
        $query->bindParam(':payment', $payment, PDO::PARAM_STR);
        $query->bindParam(':bid', $bid, PDO::PARAM_STR);
        $query->execute();

        $msg = "Booking Cancelled successfully";
    }

    if (isset($_REQUEST['bckid'])) {
        $bcid = intval($_GET['bckid']);
        $status = 1;
        $cancelby = 'a';
        $payment = 'Confirmed';
        $sql = "UPDATE tblbooking SET status=:status,transaction_status=:payment WHERE BookingId=:bcid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':status', $status, PDO::PARAM_STR);
        $query->bindParam(':bcid', $bcid, PDO::PARAM_STR);
        $query->bindParam(':payment', $payment, PDO::PARAM_STR);
        $query->execute();
        $msg = "Booking Confirm successfully";
    }





?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>TMS | Admin manage Bookings</title>
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
        <link rel="stylesheet" type="text/css" href="css/table-style.css" />
        <link rel="stylesheet" type="text/css" href="css/basictable.css" />
        <script type="text/javascript" src="js/jquery.basictable.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#table').basictable();

                $('#table-breakpoint').basictable({
                    breakpoint: 768
                });

                $('#table-swap-axis').basictable({
                    swapAxis: true
                });

                $('#table-force-off').basictable({
                    forceResponsive: false
                });

                $('#table-no-resize').basictable({
                    noResize: true
                });

                $('#table-two-axis').basictable();

                $('#table-max-height').basictable({
                    tableWrapper: true
                });
            });
        </script>
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
                    <li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Manage Bookings</li>
                </ol>
                <div class="agile-grids">
                    <!-- tables -->
                    <?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                    <div class="row">


                        <?php
                        $daysc = $_GET['days'];
                        $idchecked = $_GET['hidden'];
                        $conn = mysqli_connect('localhost', 'root', '', 'tms');
                        $sql = "SELECT * from `tblaccomodations` WHERE `id` = '$idchecked'";
                        $query = mysqli_query($conn, $sql);
                        $rows = mysqli_num_rows($query);
                        if ($rows >= 1) {
                            $cnt = 1;
                            while ($fetch = mysqli_fetch_assoc($query)) {
                                $name = $fetch['name'];
                                $price = $fetch['price'];
                                $packageid = $fetch['packageid'];
                                $picture = $fetch['picture'];
                                $desc = $fetch['description'];
                                $idcheck = $fetch['id'];

                                $totalprice = $daysc * $price;

                        ?>
                                <div class="col-lg-12">
                                    <div class="card">
                                        <img src="../admin/accomodations/<?php echo $picture; ?>" alt="Card image cap">
                                        <div class="card-body" style="padding:1rem">
                                            <h5 class="card-title"><?php echo $name; ?> </h5>
                                            <p>Charges per Night - Kshs. <?php echo $price; ?></p>
                                            <p class="card-text"><?php echo $desc; ?></p>
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <form action="" method="POST">
                                                        <div class="form-group">

                                                            <label for="">Transaction Code</label>
                                                            <input type="text" class="form-control" name="transacode" placeholder="Pay <?php echo $totalprice; ?> and Write the transaction code here" required>
                                                            <br>
                                                            <input type="hidden" name="acc" value="<?php echo $idchecked; ?>">
                                                            <input type="hidden" name="days" value="<?php echo $daysc; ?>">
                                                            <input type="hidden" name="tprice" value="<?php echo $totalprice; ?>">
                                                            <button class="btn btn-primary" type="submit" name="booknow">Book Now</button>
                                                            <?php
                                                            if (isset($_POST['booknow'])) {
                                                                $conn = mysqli_connect('localhost', 'root', '', 'tms');
                                                                $days = mysqli_real_escape_string($conn, $_POST['days']);
                                                                $transacode = mysqli_real_escape_string($conn, $_POST['transacode']);
                                                                $acc = mysqli_real_escape_string($conn, $_POST['acc']);
                                                                $tprice = mysqli_real_escape_string($conn, $_POST['tprice']);
                                                                $codelength = strlen($transacode);

                                                                $useremail =  $_SESSION['tourist'];
                                                                if ($codelength !== 10) {
                                                                    echo "<script>alert('Provide a 10 character code');</script>";
                                                                } else {
                                                                   $checkcode = "SELECT * FROM `accomodationbookings` WHERE `transaction_code`='$transacode'";
                                                                    $querycode = mysqli_query($conn, $checkcode);
                                                                     $queryrows = mysqli_num_rows($querycode);
                                                                    if ($queryrows >= 1) {
                                                                        echo "<script>alert('This code already exists');</script>";
                                                                    } else {

                                                                        $chekcuser = "SELECT * FROM `tblusers` WHERE `EmailId`='$useremail'";
                                                                        $queryuser = mysqli_query($conn, $chekcuser);
                                                                        while ($fetchdata = mysqli_fetch_assoc($queryuser)) {
                                                                            $userid = $fetchdata['id'];
                                                                             $adddata = "INSERT INTO `accomodationbookings`(`user_id`, `acc_id`, `days`, `transaction_code`, `status`) VALUES ('$userid', '$acc','$days','$transacode','pending')";
                                                                            $queryadd = mysqli_query($conn, $adddata);
                                                                            if ($queryadd) {
                                                                                 
                                                                                echo "<script>window.replace('dashboard.php'); </script>";
                                                                            }else{
                                                                              echo "failed";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                        <?php
                            }
                        }

                        ?>

                    </div>
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