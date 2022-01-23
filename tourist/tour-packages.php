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
					<li class="breadcrumb-item"><a href="index.php">Home</a><i class="fa fa-angle-right"></i>Browse Packages</li>
				</ol>
				<div class="row">


					<?php

					$conn = mysqli_connect('localhost', 'root', '', 'tms');
					$sql = "SELECT * from `tbltourpackages`";
					$query = mysqli_query($conn, $sql);
					$rows = mysqli_num_rows($query);
					if ($rows >= 1) {
						$cnt = 1;
						while ($fetch = mysqli_fetch_assoc($query)) {
							$packagename = $fetch['PackageName'];
							$packagetype = $fetch['PackageType'];
							$packagelocation = $fetch['PackageLocation'];
							$packageprice = $fetch['PackagePrice'];
							$packagefeatures = $fetch['PackageFeatures'];
							$packageid = $fetch['PackageId'];
							$packagdedetails = $fetch['PackageDetails'];
							$image = $fetch['PackageImage'];

					?>
							<div class="col-lg-4">
								<div class="card">
									<img src="../admin/packageimages/<?php echo $image; ?>" alt="Card image cap" style="width:100%;height:25vh;">
									<div class="card-body" style="padding:1rem">
										<h5 class="card-title"><?php echo $packagename; ?> </h5>
										<p>Charges per Night - Kshs. <?php echo $packageprice; ?></p>
										<p class="card-text"><?php echo $packagelocation; ?></p>
										<a href="book-package.php?package=<?php echo $packageid; ?>" class="btn btn-primary">Book Now</a>
									</div>
								</div>
							</div>

					<?php
						}
					}

					?>

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