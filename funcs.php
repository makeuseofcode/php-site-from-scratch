<?php

init();

// Include required dependencies via composer
@include(TOP."/vendor/autoload.php");


/*
Set up global constants
*/
function init() {
	// This requires the site to be served via its root directory
	$url = $_SERVER["REQUEST_URI"];

	define('PAGE', $url == '/' ? '/' : rtrim($url, "/"));

	// Keep THIS file in the top-level directory...
	define('TOP', dirname(__FILE__));

	define('MD_DIR',    TOP.'/md');
	define('DATA_DIR',  TOP.'/data');
	define('TPL_DIR',   TOP.'/tpl');
	define('SITE_DIR',  TOP.'/site');
}

/*
Page TITLE
*/
function page_title($page = PAGE) {
	$titles = get_titles();
	return array_key_exists($page, $titles) ? $titles[$page] : basename($page);
}


/*
Get titles from the data file
*/
function get_titles() {
	return get_json("titles.json");
}


/**
 */
function get_json($file) {
	$json = "{}";
	$data_file = DATA_DIR."/".$file;

	if (file_exists($data_file)) {
		if (($json = file_get_contents($data_file)) === false) {
			return array();
		}
	}

	if (($out = json_decode($json, true)) === null) {
		return array();
	}

	return $out;
}

/*
Navigation
*/
function nav() {
	$navs = array("/", "/birds", "/news");

	$tpl =
		'<nav class="navbar nav-pills navbar-expand-lg navbar-light bg-light">'
			.'%s'
		.'</nav>';

	$items = array();

	$link = '<a class="nav-link%s" href="%s">%s</a>';

	foreach ($navs as $nav) {
		$cls = PAGE == $nav ? ' active' : '';
		$text = $nav == "/" ? "Home" : ucfirst(basename($nav));
		$items[] = sprintf($link, $cls, $nav, $text);
	}

	echo sprintf($tpl, join($items));
}


/*
Show an error message
https://getbootstrap.com/docs/5.1/components/alerts/
*/
function alert_error($msg) {
	echo
		'<div class="alert alert-danger d-flex align-items-center" role="alert">'
			.'<i class="bi-exclamation-triangle-fill me-2"></i> '
			.'<div>'.$msg.'</div>'
		.'</div>';
}


/*
Show a warning message
https://getbootstrap.com/docs/5.1/components/alerts/
*/
function alert_warning($msg) {
	echo
		'<div class="alert alert-warning d-flex align-items-center" role="alert">'
			.'<i class="bi-exclamation-triangle-fill me-2"></i> '
			.'<div>'.$msg.'</div>'
		.'</div>';
}


/*
Show main content on a page.
*/
function show_content() {
    $file = MD_DIR.PAGE.'.md';

    if (file_exists($file)) {
		if (class_exists("Parsedown")) {
        	$Parsedown = new Parsedown();
        	echo $Parsedown->text(file_get_contents($file));
        } else {
            echo alert_warning("<tt>Parsedown</tt> class not found");
            echo '<pre>'.file_get_contents($file).'</pre>';
        }
    } else if (function_exists("content")) {
        echo content();
    } else {
        echo alert_error("No content for ".PAGE);
    }
}


/*
Get full hierarchy. Pop off the last item which is the current page. For every
page 'above', echo a linked item
*/
function breadcrumbs() {
	$items = array();
	$titles = get_titles();
	$parts = explode("/", PAGE);
	$href = "";

	foreach ($parts as $part) {
		$href .= ($href == "/" ? "" : "/").$part;
		$items[$href] = $titles[$href];
	}

	$current = array_pop($items);

	$breadcrumbs =
		'<div class="mt-2">'
			.'<nav aria-label="breadcrumb">'
				.'<ol class="breadcrumb">%s</ol>'
			.'</nav>'
		.'</div>';

	$crumbs = array();

	foreach ($items as $href => $text) {
		$crumbs[] = sprintf(
			'<li class="breadcrumb-item"><a href="%s">%s</a></li>',
			$href,
			$text
		);
	}

	$crumbs[] =sprintf(
		'<li class="breadcrumb-item active" aria-current="page">%s</li>',
		$current
	);

	echo sprintf($breadcrumbs, join($crumbs));
}

/**
 * Show nav items for a section. Text for each link in the nav will be taken
 * from titles.json.
 */
function show_items($name) {
    $item = 
        "<li>"
            .'<a href="%s" class="%s">%s</a>'
        ."</li>";

    $cls_normal = "nav-link";
    $cls_active = "nav-link active";

    foreach (scandir(MD_DIR."/".$name) as $file) {
        if ($file[0] == ".") {
            continue;
        }

        $path = "/".$name."/".basename($file, ".md");
        $cls = $path == PAGE ? $cls_active : $cls_normal;
        $title = page_title($path);

        echo sprintf($item, $path, $cls, $title);
    }
}

