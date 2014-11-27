<?php
$fn='SNG-metadata-with-thumbs.json';
$fp=fopen($fn,'r');
$str=fread($fp,filesize($fn));
fclose($fp);
$data=json_decode($str,true);
foreach($data as $d)
{
	$url='http://www.webumenia.sk/cedvuweb/image/'.str_replace(':','_',$d['pid']).'-th1.jpeg?id='.$d['pid'];
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, false);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$rd = curl_exec($curl);
	$info = curl_getinfo($curl);
	$fp=fopen('thumbs/'.str_replace(':','_',$d['pid']).'-th1.jpeg','w');
	fwrite($fp,$rd);
	fclose($fp);
}
?>