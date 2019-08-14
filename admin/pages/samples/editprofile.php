<?php
session_start();
require '../../../config.php';
if(!isset($_SESSION['id']))
{
    header("Location: login.php?msg=Please login first");
}

// edit profile admin
if(isset($_SESSION['id']))
{

  $id =$_SESSION['id'];
  $sessionqry = "SELECT * FROM `tbl_user` WHERE `id`=$id AND `type`='admin'";

  $sessionres = mysqli_query($con,$sessionqry); 
  $sessionrow = mysqli_fetch_assoc($sessionres);
  
}

?>

  <?php include_once('header.php');  ?>

      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="col-12 grid-margin">
            <div class="alert alert-success alert-dismissible text-center" id="success" style="display:none;">
                      <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            </div>
                        <div class="card">
                          <div class="card-body">
                            <h2 class="text-center">Edit Profile</h2><hr>
                            <form method="post" id="first_form" action="#" class="form-sample">
                              <div class="row">	
                                <div class="col-md-12">
                                  <input type="hidden" name="adminid" id="adminid" value="<?php if(isset($_SESSION['id'])){ echo $sessionrow['id']; }  ?>">
                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Username :-</label>
                                    <div class="col-sm-9">
                                      <input type="text" name="username" id="username" autocomplete="off" onKeyPress="return ValidateAlpha(event);" class="form-control"  placeholder="Enter username" value="<?php if(isset($_SESSION['id'])){ echo $sessionrow['username']; }  ?>" ondrop="return false;">
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Email :-</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="email" autocomplete="off" placeholder="Enter Email" value="<?php if(isset($_SESSION['id'])){ echo $sessionrow['email']; }  ?>" />
                                    </div>
                                  </div>

                                  <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Mobile No :-</label>
                                    <div class="col-sm-9">
                                      <input type="text" class="form-control" id="mobileno" autocomplete="off" maxlength="10" onkeypress="return isNumberKey(event)" placeholder="Enter Phone no" value="<?php if(isset($_SESSION['id'])){ echo $sessionrow['mobileno']; }  ?>" ondrop="return false;" onpaste="return false;"/>
                                    </div>
                                  </div>
                                  
                                  
                                </div>
                                <div class="col-md-12 text-center">
                                  <input class="btn btn-gradient-success mb-2" type="submit" name="update" id="update" value="Update">
                                </div>

                                </div>
                               
                                  
                                  
                            </form>
                          </div>
                        </div>
              </div>
        </div>
                          
  <?php include_once('footer.php'); ?>                              

 
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/misc.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <!-- End custom js for this page-->

  <script type="text/javascript">
    function ValidateAlpha(evt)
    {
        var keyCode = (evt.which) ? evt.which : evt.keyCode
        if ((keyCode < 65 || keyCode > 90) && (keyCode < 97 || keyCode > 123) && keyCode != 32)
          
          return false;
          return true;
    }

    function isNumberKey(evt){  
          var charCode = (evt.which) ? evt.which : evt.keyCode
          if (charCode < 48 || charCode > 57)
              return false;
              return true;
    }

   // edit Profile
   $("#first_form").submit(function(e){
    e.preventDefault();
    var adminid = $('#adminid').val();
    var username = $('#username').val();
    var email = $('#email').val();
    var mobileno = $('#mobileno').val();
    $(".error").remove();
        $error = 0;
        if (username.length < 1) {
            $('#username').after('<span class="error">This field is required</span>');
            $error = 1;
        }
        else{
          var alpha = /^[a-zA-Z\s-, ]+$/;
          if (!username.match(alpha)) {
          $('#username').after('<span class="error">Only Charaters  allowed in firstname</span>');     
          $error = 1;
        }
        }
        
        if (email.length < 1) {
            $('#email').after('<span class="error">This field is required</span>');
            $error = 1;
            
        } else {
            var regEx = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            var validEmail = regEx.test(email);
            if (!validEmail) {
              $('#email').after('<span class="error">Enter a valid email</span>');
              $error = 1;
              
        }
        }

        if (mobileno.length < 1) {
            $('#mobileno').after('<span class="error">This field is required</span>');
            $error = 1;
            
        }
        else{
          var ten = /^[0][1-9]\d{9}$|^[1-9]\d{9}$/;
          if(!ten.test(mobileno)) {
              $('#mobileno').after('<span class="error">Mobile no must be 10 digit</span>');
              $error = 1;
              
          }
        }

        if($error == 0)
        {
          $.ajax({
              url: "updateprofile.php",
              type: "POST",
              data: {
                adminid: adminid,
                username: username,
                email: email,
                mobileno: mobileno				
              },
              cache: false,
              success: function(dataResult){
                debugger;
                console.log(dataResult);
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                  $('#adminid').val("");
                  $('#username').val("");
                  $('#email').val("");
                  $('#mobileno').val("");
                  //$('#success').show();
                  //$('#success').html('Profile updated successfully !');
                  
                    window.location = "../../index.php";
                                     
                }
                else if(dataResult.statusCode==201){
                  alert("Error occured !");
                }	
              }
            });
        }
   });

  </script>
   

</body>

</html>
