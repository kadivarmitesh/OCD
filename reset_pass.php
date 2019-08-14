<?php
session_start();
if(isset($_GET['key']) && $_GET['reset'])
{
  $_SESSION['email'] = $_GET['key'];
  $pass=$_GET['reset'];

}
$email = $_SESSION['email'];
$msg="";
if(isset($_GET['msg']))
{
	$msg = $_GET['msg'];
}
$successmsg= "";
if(isset($_GET['successmsg']))
{
	$successmsg = $_GET['successmsg'];
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
				<form method="post" action="submit_new.php" class="login100-form validate-form p-l-55 p-r-55 p-t-110">
					<span class="login100-form-title">
						Reset Password
					</span>
					<?php if(isset($_GET['msg'])){ echo '<h6 id="eroormsg">'.$msg.'</h6>'; } ?>	

					<?php if(isset($_GET['successmsg'])){ echo '<h6 id="successmsg" class="text-success">'.$successmsg.'</h6>'; } ?>					
					<input type="hidden" name="email" value="<?php echo $email;?>">												
					<div class="wrap-input100 validate-input m-b-16" data-validate = "Please enter password">
						<input class="input100" type="password" name="pass" placeholder="New Password">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-16" data-validate = "Please confirm enter password">
						<input class="input100" type="password" name="confirmpass" placeholder="New confirm Password">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn">
						<input class="login100-form-btn" type="submit" name="submit_password" value="Submit Password">
					</div>

					<div class="flex-col-c p-t-25 p-b-40">
						
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
	<script type="text/javascript">
		var smsg = document.getElementById("successmsg");
        if (smsg) {
        	 window.setTimeout(function(){

        	// Move to a new location or you can do something else
		        window.location.href = "index.php";

		    }, 2000);
        } else {
           // element doesn't exist
        }
	</script>

</body>
</html>