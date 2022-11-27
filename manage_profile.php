<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'user'))
{
  header('location:index.php');
  die();
}

$uname= $name= $username= $email= $mobile= $address= "";
$msg= '';
$d_p=$e_p=$o_p= $n_p= $n_cp='';

if(isset($_GET['id']) && $_GET['id']!='')
{
  $id=myres($con, $_GET['id']);
  $uname= $_SESSION['USER_USERNAME'];
  $res=mysqli_query($con, "select * from users where id='$id' AND username='$uname'");
  $check=mysqli_num_rows($res);

  if ($check>0) {
    $row=mfa($res);
    $name=$row['name'];
    $username=$row['username'];
    $email=$row['email'];
    $mobile=$row['mobile'];
    $address=$row['address'];   
  }
  else
  {
    header('location:profile.php');
    die();
  } 
}

// Profile Edit
if (isset($_POST["submit"]))
{
  $name = ucwords(strtolower(myres($con, $_POST["name"])));
  $username = strtolower(myres($con, $_POST["username"]));
  $email = strtolower(myres($con, $_POST["email"]));
  $mobile = myres($con, $_POST["mobile"]);
  $address = ucwords(strtolower(myres($con, $_POST["address"])));

  $res=mysqli_query($con, "select * from users where username='$username' OR email='$email'");
  $check=mysqli_num_rows($res);

  if ($check>0 && isset($_GET['id']) && $_GET['id']!='')
  {
    $getData=mfa($res);
    if($id == $getData['id'])
    {

    }
    else
    {
      $msg = 'Exist';
      echo "<script> alert('Username or Email already exist !!!!!'); </script>";
    }
  }

  $name = ucwords(strtolower(myres($con, $_POST["name"])));
  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)){
    $msg.= '*Only letters and white space are allowed in name.\n';
  }

  $username = strtolower(myres($con, $_POST["username"]));
  if (!preg_match("/^[a-zA-Z\d]*$/",$username)){
    $msg.= '*Only letters are allowed in username.\n';
  }

  $email = strtolower(myres($con, $_POST["email"]));
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $msg.= '*Invalid email format.\n';
  }

  if(strlen($mobile)!= 10 || !preg_match("/^[1-9]{1}[0-9]{9}$/",$mobile))
  {
    $msg.='*Invalid mobile no.';
  }

  if($msg=='')
  {
    $update_sql="update users set name='$name', username= '$username', email= '$email' ,mobile='$mobile', address='$address' where id='$id'";
    mysqli_query($con, $update_sql);
    $_SESSION['USER_USERNAME'] = $username;
    header('location:profile.php');
    die();
  }
  else {
    echo "<script> alert('$msg'); </script>";
  }
}

// Password Change
if (isset($_POST["change"]))
{
  $o_p = myres($con, $_POST["oldPass"]);
  $n_p = myres($con, $_POST["newPass"]);
  $n_cp = myres($con, $_POST["newCPass"]);
  $e_p= password_hash($n_p, PASSWORD_BCRYPT);
  
  if (preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/",$n_p))
  {
    $res=mysqli_query($con, "select * from users where id='$id'");
    $row=mfa($res);

    if ($n_p === $n_cp)
    {
      if(password_verify($o_p, $row['password']))
      {
        echo "<script> alert('Password changed successfully!!!!!'); window.location.replace('profile.php');</script>";
        $sql="update users set password='$e_p' where id='$id'";
        $res = mysqli_query($con, $sql);
      }
      else
      {
        echo "<script> alert('*Old password doesn\'t match.'); </script>";
      }
    }
    else
    {
      echo "<script> alert('*New passwords don\'t match.'); </script>";
    }
  }
  else
  {
    echo "<script> alert('*New password does not follow the format.'); </script>";
  }
}

// Delete Account
if (isset($_POST["delete"]))
{
  $d_p = myres($con, $_POST["delPass"]);

  $res=mysqli_query($con, "select * from users where id='$id'");
  $row=mfa($res);

  if (password_verify($d_p, $row['password']))
  {
    $del_house_img_query = "select * from house where user_id = '$id'";
    $del_res = mysqli_query($con, $del_house_img_query);
    while ($del_row = mfa($del_res))
    {
      unlink(HOUSE_IMAGE_SERVER_PATH.$del_row['image']);
    }
    $delete_house="delete from house where user_id='$id'";
    $delete_user="delete from users where id='$id'";
    mysqli_query($con, $delete_house);
    mysqli_query($con, $delete_user);
    echo "<script> alert('Your account is deleted!!!!!'); window.location.replace('logout.php'); </script>";
  }
  else
  {
    echo "<script> alert('*Password doesn\'t match.'); </script>";
  }
}
?>

<div class="content pb-0">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">

        <!-- Edit Profile -->
          <div class="card-header"><strong>My Profile</strong><small> Form</small></div>
          <form method="post" enctype="multipart/form-data">
            <div class="card-body card-block">
              <div class="form-group">
                <label for="name" class=" form-control-label">Name</label>
                <input type="text" name='name' id="name" placeholder="Enter your name" class="form-control" required
                  value="<?php echo $name ?>">
              </div>
              <div class="form-group">
                <label for="username" class=" form-control-label">Username</label>
                <input type="text" name='username' id="username" placeholder="Enter username" class="form-control"
                  required value="<?php echo $username ?>">
              </div>
              <div class="form-group">
                <label for="email" class=" form-control-label">Email</label>
                <input type="text" name='email' id="email" placeholder="Enter your email" class="form-control" required
                  value="<?php echo $email ?>">
              </div>
              <div class="form-group">
                <label for="mobile" class=" form-control-label">Mobile</label>
                <input type="text" name='mobile' id="mobile" placeholder="Enter your mobile" class="form-control"
                  required value="<?php echo $mobile ?>">
              </div>
              <div class="form-group">
                <label for="address" class=" form-control-label">Address</label>
                <input type="text" name='address' id="address" class="form-control" required
                  value="<?php echo $address?>">
              </div>
              <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                <span id="payment-button-amount">Save</span>
              </button>
            </div>
          </form>
        </div>

        <!-- Change Password & Delete Account -->
        <div class="card">

          <div class="card-header" style="box-sizing: border-box">
            <strong class="half">Change Password</strong>
            <strong class="half">Delete Account</strong>
          </div>

          <div style="box-sizing: border-box">

            <!-- Change Password -->
            <div class="form-inner btn half">
              <form method="post">
                <div class="field">
                  <input type="password" name="oldPass" placeholder="Old Password" required>
                </div>
                <div class="field">
                  <input id="showC" type="password" name="newPass" placeholder="New Password" required>
                  <div id="condition">
                    Your password must: <br>
                    1) be between 8 and 20 characters long. <br>
                    2) contain at least one uppercase letter. <br>
                    3) contain at least one lowercase letter. <br>
                    4) contain at least one number digit. <br>
                    5) contain at least one special characters.
                  </div>
                </div>
                <div class="field">
                  <input type="password" name="newCPass" placeholder="Confirm Password" required>
                </div>
                <button class="btn btn-lg btn-info btn-block" name="change" type="submit">
                  <span>Change Password</span>
                </button>
              </form>
            </div>

            <!-- Delete Account -->
            <div class="form-inner btn half">
              <form method="post">
                <div class="field">
                  <input type="password" name="delPass" placeholder="Verify Password" required>
                </div>
                <button class="btn btn-lg btn-info btn-block" name="delete" type="submit">
                  <span>Delete Account</span>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const condition = document.querySelector("#showC");
  condition.onfocus = (() => {
    document.getElementById('condition').style.display = 'block';
  });
  condition.onblur = (() => {
    document.getElementById('condition').style.display = 'none';
  });
</script>

<?php
require "footer_inc.php";
?>