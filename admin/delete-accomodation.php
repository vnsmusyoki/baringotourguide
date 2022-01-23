<?php 
$conn = mysqli_connect('localhost', 'root', '', 'tms');
$accomodationcheck = $_GET['acc'];
$sql = "DELETE from `tblaccomodations` WHERE `id`='$accomodationcheck'";
$query = mysqli_query($conn, $sql);
$rows = mysqli_num_rows($query);
if($query){
    echo "<script>window.location.replace('manage-accomodations.php');</script>";
}