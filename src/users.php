<?php
  include_once(dirname(__FILE__) ."/include/main.php");
  include_once(dirname(__FILE__) ."/users.controller.php");
  include_once(dirname(__FILE__) ."/include/json.php");

  $controller = new UsersController();
  $vd = $controller->Execute();
?>
<?php print '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php print _SITE_TITLE; ?></title>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
  <link rel="stylesheet" href="style.css?v=<?php print DOMA_VERSION; ?>" type="text/css" />
  <link rel="icon" type="image/png" href="gfx/favicon.png" />
  <link rel="alternate" type="application/rss+xml" title="RSS" href="rss.php" />
  <script type="text/javascript" src="js/jquery/jquery-1.7.1.min.js"></script>
  <script src="js/common.js?v=<?php print DOMA_VERSION; ?>" type="text/javascript"></script>
  <?php if($vd["OverviewMapData"] != null) { ?>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?php print GOOGLE_MAPS_API_KEY; ?>&amp;language=<?php print Session::GetLanguageCode(); ?>" type="text/javascript"></script>
    <script src="js/overview_map.js?v=<?php print DOMA_VERSION; ?>" type="text/javascript"></script>
    <script type="text/javascript">
      <!--
        var overviewMapData = <?php print json_encode($vd["OverviewMapData"]); ?>;
      -->
    </script>
  <?php } ?>
  <script type="text/javascript" src="js/users.js?v=<?php print DOMA_VERSION; ?>"></script>
</head>

<body id="usersBody">
<div id="wrapper">
<?php Helper::CreateUserListTopbar(); ?>
<div id="content">
<form method="get" action="<?php print Helper::SelfPath()?>">

<div id="rssIcon"><a href="rss.php"><img src="gfx/feed-icon-28x28.png" alt="<?php print __("RSS_FEED")?>" title="<?php print __("RSS_FEED")?>" /></a></div>

<h1><?php print _SITE_TITLE?></h1>

<?php
  if(count($vd["Errors"]) > 0)
  {
  ?>
    <ul class="error">
    <?php
      foreach($vd["Errors"] as $e)
      {
        print "<li>$e</li>";
      }
    ?>
    </ul>
  <?php
  }
?>

<p><?php print _SITE_DESCRIPTION; ?></p>

<?php
  if(count($vd["Users"]) == 0)
  {
    print '<p>'. __("NO_USERS_CREATED");
    if(Helper::IsLoggedInAdmin()) print ' <a href="edit_user.php?mode=admin">'. __("CREATE_THE_FIRST_USER") .'</a>';
    print '</p>';
  }

  if(!Helper::IsLoggedInAdmin() && PUBLIC_USER_CREATION_CODE) print '<p>'. __("PUBLIC_CREATE_USER_INFO") .'</p>';

  if(count($vd["Users"]) > 0)
  {
?>

<label for="displayMode"><?php print __("SELECT_DISPLAY_MODE"); ?>:</label>
<select name="displayMode" id="displayMode" onchange="this.form.submit()">
  <option value="list"<?php if($vd["DisplayMode"] == "list") print ' selected="selected"'; ?>><?php print __("DISPLAY_MODE_LIST")?></option>
  <option value="overviewMap"<?php if($vd["DisplayMode"] == "overviewMap") print ' selected="selected"'; ?>><?php print __("DISPLAY_MODE_OVERVIEW_MAP")?></option>
</select>

<div class="clear"></div>

<?php } ?>
<div id="maps">
  <?php
    if($vd["DisplayMode"] == "list") include("users_list.php");
    if($vd["DisplayMode"] == "overviewMap") include("users_overview_map.php");
  ?>
</div>
<div class="clear"></div>

</form>
</div>
</div>
<?php Helper::GoogleAnalytics() ?>
</body>
</html>
