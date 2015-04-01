<?php
set_time_limit(0);
include 'simple_html_dom.php';

function url_exists($url){
    if ((strpos($url, "http")) === false) $url = "http://" . $url;
    $headers = @get_headers($url);
    // print_r($headers);
    if (is_array($headers)){
        if(strpos($headers[0], '404 Not Found'))
            return false;
        else
            return true;    
    }         
    else
        return false;
}

// function charlen($)

$EH = file_get_html('http://www.ethnicharvest.org/bibles/masterindex.html');
$EHLang = 'http://www.ethnicharvest.org/bibles/';
foreach ($EH->find('td') as $td) {
	foreach ($td->find('b') as $b) {
		foreach ($b->find('a') as $a) {
			$langLink = $a->href;
			$plainLL = $a->plaintext;
			$EHLangLink = $EHLang.$langLink;
			$content[$plainLL] = '';
			$content[$plainLL]['LangLink'] = $EHLangLink;
			$indLangPage = file_get_html($EHLangLink);
			$langLinkLength = strlen($langLink);
			if (url_exists($EHLangLink)) {
				// $content[$plainLL]['iso'] = '';
				// $content[$plainLL]['ethnic_harvest_links'] = '';
				// $content[$plainLL]['amazon_links'] = '';
				foreach ($indLangPage->find('a') as $allA) {
					$ahref = $allA->href;
					$plainAllA = $allA->plaintext;
					if ($ahref == "http://www.ethnologue.com/show_language.asp?code=$plainAllA") {
						$content[$plainLL]['iso'] = $plainAllA;
						// echo $plainAllA.'<br>';
					}
					if ($langLink == substr($ahref, 0, $langLinkLength)) {
						$content[$plainLL]['ethnic_harvest_links'] = $EHLang.$ahref.',';
					}
					if (substr($ahref, 0, 21) == "http://www.amazon.com") {
						$content[$plainLL]['amazon_links'] = $ahref;
					}
					if ($ahref == "http://www.jesusfilm.org") {
						# code...
					}
					if ($ahref == "http://www.jesusfilmstore.com") {
						# code...
					}
					if ($ahref == "http://www.google.com") {
						# code...
					}
					if ($ahref = "http://www.ethnicharvest.org") {
						# code...
					}
					if ($ahref = "http://www.ethnicharvest.org/bibles/") {
						# code...
					}
				}
			}
		}
	}
	file_put_contents("bibles.json", json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}
?>