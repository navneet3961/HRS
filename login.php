<?php
require "header_inc.php";

if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'user')
{
  header('location:index.php');
  die();
}
else if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'admin')
{
  header('location:categories.php');
  die();
}

$name= $username= $password= $cpassword= $email= $pass= $cpass='';
$err='';

if (isset($_POST["login"]))
{
  $username = myres($con, $_POST["username"]);
  $password = myres($con, $_POST["password"]);
  $who = myres($con, $_POST["who"]);

  if($who == 'admin')
  {
    $sql = "select * from admin_users where username='$username' and password='$password'";
    $res = mysqli_query($con, $sql);
    $count = mysqli_num_rows($res);
    if ($count > 0)
    {
      $_SESSION['USER_LOGIN']='admin';
      $_SESSION['USER_USERNAME']=$username;
      header('location:categories.php');
      die();
    }
    else 
    {
      echo "<script> alert('Enter correct login credentials!!!!!'); </script>";
    }
  }

  else
  {
    $sql = "select * from users where username='$username'";
    $res = mysqli_query($con, $sql);
    $row=mfa($res);
    $count = mysqli_num_rows($res);
    if ($count > 0)
    {
      if (password_verify($password, $row['password'])) {
        $_SESSION['USER_LOGIN']='user';
        $_SESSION['USER_USERNAME']=$username;
        $_SESSION['USER_ID'] = $row['id'];
        $name = $row['name'];
        echo "<script> alert('Welcome $name!!!!!'); window.location.replace('index.php'); </script>";
      }
      else 
      {
        echo "<script> alert('Enter correct login credentials!!!!!'); </script>";
      }
      
    }
    else 
    {
      echo "<script> alert('Enter correct login credentials!!!!!'); </script>";
    }
  }
}

if (isset($_POST["signup"]))
{
  $name = ucwords(strtolower(myres($con, $_POST["name"])));
  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)){
    $err.= '*Only letters and white space are allowed in name.\n';
  }

  $username = strtolower(myres($con, $_POST["username"]));
  if (!preg_match("/^[a-zA-Z\d]*$/",$username)){
    $err.= '*Only letters are allowed in username.\n';
  }

  $email = strtolower(myres($con, $_POST["email"]));
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $err.= '*Invalid email format.\n';
  }

  $password = myres($con, $_POST["password"]);
  $cpassword = myres($con, $_POST["cpassword"]);
  if (!preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/",$password) || !preg_match("/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{8,20}$/",$cpassword)){
    $err.= '*Password does not follow the format.\n';
  }

  $pass= password_hash($password, PASSWORD_BCRYPT);

  if($err=='')
  {
    $sql="select * from users where username='$username' OR email='$email'";
    $res = mysqli_query($con, $sql);
    $check=mysqli_num_rows($res);

    if($check>0)
    {
      echo "<script> alert('User already exist!!!!!'); </script>";
    }
    else
    {
      if($password === $cpassword)
      {
        echo "<script> alert('User created successfully!!!!!'); </script>";
        $date = date('Y-m-d h:i:s');
        $sql="insert into users(name, username, email, password, added_on) values('$name', '$username', '$email', '$pass', '$date')";
        $res = mysqli_query($con, $sql);
      }
      else
      {
        echo "<script> alert('Password doesn\'t match!!!!!'); </script>";
      }
    }
  }
  else
  {
    echo "<script> alert('$err'); </script>";
  }
}
?>

<div class="middle">
  <div class="wrapper">
    <div class="title-text">
      <div class="title login">
        Login Form</div>
      <div class="title signup">
        Signup Form</div>
    </div>
    <div class="form-container">
      <div class="slide-controls">
        <input type="radio" name="slide" id="login" checked>
        <input type="radio" name="slide" id="signup">
        <label for="login" class="slide login">Login</label>
        <label for="signup" class="slide signup">Signup</label>
        <div class="slider-tab">
        </div>
      </div>
      <div class="form-inner">
        <form method="post" class="login">
          <div style="text-align: center;">
            <input type="radio" id="who_user" name="who" value="user" checked> <label for="who_user">User</label>
            &nbsp&nbsp
            <input type="radio" id="who_admin" name="who" value="admin"> <label for="who_admin">Admin</label>
          </div>
          <div class="field" style="margin-top: 0">
            <input type="text" name="username" placeholder="Username" required>
          </div>
          <div class="field">
            <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="pass-link">
            <a href="#">Forgot password?</a>
          </div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" name="login" value="Login">
          </div>
          <div class="signup-link">
            Not a user? <a href="">Signup now</a></div>
        </form>

        <form method="post" class="signup">
          <div class="field">
            <input type="text" name="name" placeholder="Name" required>
          </div>
          <div class="field">
            <input type="text" name="email" placeholder="Email Address" required>
          </div>
          <div class="field">
            <input type="text" name="username" placeholder="Username" required>
          </div>
          <div class="field">
            <input type="password" name="password" placeholder="Password" required>
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
            <input type="password" name="cpassword" placeholder="Confirm Password" required>
          </div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" name="signup" value="Signup">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
require "footer_inc.php";
?>

<script>
  const loginText = document.querySelector(".title-text .login");
  const loginForm = document.querySelector("form.login");
  const loginBtn = document.querySelector("label.login");
  const signupBtn = document.querySelector("label.signup");
  const signupLink = document.querySelector("form .signup-link a");
  const condition = document.querySelector("form.signup input[type=password]");
  signupBtn.onclick = (() => {
    loginForm.style.marginLeft = "-50%";
    loginText.style.marginLeft = "-50%";
  });
  loginBtn.onclick = (() => {
    loginForm.style.marginLeft = "0%";
    loginText.style.marginLeft = "0%";
    document.getElementById('condition').style.display = 'none';
  });
  signupLink.onclick = (() => {
    signupBtn.click();
    return false;
  });
  condition.onfocus = (() => {
    document.getElementById('condition').style.display = 'block';
  });
  condition.onblur = (() => {
    document.getElementById('condition').style.display = 'none';
  });
</script>