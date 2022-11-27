<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'user'))
{
  header('location:index.php');
  die();
}

if(isset($_GET['type']) && $_GET['type']!=''){
  $type=myres($con, $_GET['type']);

  if($type=='delete'){
    $id=myres($con,$_GET['id']);
    $delete_house="delete from house where user_id='$id'";
    $delete_user="delete from users where id='$id'";
    mysqli_query($con, $delete_house);
    mysqli_query($con, $delete_user);
    header('location:logout.php');
    die();
  }
}

$uname = $_SESSION['USER_USERNAME'];
$sql = "select * from users where username='$uname'";
$res = mysqli_query($con, $sql);
$row=mfa($res);
?>

<div class="content pb-0">
  <div class="orders">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header"><strong>My Profile</strong></div>
          <div class="card-body card-block">
            <table width='75%' class='profile-table'>
              <tr>
                <td width='20%'>Name</td>
                <td width='40%'><?php echo $row['name']?></td>
                <td width='40%'></td>
              </tr>
              <tr>
                <td>Username</td>
                <td><?php echo $row['username']?></td>
              </tr>
              <tr>
                <td>Email</td>
                <td><?php echo $row['email']?></td>
                <td width='40%'>
                  <?php
                    echo "<a href='manage_profile.php?id=".$row['id']."'><span class='badge badge-edit'>Manage Profile</a></span><br>";
                  ?>
                </td>
              </tr>
              <tr>
                <td>Mobile</td>
                <td><?php echo $row['mobile']?></td>
              </tr>
              <tr>
                <td>Address</td>
                <td><?php echo $row['address']?></td>
              </tr>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require "footer_inc.php";
?>