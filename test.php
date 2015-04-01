<?php
set_time_limit(0);
include 'simple_html_dom.php';
	$indLangPage = file_get_html('http://www.ethnicharvest.org/bibles/afrikaans.html');
	foreach ($indLangPage->find('a') as $allA) {
		$ahref = $allA->href;
		$plainAllA = $allA->plaintext;
		echo $plainAllA.' ';
		echo $ahref.'<br>';
		if ($ahref == "http://www.ethnologue.com/show_language.asp?code=$plainAllA") {
			// echo $plainAllA;
		}
		if ("http://www.ethnicharvest.org") {
			# code...
		}
		if ("http://www.amazon.com") {
			# code...
		}
		if ("http://www.jesusfilm.org") {
			# code...
		}
		if ("http://www.jesusfilmstore.com") {
			# code...
		}
		if ("http://www.google.com") {
			# code...
		}
		if ("http://www.ethnicharvest") {
			# code...
		}
	}
?>