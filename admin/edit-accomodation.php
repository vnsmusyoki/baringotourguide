<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:index.php');
} else {
    $conn = mysqli_connect('localhost', 'root', '', 'tms');
    $accomodationcheck = $_GET['acc'];
    $sql = "SELECT * from `tblaccomodations` WHERE `id`='$accomodationcheck'";
    $query = mysqli_query($conn, $sql);
    $rows = mysqli_num_rows($query);
    if ($rows >= 1) {
        $cnt = 1;
        while ($fetch = mysqli_fetch_assoc($query)) {
            $accname = $fetch['name'];
            $accprice = $fetch['price'];
            $accdesc = $fetch['description'];
            $idcheck = $fetch['id'];

            global $accname;
            global $accprice;
            global $accdesc;
            global $idcheck;
        }
    }

    if (isset($_POST['submit'])) {
        $conn = mysqli_connect('localhost', 'root', '', 'tms');
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);
        $destination = mysqli_real_escape_string($conn, $_POST['destination']);
        $description = mysqli_real_escape_string($conn, $_POST['description']); 
        if (!preg_match("/^[a-zA-z ]*$/", $name)) {
            echo "<script>alert('Use valid characters in your name'); </script>";
        } elseif (!preg_match("/^[0-9]*$/", $price)) {
            echo "<script>alert('Use valid characters in your price'); </script>";
        } else {
            if ($_FILES['picture']['name'] == null) {
                $add = "UPDATE  `tblaccomodations` SET `name`='$name', `price`='$price', `packageid`='$destination',  `description`='$description' WHERE `id`='$accomodationcheck'";
                $queryadd = mysqli_query($conn, $add);
                if ($queryadd) {
                    echo "<script>window.location.replace('manage-accomodations.php');</script>";
                }
            } else {
                $filename = $_FILES['picture']['name'];
                $filetmpname = $_FILES['picture']['tmp_name'];
                $filesize = $_FILES['picture']['size'];
                $fileerror = $_FILES['picture']['error'];
                $filetype = $_FILES['picture']['type'];
                $fileext = explode('.', $filename);
                $fileActualExt = strtolower(end($fileext));
                $allowed = array('jpg', 'png', 'jpeg');
                if (in_array($fileActualExt, $allowed)) {
                    if ($fileerror === 0) {
                        if ($filesize > 10000000) {
                            echo "<script>alert('upload too big');</script>";
                        } else {
                            $filenamenew = uniqid('', true) . "." . $fileActualExt;
                            $filedestination = 'accomodations/' . $filenamenew;
                            move_uploaded_file($filetmpname, $filedestination);
                            $add = "UPDATE  `tblaccomodations` SET `name`='$name', `price`='$price', `packageid`='$destination', `picture`='$filenamenew', `description`='$description' WHERE `id`='$accomodationcheck'";
                            $queryadd = mysqli_query($conn, $add);
                            if ($queryadd) {
                                echo "<script>window.location.replace('manage-accomodations.php');</script>";
                            }
                        }
                    } else {
                        echo "<script>alert('An error occurred'); </script>";
                    }
                } else {
                    echo "<script>alert('upload only images with a jpeg or jpg extensions'); </script>";
                }
            }
        }
    }



?>
    <!DOCTYPE HTML>
    <html>

    <head>
        <title>TMS | Edit Accomodation Creation</title>

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
                    <li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Create Accomodation </li>
                </ol>
                <!--grid-->
                <div class="grid-form">

                    <!---->
                    <div class="grid-form1">
                        <h3>Create Package</h3>
                        <?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
                        <div class="tab-content">
                            <div class="tab-pane active" id="horizontal-form">
                                <form class="form-horizontal" name="accomodation" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Accomodation Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control1" name="name" id="name" value="<?php echo $accname; ?>" placeholder="Create Accomodation" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Accomodation Price in kshs</label>
                                        <div class="col-sm-8">
                                            <input type="number" class="form-control1" name="price" value="<?php echo $accprice; ?>" id="price" placeholder="Price per Night in  ksh" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Nearest Site</label>
                                        <div class="col-sm-8">
                                            <select name="destination" id="" class="form-control" required>
                                                <option value="">Select nearest Destination</option>
                                                <?php
                                                $conn = mysqli_connect('localhost', 'root', '', 'tms');
                                                $packages = "SELECT * FROM `tbltourpackages`";
                                                $querypackage = mysqli_query($conn, $packages);
                                                $packagrrows = mysqli_num_rows($querypackage);
                                                if ($packagrrows >= 1) {
                                                    while ($fetch = mysqli_fetch_assoc($querypackage)) {
                                                        $packagename = $fetch['PackageName'];
                                                        $packageid = $fetch['PackageId'];
                                                        echo "<option value='$packageid'>$packagename</option>";
                                                    }
                                                }
                                                ?>
                                            </select>


                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Accomodation Details</label>
                                        <div class="col-sm-8">
                                            <textarea class="form-control" rows="5" cols="50" name="description" id="description" placeholder="Accomodation Details" required><?php echo $accdesc; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="focusedinput" class="col-sm-2 control-label">Accomodation Image</label>
                                        <div class="col-sm-8">
                                            <input type="file" name="picture" id="picture">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-8 col-sm-offset-2">
                                            <button type="submit" name="submit" class="btn-danger btn">Update Accomodation</button>

                                        </div>
                                    </div>
                            </div>

                            </form>
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