<?php
session_start();
require 'config.php';
if(isset($_SESSION['id']))
{
    header("Location:Dashboard/index.php?msg=you have already login");
}

$email = "";
$resendmsg = "";
$username= "";
$eroormsg = "";
$emailstatus = "";

if(isset($_GET['emailstatus']))
{
	$emailstatus= $_GET['emailstatus'];
}

if(isset($_GET['resendmsg']))
{
	$resendmsg= $_GET['resendmsg'];
	unset($emailstatus);
}
if(isset($_GET['email']))
{
	$email= $_GET['email'];
}
if(isset($_GET['username']))
{
	$username= $_GET['username'];
}	

if(isset($_POST['submit']))
{
	$username = $_POST['username'];
	$email = $_POST['email'];
	$type = "user";
	$status = 0;
	
	$sql = "SELECT `username`, `email` FROM `tbl_user` WHERE `email`='".$email."' AND `username`='".$username."' AND `status`=$status AND `type`='".$type."'";

	$res = mysqli_query($con,$sql);
	if(mysqli_num_rows($res)>0)
	{
		$row=mysqli_fetch_assoc($res);
		$username=$row['username'];
		$email=$row['email'];
		
		require("phpmailer/class.phpmailer.php");
		require("phpmailer/class.smtp.php");

		$link="<a href='http://localhost/doctor/varifyemail.php?key=".$email."'>Click To Verify your email address</a>";
	

		$mess   = '<p>Hi '.$username.', <br><br>
               <p>Click to following link to varify Your Account</p>'.$link.'<br><br>
                Thanks,<br>
                AyurnatureCare 
                </p>';

			mysqli_close($con);
	        require 'config.php';       
	        $email_query= "SELECT * FROM `tb_email_configuration` WHERE `status`='Active'";

	        $email_res = mysqli_query($con,$email_query);

	        if(mysqli_num_rows($email_res)>0)
	        {
	        	
	            $email_row=mysqli_fetch_assoc($email_res);     
	                
	            $mail = new PHPMailer;

				$mail->IsSMTP();  
				$mail->Host = $email_row['smtp_host'];                 
				$mail->Port = $email_row['smtp_port'];
				$mail->SMTPAuth = true;                               
				$mail->Username = $email_row['smtp_username'];   
				$mail->Password = $email_row['smtp_password'];

				$mail->From = $email_row['smtp_username'];
				$mail->FromName = 'Online Consult Doctor - Verify Account';      

				$mail->AddAddress($email);
				$mail->IsHTML(true);                                  
				$mail->Subject = 'Verify Account';
				$mail->Body = $mess;
				
				$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				$mail->SMTPOptions = array(
		            'ssl' => array(
		                'verify_peer' => true,
		                'verify_peer_name' => true,
		                'allow_self_signed' => true
		            )
		        );
				
				if(!$mail->Send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					$successmsg = "Message has been Resent check once Again";
				}

				$id= mysqli_insert_id($con);
				/*$_SESSION['id']=$id;*/
				header("Location:successmessage.php?resendmsg=Message has been Resent check once Again");
				exit();

			}
	}
	else
	{
		$eroormsg = "Please enter valid email address";
	}

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
						Verify Email
					</span>
					<?php 
					if(isset($resendmsg)){
						echo '<h6 id="sucessmsg">'.$resendmsg.'</h6>';	
					}
					if(isset($emailstatus)){ echo '<h6 id="sucessmsg">Message has been sent check your email and verify </h6>';} 
					?>	
					
					<input type="hidden" name="username" value="<?php  echo $username; ?>">

					<input type="hidden" name="email" value="<?php echo $email; ?>">

					<div class="container-login100-form-btn" style="padding-bottom: 20px;">
						<input class="login100-form-btn" type="submit" name="submit" value="Resend email">
					</div>

					<div class="flex-col-c p-t-25 p-b-40">
						<span class="txt1 p-b-9">
							Back to <a href="index.php" class="txt3">
							Sign In
						</a>
						</span>
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