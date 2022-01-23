<?php
session_start();
include('includes/config.php');
if (!isset($_SESSION['tourist'])) {
	header('location:../signin.php');
} else {
?>
	<!DOCTYPE HTML>
	<html>

	<head>
		<title>TMS | Tourist Dashboard</title>
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
		<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css' />
		<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<!-- lined-icons -->
		<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
		<!-- //lined-icons -->
		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css">
	</head>

	<body>
		<div class="page-container">
			<!--/content-inner-->
			<div class="left-content">
				<div class="mother-grid-inner">
					<!--header start here-->
					<?php include('includes/header.php'); ?>
					<!--header end here-->
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="../index.php">Home</a> <i class="fa fa-angle-right"></i></li>
					</ol>
					<div class="agile-grids">
						<!-- tables -->

						<div class="card table-responsive">
							<table class="display" id="exampleds">
								<thead>
									<tr>

										<th>User</th>
										<th>Phone Number</th>
										<th>Email Address</th>
										<th>Accomodation</th>
										<th>Duration</th>
										<th>Per Night</th>
										<th>Total Paid</th>
										<th>Transaction Code</th>
										<th>Tour Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody style="font-size: 12px;">
									<?php
									$conn = mysqli_connect('localhost', 'root', '', 'tms');
									 $useremail =  $_SESSION['tourist'];
									 $chekcuser = "SELECT * FROM `tblusers` WHERE `EmailId`='$useremail'";
									 $queryuser = mysqli_query($conn, $chekcuser);
									 while ($fetchdata = mysqli_fetch_assoc($queryuser)) {
										 $userid = $fetchdata['id'];
										 
									 }
									
									$sql = "SELECT * from `accomodationbookings` WHERE `user_id`='$userid'";
									$querysql = mysqli_query($conn, $sql);
									$querysqlrows = mysqli_num_rows($querysql);
									if ($querysqlrows) {

										while ($fetch = mysqli_fetch_assoc($querysql)) {
											
											$accid = $fetch['acc_id'];
											$days = $fetch['days'];
											$transcode = $fetch['transaction_code'];
											$status = $fetch['status'];
											$recordid = $fetch['id'];

											$packagedetails = "SELECT * from `tblaccomodations` WHERE `id`='$accid'";
											$querypackagedetails = mysqli_query($conn, $packagedetails);
											$querypackagedetailsrows = mysqli_num_rows($querypackagedetails);
											if ($querypackagedetailsrows >= 1) {
												while ($fetchdata = mysqli_fetch_assoc($querypackagedetails)) {
													$accname = $fetchdata['name'];
													$accprice = $fetchdata['price'];

													$totalpaid = $accprice * $days;
												}
											}
											$userbooking = "SELECT * from `tblusers` WHERE `id`='$userid'";
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
                                             
                                                <td>$username</td>
                                                <td>$usermobile</td>
                                                <td>$useremail</td>
                                                <td><a >$accname</a></td>
                                                <td>$days</td>
                                                <td>Kshs. $accprice</td>
                                                <td>$totalpaid</td>
                                                <td>$transcode</td>
                                                <td>$status</td> 
                                                <td><a href='delete-accomodation.php?acc=$recordid'>Delete</span></a></td>
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
			
					</div>
					<!--inner block end here-->
					<!--copy rights start here-->
					<?php include('includes/footer.php'); ?>
				</div>
			</div>

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