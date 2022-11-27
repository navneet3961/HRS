<?php
require "header_inc.php";

if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'user'))
{
  header('location:index.php');
  die();
}

$categories_id= $description= $location= $rent_price= $image= "";
$user_id=$msg= '';
$image_required='required';

if(isset($_GET['id']) && $_GET['id']!='')
{
  $u_id = $_SESSION['USER_ID'];
  $image_required='';
  $id=myres($con, $_GET['id']);
  $res=mysqli_query($con, "select * from house where id='$id' and user_id = '$u_id'");
  $check=mysqli_num_rows($res);

  if ($check>0)
  {
    $row=mfa($res);
    $categories_id=$row['categories_id'];
    $description=$row['description'];
    $location=$row['location'];
    $rent_price=$row['rent_price'];
    $image=$row['image'];  
  }
  else
  {
    header('location:user_house.php');
    die();
  }
}

if (isset($_POST["submit"]))
{
  $categories_id = myres($con, $_POST["categories_id"]);
  $description = ucfirst(myres($con, $_POST["description"]));
  $location = ucwords(strtolower(myres($con, $_POST["location"])));
  $rent_price = myres($con, $_POST["rent_price"]);

  if($categories_id == '0')
  {
    $msg.='*Please select category!!!!!\n';
  }

  if(strlen($description) <= 250)
  {
    $msg.='*Description must be of atleast 250 characters.!!!!!\n';
  }

  if((!preg_match("/^[0-9]*$/",$rent_price)) || $rent_price <= 0)
  {
    $msg.='*Rent price must be positive integer (greater than zero).\n';
  }

  if($_FILES['image']['type']!='image/png' && $_FILES['image']['type']!='image/jpg' && $_FILES['image']['type']!='image/jpeg')
  {
    if($_FILES['image']['name']!='')
    {
      $msg.='*Please select only png, jpg and jpeg format for image !!!!!\n';
    }
  }

  if($msg=='')
  {
    if(isset($_GET['id']) && $_GET['id']!='')
    {
      if($_FILES['image']['name']!='')
      {
        $image=rand(11111111,99999999).'_'.$_FILES['image']['name'];
        $image=myres($con, $image);
        move_uploaded_file($_FILES['image']['tmp_name'],HOUSE_IMAGE_SERVER_PATH.$image);
        $del_house_img_query = "select * from house where id = '$id'";
        $del_res = mysqli_query($con, $del_house_img_query);
        while ($del_row = mfa($del_res))
        {
          unlink(HOUSE_IMAGE_SERVER_PATH.$del_row['image']);
        }
        $update_sql="update house set categories_id='$categories_id', description= '$description', location= '$location' ,rent_price='$rent_price', image='$image' where id='$id'";
      }
      else{
        $update_sql="update house set categories_id='$categories_id', description= '$description', location= '$location' ,rent_price='$rent_price' where id='$id'";
      }
      mysqli_query($con, $update_sql);
    }
    else
    {
      $image=rand(11111111,99999999).'_'.$_FILES['image']['name'];
      $image=myres($con, $image);
      move_uploaded_file($_FILES['image']['tmp_name'],HOUSE_IMAGE_SERVER_PATH.$image);
      $user_id = $_SESSION['USER_ID'];
      mysqli_query($con, "insert into house(user_id,categories_id,description,location,rent_price,image,status) values('$user_id','$categories_id','$description','$location','$rent_price','$image',1)");
    }
    header('location:user_house.php');
    die();
  }
  else 
  {
    echo "<script> alert('$msg') </script>";
  }
}
?>

<div class="content pb-0">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header"><strong>House</strong><small> Form</small></div>
          <form method="post" enctype="multipart/form-data">
            <div class="card-body card-block">
              <div class="form-group">
                <label for="category" class=" form-control-label">Category</label>
                <select id="category" name="categories_id" class="form-control">
                  <option value='0'>Select Category</option>
                  <?php
                    $res= mysqli_query($con, "select id, categories from categories order by categories desc");
                    while($row=mfa($res))
                    {
                      if($row['id']== $categories_id)
                      {
                        echo "<option selected value=".$row['id'].">".$row['categories']."</option>";
                      }
                      else{
                        echo "<option value=".$row['id'].">".$row['categories']."</option>";
                      }
                    }
                  ?>
                </select>
              </div>
              <div class="form-group">
                <label for="des" class=" form-control-label">Description</label>
                <textarea name='description' id="des" placeholder="Enter description" class="form-control" required><?php echo $description ?></textarea>
              </div>
              <div class="form-group">
                <label for="loc" class=" form-control-label">Location</label>
                <input type="text" name='location' id="loc" placeholder="Enter location" class="form-control" required value="<?php echo $location ?>">
              </div>
              <div class="form-group">
                <label for="rp" class=" form-control-label">Rent Price</label>
                <input type="text" name='rent_price' id="rp" placeholder="Enter rent price" class="form-control" required value="<?php echo $rent_price ?>">
              </div>
              <div class="form-group">
                <label for="image" class=" form-control-label">Image</label>
                <input type="file" name='image' id="image" class="form-control" <?php echo $image_required?>>
              </div>
              <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
                <span id="payment-button-amount">Submit</span>
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