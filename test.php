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
				foreach ($indLangPage->find('a') as $allA) {
					$plainAllA = $allA->plaintext;
					$ahref = $allA->href;
					$hrefcontent[$ahref] = $ahref;
					foreach ($hrefcontent as $key) {
						// $hrefcontent[$ahref]['iso'] = '';
						// $hrefcontent[$ahref]['ethnic_harvest_links'] = '';
						// $hrefcontent[$ahref]['amazon_links'] = '';
						if ($key == "http://www.ethnologue.com/show_language.asp?code=$plainAllA") {
							$hrefcontent['iso'] = $plainAllA;
							// echo $plainAllA.'<br>';
						}
						if ($langLink == substr($key, 0, $langLinkLength)) {
							$hrefcontent['ethnic_harvest_links'] = $EHLang.$key.',';
						}
						if (substr($key, 0, 21) == "http://www.amazon.com") {
							$hrefcontent['amazon_links'] = $key;
						}
					}
				var_dump($hrefcontent);
				}
					// if ($ahref == "http://www.jesusfilm.org") {
					// 	# code...
					// }
					// if ($ahref == "http://www.jesusfilmstore.com") {
					// 	# code...
					// }
					// if ($ahref == "http://www.google.com") {
					// 	# code...
					// }
					// if ($ahref = "http://www.ethnicharvest.org") {
					// 	# code...
					// }
					// if ($ahref = "http://www.ethnicharvest.org/bibles/") {
					// 	# code...
					// }
			}
		}
	}
	file_put_contents("bibles.json", json_encode($hrefcontent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
}
?>