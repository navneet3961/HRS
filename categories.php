<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'admin'))
{
  header('location:login.php');
  die();
}

if(isset($_GET['type']) && $_GET['type']!=''){
  $type=myres($con, $_GET['type']);
  
  if($type=='status'){
    $operation=myres($con,$_GET['operation']);
    $id=myres($con,$_GET['id']);
    if($operation=='active'){
      $status='1';
    }
    else {
      $status='0';
    }
    $update_status_sql="update categories set status='$status' where id='$id'";
    mysqli_query($con, $update_status_sql);
  }

  if($type=='delete'){
    $id=myres($con,$_GET['id']);
    $delete_sql="delete from categories where id='$id'";
    mysqli_query($con, $delete_sql);
  }
}

$sql = "select * from categories order by categories";
$res = mysqli_query($con, $sql);
?>

<div class="content pb-0">
  <div class="orders">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body">
            <h4 class="box-title">Categories </h4>
            <h4 class="box-link"><a href="manage_categories.php">Add Category</a>  </h4>
          </div>
          <div class="card-body--">
            <div class="table-stats order-table ov-h">
              <table class="table">
                <thead>
                  <tr>
                    <th class="serial">S.No.</th>
                    <th>Id</th>
                    <th>Category</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i = 1;
                    while($row = mfa($res)) { ?>
                  <tr>
                    <td class="serial"><?php echo $i++; ?></td>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['categories'] ?></td>
                    <td>
                      <?php 
                        if($row['status'] == 1) {echo "<a href='?type=status&operation=deactive&id=".$row['id']."'><span class='badge badge-complete'>Active</a></span>&nbsp";} 
                        else {echo "<a href='?type=status&operation=active&id=".$row['id']."'><span class='badge badge-pending'>Deactive</a></span>&nbsp";}
                        echo "<a href='manage_categories.php?id=".$row['id']."'><span class='badge badge-edit'>Edit</a></span>&nbsp";
                        echo "<a href='?type=delete&id=".$row['id']."'><span class='badge badge-delete'>Delete</a></span>";
                      ?>
                    </td>
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