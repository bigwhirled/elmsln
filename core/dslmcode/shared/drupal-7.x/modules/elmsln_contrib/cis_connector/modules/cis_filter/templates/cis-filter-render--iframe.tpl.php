<?php
  // render an iframe based on passed in values
  // Variables
  //  $id - content id
  //  $class - classes to apply
  //  $link - link to what the frame is pointing to
  //  $width - width of the frame
  //  $height - height of the frame
?>
<iframe id="<?php print $id; ?>" frameborder="0" class="<?php print $class; ?>" src="<?php print $link; ?>" width="<?php print $width; ?>" height="<?php print $height; ?>"></iframe>
