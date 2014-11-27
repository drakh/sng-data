<?php
$fn='SNG-metadata.json';
$fp=fopen($fn,'r');
$str=fread($fp,filesize($fn));
fclose($fp);
$data=json_decode($str,true);
$thumbs=array();
foreach($data as $d)
{
	$url='http://www.webumenia.sk/cedvuweb/image/'.str_replace(':','_',$d['pid']).'-th3.jpeg?id='.$d['pid'];
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HEADER, true);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	$rd = curl_exec($curl);
	$info = curl_getinfo($curl);
	if($info['http_code']==200)
	{
		$fp=fopen('thumbs/'.str_replace(':','_',$d['pid']).'-th3.jpeg','w');
		fwrite($fp,$rd);
		fclose($fp);
		$thumbs[]=$d;
	}
}
$fp=fopen('SNG-metadata-with-thumbs.json','w');
fwrite($fp,json_encode($thumbs, JSON_UNESCAPED_UNICODE));
fclose($fp);
?>