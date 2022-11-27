<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'user'))
{
  header('location:index.php');
  die();
}
if ($_GET == null)
{
  $_GET['str'] = "";
}
$search_str=myres($con,$_GET['str']);
if($search_str!='')
{
  $sql = "select house.*, categories.categories, users.name, users.mobile, users.email, users.address from house,categories,users where house.categories_id = categories.id and house.user_id = users.id and house.status='1' and (house.location like '%$search_str%' or house.description like '%$search_str%') order by house.id desc";
  $res = mysqli_query($con, $sql);
  $count = mysqli_num_rows($res);
}
else
{
	$sql = "select house.*, categories.categories, users.name, users.mobile, users.email, users.address from house,categories,users where house.categories_id = categories.id and house.user_id = users.id and house.status='1' order by house.id desc";
  $res = mysqli_query($con, $sql);
  $count = mysqli_num_rows($res);
}
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
                    <th>Location</th>
                    <th>Rent Price</th>
                    <th>Image</th>
                    <th>View</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if($count > 0)
                  {
                    $i = 1;
                    while($row = mfa($res)) {
                  ?>
                  <tr>
                    <td class="serial"><?php echo $i++;?></td>
                    <td><?php echo $row['categories'];?></td>
                    <td width="40%"><div class="scroll-show"><?php echo $row['location'];?></div></td>
                    <td><?php echo $row['rent_price'];?></td>
                    <td><img class="house-img" src="<?php echo HOUSE_IMAGE_SITE_PATH.$row['image'] ?>"></td>
                    <td>
                      <div id="<?php echo $row['id'].'show';?>" class="overdata">
                        <span class="closebtn" onclick="closeData(<?php echo $row['id'];?>)" title="Close View">×</span>
                        <div class="overdata-content">
                          <div class="view-details">

                            <!-- House Details -->
                            <div class="show-details">
                              <h3>House Description</h3>
                              <div>
                                <img src="<?php echo HOUSE_IMAGE_SITE_PATH.$row['image'] ?>" class="show-image">
                                <p><?php echo $row['description'];?></p>
                              </div>
                            </div>

                            <!-- User Details -->
                            <div class="show-details" style="border-top: solid #000;">
                              <h3>About Owner</h3>
                              <p>
                                <span class="space">Name:</span><span><?php echo $row['name'] ?></span><br>
                                <span class="space">Email:</span><span><?php echo $row['email'] ?></span><br>
                                <span class="space">Mobile:</span><span><?php echo $row['mobile'] ?></span><br>
                                <span class="space">Address:</span><span><?php echo $row['address'] ?></span><br>
                              </p>
                            </div>

                          </div>
                        </div>
                      </div>
                      <button onclick="openData(<?php echo $row['id'];?>)" class="view-house" id="<?php echo $row['id'];?>" value="<?php echo $row['id'];?>"><span class='badge badge-edit'>View House</span></button>
                      <script>
                        function openData(id) {
                          show = id + "show";
                          document.getElementById(show).style.display = "block";
                        }
                        function closeData(id) {
                          show = id + "show";
                          document.getElementById(show).style.display = "none";
                        }
                      </script>
                    </td>
                  </tr>
                  <?php
                    }
                  }
                  else
                  {
                    echo "<tr><td colspan='5' style='color: red;'>No data found. Try to search another location.<td></tr>";
                  }
                  ?>
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