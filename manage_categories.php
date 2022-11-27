<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'admin'))
{
  header('location:login.php');
  die();
}

$categories= $msg= '';

if(isset($_GET['id']) && $_GET['id']!='')
{
  $id=myres($con, $_GET['id']);
  $res=mysqli_query($con, "select * from categories where id='$id'");
  $check=mysqli_num_rows($res);

  if ($check>0) {
    $row=mfa($res);
    $categories=$row['categories'];
  } else {
    header('location:categories.php');
    die();
  }
  
}

if (isset($_POST["submit"]))
{
  $categories = ucwords(myres($con, $_POST["categories"]));

  $res=mysqli_query($con, "select * from categories where categories='$categories'");
  $check=mysqli_num_rows($res);

  if ($check>0) {
    if(isset($_GET['id']) && $_GET['id']!='')
    {
      $getData=mfa($res);
      if($id == $getData['id'])
      {

      }
      else
      {
        $msg = 'Exist';
        echo "<script> alert('Category already exist !!!!!'); </script>";
      }
    }
    else
    {
      $msg = 'Exist';
      echo "<script> alert('Category already exist !!!!!'); </script>";
    } 
  }

  if($msg=='')
  {
    if(isset($_GET['id']) && $_GET['id']!='')
    {
      mysqli_query($con, "update categories set categories='$categories' where id='$id'");
    }
    else
    {
      mysqli_query($con, "insert into categories(categories, status) values('$categories','1')");
    }
    header('location:categories.php');
    die();
  }
}
?>

<div class="content pb-0">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header"><strong>Categories</strong><small> Form</small></div>
          <form method="post">
            <div class="card-body card-block">
              <div class="form-group">
                <label for="company" class=" form-control-label">Category</label>
                <input type="text" name='categories' id="company" placeholder="Enter category name" class="form-control" required value="<?php echo $categories ?>">
              </div>
              <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                <span id="payment-button-amount">Save</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require "footer_inc.php";
?>