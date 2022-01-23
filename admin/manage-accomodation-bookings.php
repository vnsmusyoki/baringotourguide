<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
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
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
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
					<li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Bookings</li>
				</ol>
				<div class="agile-grids">
					<!-- tables -->
					<?php if ($error) { ?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php } ?>
					<div class="card table-responsive">
						<table class="display" id="exampleds">
							<thead>
								<tr>
									<th>#</th>
									<th>User</th>
									<th>Phone Number</th>
									<th>Email Address</th>
									<th>Accomodation</th>
									<th>Duration</th>
									<th>Per Night</th>
									<th>Total Paid</th> 
									<th>Transaction Code</th>
									<th>Tour Status</th> 
								</tr>
							</thead>
							<tbody style="font-size: 12px;">
								<?php
								$conn = mysqli_connect('localhost', 'root', '', 'tms');
								$sql = "SELECT * from `accomodationbookings`";
								$querysql = mysqli_query($conn, $sql);
								$querysqlrows = mysqli_num_rows($querysql);
								if ($querysqlrows) {
									$cnt = 1;
									while ($fetch = mysqli_fetch_assoc($querysql)) {
										$userid = $fetch['user_id'];
										$accid = $fetch['acc_id'];
										$days = $fetch['days']; 
										$transcode = $fetch['transaction_code'];
										$status = $fetch['status']; 

										$packagedetails = "SELECT * from `tblaccomodations` WHERE `id`='$accid'";
										$querypackagedetails = mysqli_query($conn, $packagedetails);
										$querypackagedetailsrows = mysqli_num_rows($querypackagedetails);
										if ($querypackagedetailsrows >= 1) {
											while ($fetchdata = mysqli_fetch_assoc($querypackagedetails)) {
												$accname = $fetchdata['name'];
												$accprice = $fetchdata['price'];
											}
										}
										$userbooking = "SELECT * from `tblusers` WHERE `EmailId`='$bookingemail'";
										$queryuserbooking = mysqli_query($conn, $userbooking);
										$queryuserbookingrows = mysqli_num_rows($queryuserbooking);
										if ($queryuserbookingrows >= 1) {
											while ($fetchuser = mysqli_fetch_assoc($queryuserbooking)) {
												$username = $fetchuser['FullName'];
												$usermobile = $fetchuser['MobileNumber'];
												$useremail = $fetchuser['EmailId'];
											}
										}

								 
										echo "
                                        
                                            <tr>
                                                <td>$cnt</td>
                                                <td>$bookingname</td>
                                                <td>$bookingnumber</td>
                                                <td>$bookingemail</td>
                                                <td><a href='update-package.php?pid=$packagebooked'>$packagename</a></td>
                                                <td>Kshs. $packageprice</td>
                                                <td>$fromdate</td>
                                                <td>$todate</td>
                                                <td>$comment</td>
                                                <td style='text-transform:uppercase;'>$transcode</td>
                                                <td>$statusverdict</td>
                                                <td><a href='manage-bookings.php?bkid=$bookingid' onclick='return confirm('Do you really want to cancel booking')'><span class='badge badge-danger'>Cancel</span></a> / <a href='manage-bookings.php?bckid=$bookingid' onclick='return confirm('booking has been confirm')'><span class='badge badge-success'>Confirm</span></a></td>
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