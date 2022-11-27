<?php
require "connection_inc.php";
require "function_inc.php";
?>

<!doctype html>
<html class="no-js" lang="">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="assets/css/normalize.css">
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="assets/css/themify-icons.css">
  <link rel="stylesheet" href="assets/css/pe-icon-7-filled.css">
  <link rel="stylesheet" href="assets/css/flag-icon.min.css">
  <link rel="stylesheet" href="assets/css/cs-skin-elastic.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/login_style.css">
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
<?php 
if (isset($_SESSION['USER_LOGIN']))
{
  if ($_SESSION['USER_LOGIN'] == 'admin')
  {
    echo <<<_END
    <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="menu-title">Menu</li>
            <li class="menu-item-has-children dropdown">
              <a href="categories.php"> Category Master</a>
            </li>
            <li class="menu-item-has-children dropdown">
              <a href="house.php"> House Master</a>
            </li>
            <li class="menu-item-has-children dropdown">
              <a href="users.php"> User Master</a>
            </li>
            <li class="menu-item-has-children dropdown">
              <a href="contact_us.php"> Contact Us</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>
    _END;
  }
  else
  {
    echo <<<_END
    <aside id="left-panel" class="left-panel">
      <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="menu-title">Menu</li>
            <li class="menu-item-has-children dropdown">
              <a href="profile.php"> My Profile</a>
            </li>
            <li class="menu-item-has-children dropdown">
              <a href="user_house.php"> My Houses</a>
            </li>
          </ul>
        </div>
      </nav>
    </aside>
    _END;
  }
?>
  <div id="right-panel" class="right-panel">
    <header id="header" class="header">
      <div class="top-left">
        <div class="navbar-header">
          <a class="navbar-brand" href="index.php"><img style="height: 45px" src="../media/logo.png" alt="Logo"></a>
          <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
      </div>
      <div class="top-right">
        <div class="header-menu">
<?php
        if ($_SESSION['USER_LOGIN'] == 'user')
        {
          echo <<<_END
          <div id="myOverlay" class="overlay">
            <span class="closebtn" onclick="closeSearch()" title="Close Search">×</span>
            <div class="overlay-content">
              <form action="search.php" method="get">
                <div class="autocomplete"><input id="searchPlaces" type="text" name="str" placeholder="Search houses by location.....">
                <button id="mySearch" type="submit"><i class="fa fa-search"></i></button></div>
              </form>
            </div>
          </div>
          <button class="openBtn" onclick="openSearch()">Search <i class="fa fa-search"></i></button>
          <div class="home-contact">
            <a href="index.php"><i class="fa fa-home"></i> Home</a>
            <a href="index.php#contact"><i class="fa fa-phone"></i> Contact Us</a>
          </div>
          <script>
            function openSearch() {
              document.getElementById("myOverlay").style.display = "block";
            }
            function closeSearch() {
              document.getElementById("myOverlay").style.display = "none";
            }
            var input = document.getElementById("searchPlaces");
            input.addEventListener("keyup", function(event)
            {
              if (event.keyCode === 13)
              {
                event.preventDefault();
                document.getElementById("mySearch").click();
              }
            });
          </script>    
          _END;
        }
  echo <<<_END
          <div class="user-area dropdown float-right">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false"><i class="fa fa-user-circle-o" style="font-size:36px"></i></a>
            <div class="user-menu dropdown-menu">
              <a class="nav-link" href="logout.php"><i class="fa fa-unlock-alt"></i> Logout</a>
            </div>
          </div>
        </div>
      </div>
    </header>
  _END;
}
else {
  echo <<<_END
  <div id="right-panel" class="right-panel" style="margin-left: 0px">
    <header id="header" class="header">
      <div class="top-left">
        <a class="navbar-brand" href="index.php"><img style="height: 45px" src="../media/logo.png" alt="Logo"></a>
      </div>
      <div class="top-right">
        <div class="header-menu">
          <div class="home-contact">
            <a href="index.php"><i class="fa fa-home"></i> Home</a>
            <a href="index.php#contact"><i class="fa fa-phone"></i> Contact Us</a>
            <a href="login.php"><i class="fa fa-lock"></i> Login/Register</a>
          </div>
        </div>
      </div>
    </header>
_END;
}
?>