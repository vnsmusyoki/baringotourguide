<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (!isset($_SESSION['tourist'])) {
    header('location:../signin.php');
} else {
?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>TMS | Tourist Browse Packages</title>
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
        <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <!-- Custom CSS -->
        <link href="css/style.css" rel='stylesheet' type='text/css' />
        <link rel="stylesheet" href="css/morris.css" type="text/css" />
        <!-- Graph CSS -->
        <link href="css/font-awesome.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="js/jquery-2.1.4.min.js"></script>
        <!-- //jQuery -->
        <!-- tables -->
        <!-- <link rel="stylesheet" type="text/css" href="css/table-style.css" /> -->
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
        <!-- //tables -->
        <link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
        <link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <!-- lined-icons -->
        <link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
        <!-- //lined-icons -->
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
                    <li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>My Trips</li>
                </ol>
                <div class="card">
                    <!-- tables -->
                    <div class="table-responsive">
                        <table class="display" id="exampleds">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Destination</th>
                                    <th>Price</th>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Description</th>
                                    <th>Transaction Code</th>
                                    <th>Tour Status</th>
                                    <th>Payment Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $user = $_SESSION['tourist'];
                                $conn = mysqli_connect('localhost', 'root', '', 'tms');
                                $sql = "SELECT * from `tblbooking` WHERE `UserEmail`='$user'";
                                $querysql = mysqli_query($conn, $sql);
                                $querysqlrows = mysqli_num_rows($querysql);
                                if ($querysqlrows) {
                                    $cnt = 1;
                                    while ($fetch = mysqli_fetch_assoc($querysql)) {
                                        $fromdate = $fetch['FromDate'];
                                        $todate = $fetch['ToDate'];
                                        $comment = $fetch['Comment'];
                                        $regdate = $fetch['RegDate'];
                                        $transcode = $fetch['transaction_code'];
                                        $status = $fetch['status'];
                                        $transstatus = $fetch['transaction_status'];
                                        $packagebooked = $fetch['PackageId'];

                                        $packagedetails = "SELECT * from `tbltourpackages` WHERE `PackageId`='$packagebooked'";
                                        $querypackagedetails = mysqli_query($conn, $packagedetails);
                                        $querypackagedetailsrows = mysqli_num_rows($querypackagedetails);
                                        if ($querypackagedetailsrows >= 1) {
                                            while ($fetchdata = mysqli_fetch_assoc($querypackagedetails)) {
                                                $packagename = $fetchdata['PackageName'];
                                                $packageprice = $fetchdata['PackagePrice'];
                                            }
                                        }

                                        if ($status == 1) {
                                            $statusverdict = "Confirmed";
                                        } else if ($status == 2) {
                                            $statusverdict = "Cancelled";
                                        } else {
                                            $statusverdict = "Waiting";
                                        }

                                        echo "
                                        
                                            <tr>
                                                <td>$cnt</td>
                                                <td>$packagename</td>
                                                <td>$packageprice</td>
                                                <td>$fromdate</td>
                                                <td>$todate</td>
                                                <td>$comment</td>
                                                <td style='text-transform:uppercase;'>$transcode</td>
                                                <td>$statusverdict</td>
                                                <td>$transstatus</td>
                                            </tr>
                                        ";
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
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
        <script src="js/datatables/custom-basic.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#exampleds').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'print'
                    ]
                });
            });
        </script>
    </body>

    </html>
<?php } ?>