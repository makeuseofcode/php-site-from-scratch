<?php

include "../../funcs.php";

include TPL_DIR."/birds.php";

function content() {
	echo '<h1>Birds</h1>';

	$files = scandir(SITE_DIR."/img");
	$files = array_filter($files, function($file) { return $file[0] != '.'; });
	$file = $files[array_rand($files)];

	echo '<img src="/img/'.$file.'" />';
}
