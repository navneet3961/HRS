<?php
$name= $email= $mobile= $comment= "";
$err= '';

if (isset($_POST["submit"]))
{
  $name = ucwords(strtolower(myres($con, $_POST["name"])));
  if (!preg_match("/^[a-zA-Z-' ]*$/",$name)){
    $err.= '*Only letters and white space are allowed in name.\n';
  }

  $email = strtolower(myres($con, $_POST["email"]));
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $err.= '*Invalid email format.\n';
  }
  
  $mobile = myres($con, $_POST["mobile"]);
  if(strlen($mobile)!= 10)
  {
    $err.="*Enter correct mobile no.";
  }

  $comment = ucfirst(myres($con, $_POST["comment"]));

  if($err=='')
  {
    $date = date('Y-m-d h:i:s');
    $sql="insert into contact_us(name, email, mobile, comment, added_on) values('$name', '$email', '$mobile', '$comment', '$date')";
    $res = mysqli_query($con, $sql);
    echo "<script> alert('Your query has been sent to Admin!!!!!'); window.location.replace('index.php'); </script>";
  }
  else
  {
    echo "<script> alert('$err'); </script>";
  }
}
?>

<div class="content pb-0" id="contact">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <form method="post" enctype="multipart/form-data">
            <div class="card-body card-block">
              <table width='100%' id='contact-table'>
                <tr>
                  <td width='30%' rowspan='5' style='text-align: center'><img src="../media/contact_us.jpg" style="max-height: 325px; padding: 5px"></td>
                  <td width='10%'><label for="name" class=" form-control-label">Name</label></td>
                  <td width='60%'> <input type="text" name='name' id="name" placeholder="Enter your name" class="form-control" required></td>
                </tr>
                <tr>
                  <td> <label for="email" class=" form-control-label">Email</label></td>
                  <td> <input type="text" name='email' id="email" placeholder="Enter your email" class="form-control" required></td>
                </tr>
                <tr>
                  <td><label for="mobile" class=" form-control-label">Mobile</label></td>
                  <td> <input type="text" name='mobile' id="mobile" placeholder="Enter your mobile" class="form-control" required></td>
                </tr>
                <tr>
                  <td><label for="comment" class=" form-control-label">Comment</label></td>
                  <td> <textarea name='comment' id="comment" rows="5" class="form-control" required></textarea></td>
                </tr>
                <tr>
                  <td></td>
                  <td><button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block"><span id="payment-button-amount">Send</span></button></td>
                </tr>
              </table>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>