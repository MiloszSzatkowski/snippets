<?php

//js
foreach (glob("js/*.js") as $js) {
  echo "<script src='$js'></script>\n";
}

//css
foreach (glob("./css/*.css") as $css) {
  echo "<link type='text/css' rel='stylesheet' href='$css'>\n";
}

 ?>
