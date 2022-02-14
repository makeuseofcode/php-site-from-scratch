<?php

include "../../funcs.php";

include TPL_DIR."/news.php";

function content() {
	$tpl_main = '<h1>News</h1><ul class="news">%s</ul>';
	$tpl_item = '<li>%s %s <h3><a href="%s">%s</a></h3> <p class="lead">%s</p></li>';
	$items = array();

    foreach (scandir(MD_DIR."/news") as $file) {
        if ($file[0] == ".") {
            continue;
        }

		$date = date("Y-m-d", filemtime(MD_DIR."/news/".$file));

		$href = '/news/'.basename($file, ".md");

		$contents = file_get_contents(MD_DIR."/news/".$file);

		if (preg_match("/^#\s+(.+)/", $contents, $matches)) {
			$title = $matches[1];
		}

		if (preg_match("/\n!\[.*\]\((.+)\)/", $contents, $matches2)) {
			$image = '<img src="'.$matches2[1].'" />';
		}

		if (preg_match("/\n([^#\!\n][^.]+.)/", $contents, $matches3)) {
			//echo '<pre>'.print_r($matches3, true).'</pre>';
			$intro = $matches3[1];
		}

		$items[] = array(
			"date" => $date,
			"markup" => sprintf($tpl_item, $image, $date, $href, $title, $intro)
		);
    }

    uasort($items, function($a, $b) {
    	return $a["date"] > $b["date"] ? -1 : ($a["date"] < $b["date"] ? 1 : 0);
    });

    $items = array_map(function($item) { return $item["markup"]; }, $items);

    printf($tpl_main, join($items));
}
