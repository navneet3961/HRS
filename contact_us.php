<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'admin'))
{
  header('location:login.php');
  die();
}

if(isset($_GET['type']) && $_GET['type']!=''){
  $type=myres($con, $_GET['type']);
  if($type=='delete'){
    $id=myres($con,$_GET['id']);
    $delete_sql="delete from contact_us where id='$id'";
    mysqli_query($con, $delete_sql);
  }
}

$sql = "select * from contact_us order by id desc";
$res = mysqli_query($con, $sql);
?>

<div class="content pb-0">
  <div class="orders">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body"><h4 class="box-title">Contact Us </h4></div>
          <div class="card-body--">
            <div class="table-stats order-table ov-h">
              <table class="table ">
                <thead>
                  <tr>
                    <th class="serial">S.No.</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Query</th>
                    <th>Date</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i = 1;
                    while($row = mfa($res)) { ?>
                  <tr>
                    <td class="serial"><?php echo $i++ ?></td>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['name'] ?></td>
                    <td><?php echo $row['email'] ?></td>
                    <td><?php echo $row['mobile'] ?></td>
                    <td><?php echo $row['comment'] ?></td>
                    <td><?php echo $row['added_on'] ?></td>
                    <td><?php echo "<a href='?type=delete&id=".$row['id']."'><span class='badge badge-delete'>Delete</a></span>";?></td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
require "footer_inc.php";
?>