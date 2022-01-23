<?php 
$conn = mysqli_connect('localhost', 'root', '', 'tms');
$accomodationcheck = $_GET['acc'];
$sql = "UPDATE `accomodationbookings` SET `status`='denied' WHERE `id`='$accomodationcheck'";
$query = mysqli_query($conn, $sql);
if($query){
    echo "<script>window.location.replace('manage-accomodation-bookings.php');</script>";
}