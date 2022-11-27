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

$sql = "select house.*, categories.categories from house,categories where house.categories_id = categories.id and house.status='1' order by house.id desc";
$res = mysqli_query($con, $sql);
?>

<div class="content pb-0">
  <div class="orders">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-body">
            <h4 class="box-title">Houses </h4>
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
                    while($row = mfa($res)) {
                  ?>
                  <tr>
                    <td class="serial"><?php echo $i++;?></td>
                    <td><?php echo $row['categories'];?></td>
                    <td width="30%"><div class="scroll-show"><?php echo $row['description'];?></div></td>
                    <td width="25%"><div class="scroll-show"><?php echo $row['location'];?></div></td>
                    <td><?php echo $row['rent_price'];?></td>
                    <td><img class="house-img" src="<?php echo HOUSE_IMAGE_SITE_PATH.$row['image'] ?>"></td>
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