<?php

function myres($con, $str)
{
  if($str != "")
  {
    $str = trim($str);
    $str = stripslashes($str);
    $str = htmlspecialchars($str);
    return mysqli_real_escape_string($con, $str);
  }
}

function mfa($str)
{
  return mysqli_fetch_assoc($str);
}
?>