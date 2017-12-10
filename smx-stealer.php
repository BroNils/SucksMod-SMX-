<?php 
$uri = "https://www.sourcemod.net/compiler.php?go=dl&id=";
$saveddir = "./sucksmod/";
$names = "";

if(!file_exists($saveddir)){
	mkdir($saveddir);
}

function ambilKata($param, $kata1, $kata2){
    if(strpos($param, $kata1) === FALSE) return FALSE;
    if(strpos($param, $kata2) === FALSE) return FALSE;
    $start = strpos($param, $kata1) + strlen($kata1);
    $end = strpos($param, $kata2, $start);
    $return = substr($param, $start, $end - $start);
    return $return;
}

function getsource($url,$post=null) {
	    global $names;
		$ch = curl_init($url);
		if($post != null) {
	 	 	curl_setopt($ch, CURLOPT_POST, true);
		  	curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); 
		  	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
		  	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
		  	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
		  	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		  	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$execc = curl_exec($ch);
		  $names = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
		  	curl_close($ch);
			return $execc;
}

while(1){
	$current = file_get_contents('id.txt');
	$xhtp = getsource($uri.$current);
	echo "\n==================\nLagi betak \n-> ".$uri.$current;
	if(preg_match("/This file does not exist/", $xhtp)){
		echo " (File not found)\n\n\nBentar gw coba lagi....\n==================";
	}else{
		$names = ambilKata($names,'name="','"');
		echo "\nDownloading ".$names." .....";
		if(file_put_contents($saveddir.$names, fopen($uri.$current, 'r'))){
			echo "\nDone ! file saved -> ".$names."\n==================";
		}
		$current++;
		$savedfile = file_put_contents("id.txt", $current);
	}
	sleep(10); //you can change the sleep time
}
