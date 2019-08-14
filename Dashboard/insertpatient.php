<?php
session_start();
require '../config.php';
if(!isset($_SESSION['id']))
{
    header("Location:../index.php?msg=Please login first");
}
    
    $followupid=$_POST['followupid'];
    $Appointmentdate=$_POST['Appointmentdate'];
    $Appointmenttime=$_POST['Appointmenttime'];
    $firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
	$email=$_POST['email'];
	$birthdate=$_POST['birthdate'];
    $disease=$_POST['disease'];
    $mobileno=$_POST['mobileno'];
    $discription=$_POST['discription'];
    $status = "Pending";
    
    $createddate = date('y-m-d h:i:s');

    $adate = strtotime($Appointmentdate);
    
    $appointmentdate = date("Y-m-d", $adate);

    $userid = $_SESSION['id'];
    $timestamp = strtotime($birthdate);
    $dob = date("Y-m-d", $timestamp);
    
    $FinalDate=explode("to",$Appointmenttime);
    $StartTime=$FinalDate[0];
    $EndTime=$FinalDate[1];

    $sttime  = date("H:i", strtotime($StartTime));
    $edtime  = date("H:i", strtotime($EndTime));
    
   
    if($followupid != null)
    {
        $sql = "CALL sp_bookappointment($userid,
        '".strval($firstname)."',
        '".strval($lastname)."',
        '".strval($email)."',
        '".strval($dob)."',
        '".strval($mobileno)."',
        '".strval($appointmentdate)."',
        '".strval($sttime)."',
        '".strval($edtime)."',
        ".strval($disease).",
        '".strval($discription)."',
        $followupid)";
    }
    else
    {
        $sql = "CALL sp_bookappointment($userid,
        '".strval($firstname)."',
        '".strval($lastname)."',
        '".strval($email)."',
        '".strval($dob)."',
        '".strval($mobileno)."',
        '".strval($appointmentdate)."',
        '".strval($sttime)."',
        '".strval($edtime)."',
        ".strval($disease).",
        '".strval($discription)."',
        NULL)";
    }
    
    if(mysqli_query($con, $sql))
    {
        require("../phpmailer/class.phpmailer.php");
        require("../phpmailer/class.smtp.php");

        $mess   = '<p>Hi '.$firstname.' '.$lastname.', <br><br>
                Your Appointment is booked for '.$Appointmentdate.' and '.$Appointmenttime.' <br><br>
                Please stay on call at above specific date and time. <br><br>
                Thanks,<br>
                AyurnatureCare 
                </p>';

        mysqli_close($con);
        require '../config.php';       
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
        $mail->FromName = 'Online Consult Doctor - Appointment Booked';

        
        $mail->AddAddress($email);
        //Address to which recipient will reply
        $mail->addReplyTo($email_row['smtp_username'], "Reply");

        //CC and BCC
        $mail->addCC($email_row['add_ccemail']);
        $mail->addBCC($email_row['add_bccemail']);
        $mail->IsHTML(true);                                  
        $mail->Subject = 'Thank You for Appointment Booked';
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
            $successmsg = "Message has been sent check your email";
        }  
        
        $api_key = '45D38103C0CB3B';
        $contacts = $mobileno;
        $from = 'WEBTXT';
        $sms_text = urlencode('Hi '.$firstname.' '.$lastname.', 
                            Your Appointment is booked for '.$Appointmentdate.' and '.$Appointmenttime.'
                            Please stay on call at above specific date and time. 
                            Thanks,
                            AyurnatureCare');

        $api_url = "http://sms.textmysms.com/app/smsapi/index.php?key=".$api_key."&campaign=0&routeid=13&type=text&contacts=".$contacts."&senderid=".$from."&msg=".$sms_text;

        //Submit to server

        $response = file_get_contents( $api_url);
        echo $response;

        echo json_encode(array("statusCode"=>200));

        }
    }
    else{
        echo json_encode(array("statusCode"=>201));
    }

?>