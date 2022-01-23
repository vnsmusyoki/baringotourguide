<?php
$conn = mysqli_connect('localhost', 'root', '', 'tms');
$accomodationcheck = $_GET['acc'];
$sql = "DELETE from `accomodationbookings` WHERE `id`='$accomodationcheck'";
$query = mysqli_query($conn, $sql);
if ($query) {
    echo "<script>window.location.replace('dashboard.php');</script>";
}
