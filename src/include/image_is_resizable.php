<?php
  include_once(dirname(__FILE__) ."/helper.php");
  $filename = $_GET["filename"];
  $result = 0;
  if(is_resource($image) || $image instanceof \GdImage)
  {
    $image = Helper::ImageCreateFromGeneral($filename);
    if(is_resource($image))
    {
      ImageDestroy($image);
      $result = 1;
    }
  }
  print $result;
?>