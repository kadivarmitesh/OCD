<?php
session_start();
require '../../../config.php';
if(!isset($_SESSION['id']))
{
    header("Location: login.php?msg=Please login first");
}

$adminid=$_POST['adminid'];
$username=$_POST['username'];
$email=$_POST['email'];
$mobileno=$_POST['mobileno'];

$updatedate = date('y-m-d h:i:s');

$sql = "UPDATE `tbl_user` SET `username`='".$username."',`email`='".$email."',`mobileno`='".$mobileno."',`updatedate`='".$updatedate."' WHERE `id`=$adminid";
    if(mysqli_query($con, $sql))
    {
        echo json_encode(array("statusCode"=>200));
    }
    else{
        echo json_encode(array("statusCode"=>201));
    }

?>