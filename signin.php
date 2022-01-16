<?php
session_start();
include('includes/config.php');
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $sql = "SELECT EmailId,Password FROM tblusers WHERE EmailId=:email and Password=:password";
    $query = $dbh->prepare($sql);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->execute();
    $results = $query->fetchAll(PDO::FETCH_OBJ);
    if ($query->rowCount() > 0) {
        $_SESSION['tourist'] = $_POST['email'];
        echo "<script type='text/javascript'> document.location = 'tourist/dashboard.php'; </script>";
    } else {

        echo "<script>alert('Invalid Details');</script>";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <title>Baringo county | Tourism Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- Custom Theme files -->
    <script src="js/jquery-1.12.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!--animate-->
    <link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
    <script src="js/wow.min.js"></script>
    <script>
        new WOW().init();
    </script>
    <!--//end-animate-->
    <style>
        body {
            font-family: "Lato", Arial, sans-serif;
            font-size: 16px;
            line-height: 1.8;
            font-weight: normal;
            background: #f8f9fd;
            color: gray;
            height: 100vh;
            padding: 7rem 0;
        }

        form {
            width: 25vw;
            height: 50vh;
            border-radius: 8px;
            position: relative;
            background: #fff;
            border-radius: 10px;
            margin-left: 40vw;
            padding: 2rem 1rem;
            -webkit-box-shadow: 0px 10px 34px -15px rgb(0 0 0 / 24%);
            -moz-box-shadow: 0px 10px 34px -15px rgba(0, 0, 0, 0.24);
            box-shadow: 0px 10px 34px -15px rgb(0 0 0 / 24%);
        }

        form h3 {
            margin-bottom: 1rem;
            text-transform: uppercase;
            text-align: center;
        }

        form p {
            margin-bottom: 1rem;
        }

        form h4 {
            margin-top: 1rem;
        }
    </style>
</head>

<body>


    <form method="post" class="p-4 p-md-5">
        <h3>Have an Account? </h3>
        <hr>
        <input type="text" name="email" id="email" placeholder="Enter your Email" required="" class="form-control">
        <br>
        <input type="password" name="password" id="password" placeholder="Password" value="" required="" class="form-control">
        <h4><a href="forgot-password.php">Forgot password</a></h4>

        <input type="submit" name="signin" value="SIGNIN" class="btn btn-primary rounded p-3 btn-block mt-4">

        <p><a href="index.php">Return to HomePage</a></p>
        <?php
        include('includes/config.php');
        if (isset($_POST['submituser'])) {
            $fname = $_POST['fname'];
            $mnumber = $_POST['mobilenumber'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $phonelength = strlen($mnumber);
            $passwordlength = strlen($password);
            if (!preg_match("/^[a-zA-z ]*$/", $fname)) {
                echo "<script>alert('Use valid characters in your name'); </script>";
            } elseif (!preg_match("/^[0-9]*$/", $mnumber)) {
                echo "<script>alert('Use valid characters in your phone Number'); </script>";
            } else if ($phonelength !== 10) {
                echo "<script>alert('Phone Number must have 10 digits'); </script>";
            } else if ($passwordlength < 6) {
                echo "<script>alert('Password requires 6 characters minimum'); </script>";
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<script>alert('invalid email address'); </script>";
            } else {
                $conn = mysqli_connect('localhost', 'root', '', 'tms');
                $checkuser = "SELECT *  FROM `tblusers` WHERE `MobileNumber` = '$mnumber' OR `EmailId`='$email'";
                $queryusers = mysqli_query($conn, $checkuser);
                $checkuserrows = mysqli_num_rows($queryusers);
                if ($checkuserrows >= 1) {
                    echo "<script>alert('Email Address or Phone Number already exists'); </script>";
                } else {
                    $password = md5($password);
                    $sql = "INSERT INTO  tblusers(FullName,MobileNumber,EmailId,Password) VALUES(:fname,:mnumber,:email,:password)";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
                    $query->bindParam(':mnumber', $mnumber, PDO::PARAM_STR);
                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                    $query->bindParam(':password', $password, PDO::PARAM_STR);
                    $query->execute();
                    $lastInsertId = $dbh->lastInsertId();
                    if ($lastInsertId) {
                        $_SESSION['msg'] = "You are Scuccessfully registered. Now you can login ";
                        header('location:thankyou.php');
                    } else {
                        $_SESSION['msg'] = "Something went wrong. Please try again.";
                        header('location:thankyou.php');
                    }
                }
            }
        }
        ?>

        <script>
            function checkAvailability() {

                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'emailid=' + $("#email").val(),
                    type: "POST",
                    success: function(data) {
                        $("#user-availability-status").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function() {}
                });
            }
        </script>

</body>

</html>