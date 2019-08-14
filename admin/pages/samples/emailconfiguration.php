<?php
session_start();
require '../../../config.php';
if(!isset($_SESSION['id']))
{
    header("Location: login.php?msg=Please login first");
}

if(isset($_SESSION['id']))
{

  $id =$_SESSION['id'];
  $sessionqry = "SELECT * FROM `tbl_user` WHERE `id`=$id AND `type`='admin'";

  $sessionres = mysqli_query($con,$sessionqry); 
  $sessionrow = mysqli_fetch_assoc($sessionres);
  
}

$successmsg = "";
$msg="";
$updatemsg="";
$deletemsg="";
$eroormsg = "";
if(isset($_POST['submit']))
{
  $smtp_host = $_POST['smtp_host'];
  $smtp_port = $_POST['smtp_port'];
  $smtp_username = $_POST['smtp_username'];
  $smtp_password = $_POST['smtp_password'];
  $ccemail = $_POST['add_ccemail'];
  $bccemail = $_POST['add_bccemail'];
  $status = $_POST['status'];
  $createddate = date('y-m-d h:i:s');
 
  $sql="INSERT INTO `tb_email_configuration`(`smtp_host`, `smtp_port`, `smtp_username`, `smtp_password`, `add_ccemail`, `add_bccemail` , `status`, `createdate`) VALUES ('".$smtp_host."',$smtp_port,'".$smtp_username."','".$smtp_password."','".$ccemail."','".$bccemail."','".$status."','".$createddate."')";
  
  if(mysqli_query($con, $sql))
  {
    header("Location: emailconfiguration.php?msg=Configuration add successfull");
    exit();
  }
  else{
    $eroormsg = "Something wrong Please try again";
  }
  
}

// edit email setting
if(isset($_GET['id']))
{

  $id =$_GET['id'];
  $qry = "SELECT * FROM `tb_email_configuration` WHERE `id`=$id";

  $res = mysqli_query($con,$qry); 
  $row = mysqli_fetch_assoc($res);
  
}
//update email setting
if(isset($_POST['update']))
{
  if(isset($_GET['id']))
  {
    $emailid = $_GET['id'];
  }
  $smtp_host = $_POST['smtp_host'];
  $smtp_port = $_POST['smtp_port'];
  $smtp_username = $_POST['smtp_username'];
  $smtp_password = $_POST['smtp_password'];
  $ccemail = $_POST['add_ccemail'];
  $bccemail = $_POST['add_bccemail'];
  $status = $_POST['status'];
  $updatedate = date('y-m-d h:i:s');

  $update = "UPDATE `tb_email_configuration` SET `smtp_host`='".$smtp_host."',`smtp_port`=$smtp_port,`smtp_username`='".$smtp_username."',`smtp_password`='".$smtp_password."',`add_ccemail`='".$ccemail."',`add_bccemail`='".$bccemail."',`status`='".$status."',`updatedate`='".$updatedate."' WHERE `id`=$emailid";
  if(mysqli_query($con, $update))
  {
    header("Location: emailconfiguration.php?updatemsg=Updated Successfull");
    $successmsg = "Updated Successfull";
    exit();
  }
  else{
    $eroormsg = "Something wrong Please try again";
  }

}

// Delete email setting
if(isset($_POST['delete']))
{
  $did = $_POST['deleteid'];
  $delete = "DELETE FROM `tb_email_configuration` WHERE `id`= $did";
  if(mysqli_query($con, $delete))
  {
    header("Location: emailconfiguration.php?deletemsg=Deleted Successfull");
    $successmsg = "Deleted Successfull";
    exit();
  }
  else{
    $eroormsg = "Something wrong Please try again";
  }

}

?>

  <?php include_once('header.php');  ?>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
                <div class="col-12 grid-margin">
                        <div class="card">
                          <div class="card-body">
                            <h2 class="text-center">Email configuration</h2><hr>
                            <form method="post" action="#" class="form-sample">
                              <div class="row">	
                                <div class="col-md-12">
                                  <?php
                                  if(isset($_GET['msg']))
                                  {
                                    $msg= $_GET['msg'];
                                    echo "<div class='alert alert-success text-center' role='alert'>$msg</div>";
                                  }
                                  if(isset($_GET['deletemsg']))
                                  {
                                    $deletemsg= $_GET['deletemsg'];
                                    echo "<div class='alert alert-success text-center' role='alert'>$deletemsg</div>";
                                  }
                                  if(isset($_GET['updatemsg']))
                                  {
                                    $updatemsg= $_GET['updatemsg'];
                                    echo "<div class='alert alert-success text-center' role='alert'>$updatemsg</div>";
                                  }
                                  ?>
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">smtp_host</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="smtp_host" autocomplete="off"  class="form-control"  placeholder="eg:smtp1.example.com" required="required" value="<?php if(isset($_GET['id'])){ echo $row['smtp_host']; }  ?>" ondrop="return false;">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">smtp_port</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="smtp_port" autocomplete="off" onKeyPress="return isNumberKey(event);" class="form-control"  placeholder="eg:587" minlength="3" maxlength="3" required="required" value="<?php if(isset($_GET['id'])){ echo $row['smtp_port']; }  ?>" ondrop="return false;">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">smtp_username</label>
                                    <div class="col-sm-9">
                                      <input type="email" name="smtp_username" autocomplete="off"  class="form-control"  placeholder="eg:user@example.com" required="required" value="<?php if(isset($_GET['id'])){ echo $row['smtp_username']; }  ?>" ondrop="return false;">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">smtp_password</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="smtp_password" autocomplete="off"  class="form-control"  placeholder="Enter smtp_password" required="required" value="<?php if(isset($_GET['id'])){ echo $row['smtp_password']; }  ?>" ondrop="return false;">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">add_ccemail</label>
                                    <div class="col-sm-9">
                                      <input type="email" name="add_ccemail" autocomplete="off"  class="form-control"  placeholder="eg:cc@example.com" value="<?php if(isset($_GET['id'])){ echo $row['add_ccemail']; }  ?>" ondrop="return false;">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">add_bccemail</label>
                                    <div class="col-sm-9">
                                      <input type="email" name="add_bccemail" autocomplete="off"  class="form-control"  placeholder="eg:bcc@example.com" value="<?php if(isset($_GET['id'])){ echo $row['add_bccemail']; }  ?>" ondrop="return false;">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">status</label>
                                    <div class="col-sm-9">
                                     <select name="status" class="form-control" id="status" required="required">
                                          <option value="Active" <?php if(isset($_GET['id'])){ if($row['status']=='Active') { echo 'selected';}  } ?>>Active</option>
                                          <option value="Deactive" <?php if(isset($_GET['id'])){ if($row['status']=='Deactive') { echo 'selected';}  } ?>>Deactive</option>
                                     </select>
                                    </div>
                                  </div>
                                </div>
                                </div>
                                <?php
                                  if(isset($_GET['id']))
                                  {
                                    echo '<input class="btn btn-gradient-success mb-2 float-right" type="submit" name="update" data-toggle="tooltip" class="tip-bottom" title="Update configuration"  value="Update">';
                                  }
                                  else
                                  {
                                    echo '<input class="btn btn-gradient-success mb-2 float-right" type="submit" name="submit" data-toggle="tooltip" class="tip-bottom" title="Add configuration"  value="Add">';
                                  }
                                ?>
                                
                            </form>
                          </div>
                        </div>
              </div>
            <div class="row">
            <div class="col-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h2 class="text-center">configuration Details</h2><hr>
                  <p class="text-danger"><b>Note * :</b> Must have only one Email configuration Active for seding email credentials.</p>
                  <div class="table-responsive">
                    <table id="zero_config" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                               <th>#</th>
                               <th>Smtp Host</th>
                               <th>Smtp Port</th>
                               <th>Smtp Username</th>
                               <th>Smtp Password</th>
                               <th>CCemail</th>
                               <th>BCCemail</th>
                               <th>Status</th>
                              <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            $sql = "SELECT * FROM `tb_email_configuration`";
                            $res = mysqli_query($con,$sql);
                            $number = 1;
                            while ($row=mysqli_fetch_assoc($res)):
                          ?>
                            <tr>
                              <td><?php echo $number; ?></td>
                              <td><?php echo $row['smtp_host']; ?></td>
                              <td><?php echo $row['smtp_port']; ?></td>
                              <td><?php echo $row['smtp_username']; ?></td>
                              <td><?php echo $row['smtp_password']; ?></td>
                              <td><?php echo $row['add_ccemail']; ?></td>
                              <td><?php echo $row['add_bccemail']; ?></td>
                              <td><?php echo $row['status']; ?></td>
                              <td><a href="emailconfiguration.php?id=<?php echo $row["id"]; ?>" class="trigger-btn" id="edit"
                                                    data-toggle="tooltip" class="tip-bottom" title="Edit configuration" style="font-size: 20px;">
                                                    <i class="mdi mdi-lead-pencil "></i>
                                                  </a>
                                <a href="#myModaldelete" onclick="DeleteRow(<?php echo $row['id']; ?>)"  class="trigger-btn" data-toggle="modal" id="delete-Disease" data-toggle="tooltip" class="tip-bottom" title="Delete configuration" style="font-size: 20px;"><i class="mdi mdi-delete "></td>
                            </tr>
                            <?php $number++; endwhile; ?>
                        </tbody>
                    </table>
                </div>
                </div>
              </div>
            </div>
          </div>              

        </div>
         <!-- Modal HTML -->
         <div id="myModaldelete" class="modal fade">
          <div class="modal-dialog modal-confirm">
            <div class="modal-content">
              <div class="modal-header">
                <div class="icon-box">
                  
                </div>				
                <h4 class="modal-title"><i class="mdi mdi-alert"></i>Are you sure?</h4>	
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              </div>
              <div class="modal-body">
                <form method="post" action="#"> 
                 <input type="hidden" name="deleteid" id="deleteid"> 
                <p>Do you really want to delete these Email configuration ?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
                <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                </form>
              </div>
            </div>
          </div>
         </div> 
                          
  <?php include_once('footer.php'); ?>                              

  <!-- datatable -->
  <script src="../../vendors/js/datatables.min.js"></script>

  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>                              

 
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->

  <script>
  function isNumberKey(evt){  
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode < 48 || charCode > 57)
            return false;
            return true;
  }

  function DeleteRow(Id)
  {
    $('#deleteid').val(Id);
  }

  </script>
  
  <script type="text/javascript">

    function updateOrder(data) {
        $.ajax({
            url:"ajaxPro.php",
            type:'post',
            data:{position:data},
            success:function(){
                alert('your change successfully saved');
            }
        })
    }
</script>  
 

</body>

</html>
