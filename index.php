<?php
require "header_inc.php";

if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'admin')
{
  header('location:categories.php');
  die();
}
?>

<div class="img-slide">
  <div class="slideshow-container">
    <div class="mySlides">
      <img class="img-show" src="../media/banner1.jpg" style="width:100%">
    </div>

    <div class="mySlides">
      <img class="img-show" src="../media/banner2.jpg" style="width:100%">
    </div>

    <div class="mySlides">
      <img class="img-show" src="../media/banner3.jpg" style="width:100%">
    </div>
  </div>

  <br>
  
  <div style="text-align:center">
    <span class="dot"></span>
    <span class="dot"></span>
    <span class="dot"></span>
  </div>
</div>

<?php
require "user_contact_us.php";
require "footer_inc.php";
?>