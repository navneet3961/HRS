<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'user'))
{
  header('location:index.php');
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
    $update_status_sql="update house set status='$status' where id='$id'";
    mysqli_query($con, $update_status_sql);
  }

  if($type=='delete'){
    $id=myres($con,$_GET['id']);
    $del_house_img_query = "select * from house where id = '$id'";
    $del_res = mysqli_query($con, $del_house_img_query);
    while ($del_row = mfa($del_res))
    {
      unlink(HOUSE_IMAGE_SERVER_PATH.$del_row['image']);
    }
    $delete_sql="delete from house where id='$id'";
    mysqli_query($con, $delete_sql);
  }
}

$uname = $_SESSION['USER_USERNAME'];
$sql = "select house.*, categories.categories from house, categories, users where house.user_id = users.id and users.username = '$uname' and house.categories_id= categories.id order by house.id desc";
$res = mysqli_query($con, $sql);
?>

<div class="content pb-0">
  <div class="orders">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body">
            <h4 class="box-title">Houses </h4>
            <h4 class="box-link"><a href="manage_house.php">Add House</a> </h4>
          </div>
          <div class="card-body--">
            <div class="table-stats order-table ov-h">
              <table class="table ">
                <thead>
                  <tr>
                    <th class="serial">S.No.</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Rent Price</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $i = 1;
                    while($row = mfa($res)) { ?>
                  <tr>
                    <td class="serial"><?php echo $i++ ?></td>
                    <td><?php echo $row['categories'] ?></td>
                    <td width="25%"><div class="scroll-show"><?php echo $row['description'] ?></div></td>
                    <td width="25%"><div class="scroll-show"><?php echo $row['location'] ?></div></td>
                    <td><?php echo $row['rent_price'] ?></td>
                    <td><img class="house-img" src="<?php echo HOUSE_IMAGE_SITE_PATH.$row['image'] ?>"></td>
                    <td>
                      <?php 
                        if($row['status'] == 1)
                        {echo "<a href='?type=status&operation=deactive&id=".$row['id']."'><span class='badge badge-complete'>Active</a></span>&nbsp";} 
                        else {echo "<a href='?type=status&operation=active&id=".$row['id']."'><span class='badge badge-pending'>Deactive</a></span>&nbsp";}
                        echo "<a href='manage_house.php?id=".$row['id']."'><span class='badge badge-edit'>Edit</a></span>&nbsp";
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