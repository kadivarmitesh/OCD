<?php
session_start();
require 'config.php';
if(isset($_SESSION['id']))
{
    header("Location:Dashboard/index.php?msg=you have already login");
}

if(isset($_POST['submit']))
{
	$email = $_POST['email'];
		
	$sql = "UPDATE `tbl_user` SET `status`=1 WHERE `email`='".$email."'";
	if(mysqli_query($con, $sql))
	{
	    header("Location: index.php?verifymsg=Account verify Successfull please login here");
	}
	else{
	    $eroormsg = "Something wrong Please try again";
	}
}

$key="";
if(isset($_GET['key']))
{
	$key = $_GET['key'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Online Consult Doctor</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form method="post" action="#" class="login100-form validate-form p-l-55 p-r-55 p-t-110">
					<span class="login100-form-title">
						Verify Email Account
					</span>
					<?php  if(isset($_GET['key'])){ echo '<h6 id="sucessmsg"> Your email  <b>'.$key.'</b> click to varify.</h6>';} 
					?>						

					<div class="wrap-input100 validate-input" data-validate = "Enter correct password">
						<input class="input100" type="hidden" name="email" autocomplete="off" value="<?php echo $key; ?>" maxlength="20">
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn" style="padding-bottom: 20px;">
						<input class="login100-form-btn" type="submit" name="submit" value="Click to verify">
					</div>

				</form>
			</div>
		</div>
	</div>
	
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>