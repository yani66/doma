<h2><?php print __("USERS")?></h2>
<table class="fullWidth">
<thead>
  <tr>
    <?php if(Helper::IsLoggedInAdmin()) { ?>
    <th><?php print __("USERNAME")?></th>
    <?php } ?>
    <th><?php print __("NAME")?></th>
    <th><?php print __("NO_OF_MAPS")?></th>
    <th><?php print __("LAST_MAP")?></th>
    <th><?php print __("DATE")?></th>
    <th><?php print __("UPDATED")?></th>
    <?php if(Helper::IsLoggedInAdmin()) { ?>
    <th><?php print __("VISIBLE")?></th>
    <th><?php print __("EDIT")?></th>
    <th><?php print __("LOGIN_AS")?></th>
    <?php } ?>
  </tr>
</thead>
<tbody>
<?php
  $count = 0;
  foreach($vd["Users"] as $u)
  {
    $count++;
    $lastMapLink = "";
    $lastMapDate = "";
    $lastMapUpdated = "";
    $loginAsUserLink = "";
    $thumbnailImage = "";
    $url = ($u->Visible ? "index.php?". Helper::CreateQuerystring($u) : "");
    $nameLink = Helper::EncapsulateLink(hsc($u->FirstName ." ". $u->LastName), $url);

	  if(isset($vd["LastMapForEachUser"][$u->ID]))
    {
      $lastMap = $vd["LastMapForEachUser"][$u->ID];
      if($lastMap)
      {
        $lastMapLink = '<a href="show_map.php?'. Helper::CreateQuerystring($u, $lastMap->ID) .'" class="thumbnailHoverLink">'.
                       hsc($lastMap->Name).
                       '</a>';

        $lastMapDate = date(__("DATE_FORMAT"), Helper::StringToTime($lastMap->Date, true));
        $lastMapUpdated = date(__("DATETIME_FORMAT"), Helper::StringToTime($lastMap->LastChangedTime, true));
        $thumbnailImage = '<img src="'. Helper::GetThumbnailImage($lastMap) .'" alt="'. hsc($lastMap->Name)  .'" height="'. THUMBNAIL_HEIGHT .'" width="'. THUMBNAIL_WIDTH .'" />';
      }
    }

    $url = ($u->Visible ? "users.php?loginAsUser=". urlencode($u->Username) : "");
    $loginAsUserLink = Helper::EncapsulateLink(sprintf(__("LOGIN_AS_X"), hsc($u->FirstName)), $url);

    ?>
    <tr class="<?php print ($count % 2 == 1 ? "odd" : "even")?>">
      <?php if(Helper::IsLoggedInAdmin()) { ?>
      <td><?php print hsc($u->Username)?></td>
      <?php } ?>
      <td><?php print $nameLink?></td>
      <td><?php print $u->NoOfMaps?></td>
      <td>
        <span class="hoverThumbnailContainer">
          <span class="hoverThumbnail hidden">
            <?php print $thumbnailImage?>
          </span>
        </span>
        <?php print $lastMapLink?>
      </td>
      <td><?php print $lastMapDate?></td>
      <td><?php print $lastMapUpdated?></td>
      <?php if(Helper::IsLoggedInAdmin()) { ?>
      <td><?php print ($u->Visible ? __("YES") : __("NO"))?></td>
      <td><a href="edit_user.php?mode=admin&amp;<?php print Helper::CreateQuerystring($u)?>"><?php print __("EDIT")?></a></td>
      <td><?php print $loginAsUserLink?></td>

      <?php } ?>
    </tr>
    <?php
    }
  ?>
</tbody>
</table>
<?php
    if(count($vd["LastMaps"]) > 0)
    {
      ?>
<h2>
  <?php print __("LAST_MAPS")?>
  <span class="selectNumber">
    <a href="users.php?lastMaps=10">10</a>
    <span class="separator">|</span>
    <a href="users.php?lastMaps=20">20</a>
    <span class="separator">|</span>
    <a href="users.php?lastMaps=50">50</a>
    <span class="separator">|</span>
    <a href="users.php?lastMaps=all"><?php print __("SHOW_ALL")?></a>
  </span>
</h2>
<table class="fullWidth">
<thead>
  <tr>
    <th><?php print __("NAME")?></th>
    <th><?php print __("MAP")?></th>
    <th><?php print __("DATE")?></th>
    <th><?php print __("CATEGORY")?></th>
    <th><?php print __("UPDATED")?></th>
  </tr>
</thead>
<tbody>
      <?php
      $count = 0;
      foreach($vd["LastMaps"] as $map)
      {
        $count++;
        $url = "index.php?". Helper::CreateQuerystring($map->GetUser());
        $nameLink = Helper::EncapsulateLink(hsc($map->GetUser()->FirstName ." ". $map->GetUser()->LastName), $url);
        $mapLink = '<a href="show_map.php?'. Helper::CreateQuerystring($map->GetUser(), $map->ID) .'" class="thumbnailHoverLink">'.
                   hsc($map->Name).
                   '</a>';

        $date = date(__("DATE_FORMAT"), Helper::StringToTime($map->Date, true));
        $updated = date(__("DATETIME_FORMAT"), Helper::StringToTime($map->LastChangedTime, true));

        $thumbnailImage = '<img src="'. Helper::GetThumbnailImage($map) .'" alt="'. hsc($map->Name)  .'" height="'. THUMBNAIL_HEIGHT .'" width="'. THUMBNAIL_WIDTH .'" />';

        ?>
        <tr class="<?php print ($count % 2 == 1 ? "odd" : "even")?>">
          <td><?php print $nameLink?></td>
          <td>
            <span class="hoverThumbnailContainer">
              <span class="hoverThumbnail hidden">
                <?php print $thumbnailImage?>
              </span>
            </span>
            <?php print $mapLink?>
          </td>
          <td><?php print $date?></td>
          <td><?php print $map->getCategory()->Name?></td>
          <td><?php print $updated?></td>
        </tr>
        <?php
      }
    }
    ?>
</tbody>
</table>

<?php
    if(count($vd["LastComments"]) > 0)
    {
      ?>
<h2>
  <?php print __("LAST_COMMENTS")?>
  <span class="selectNumber">
    <a href="users.php?lastComments=10">10</a>
    <span class="separator">|</span>
    <a href="users.php?lastComments=20">20</a>
    <span class="separator">|</span>
    <a href="users.php?lastComments=50">50</a>
    <span class="separator">|</span>
    <a href="users.php?lastComments=all"><?php print __("SHOW_ALL")?></a>
  </span>
</h2>
<table class="fullWidth">
<thead>
  <tr>
    <th><?php print __("NAME")?></th>
    <th><?php print __("MAP")?></th>
    <th><?php print __("COMMENTS_COUNT")?></th>
    <th><?php print __("COMMENT_FROM")?></th>
    <th><?php print __("UPDATED")?></th>
  </tr>
</thead>
<tbody>
      <?php
      $count = 0;
      foreach($vd["LastComments"] as $last_comment)
      {
        $count++;
        $url = "index.php?user=". $last_comment["UserName"];
        $nameLink = Helper::EncapsulateLink(hsc($last_comment["UserFLName"]), $url);
        $mapLink = '<a href="show_map.php?user='. $last_comment["UserName"] .'&map='. $last_comment["ID"] .'&showComments=true" class="thumbnailHoverLink">'.
                   hsc($last_comment["Name"]).
                   '</a>';

        $updated = date(__("DATETIME_FORMAT"), Helper::StringToTime($last_comment["CommentDate"], true));


        ?>
        <tr class="<?php print ($count % 2 == 1 ? "odd" : "even")?>">
          <td><?php print $nameLink?></td>
          <td>
            <?php print $mapLink?>
          </td>
          <td><?php print $last_comment["CommentsCount"]?></td>
          <td><?php print $last_comment["CommentName"]?></td>
          <td><?php print $updated?></td>
        </tr>
        <?php
      }
    }
    ?>
</tbody>
</table>
