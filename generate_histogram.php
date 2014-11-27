<?php
function mk_histo($arr,$n)
{
	$p=$n/100;
	$histogram=array();
	for ($i=0; $i<256; $i++)
	{
        	if(!$arr[$i]) $arr[$i]=0;
        	$sum+=$arr[$i];
        	$arr[$i]=$arr[$i]/$p;
	}
	for ($i=0; $i<256; $i++)
	{
        	$h = $arr[$i];
        	/*low pass filter*/
			if($i==0) $sw=$h;
			else
			{
				$sw += ($h-$sw)/3;
			}
			$histogram[$i]=$sw;
	}
	return $histogram;
	//imagepng($im, 'tmp.png');
}


$fn='SNG-metadata-with-thumbs.json';
$fp=fopen($fn,'r');
$str=fread($fp,filesize($fn));
fclose($fp);
$data=json_decode($str,true);
$thumbs=array();
$counter=0;
echo count($data)."\n";
foreach($data as $d)
{
	$in='thumbs/'.str_replace(':','_',$d['pid']).'-th1.jpeg';
	$img=imagecreatefromjpeg($in);
	$w=imagesx($img);
	$h=imagesx($img);
	echo $counter.':'.$in."\n";

	$n=$w*$h;
	$h_r = array();
	$h_g = array();
	$h_b = array();
	$h_l = array();
	for ($x=0; $x<$w; $x++)
	{
	        for ($y=0; $y<$h; $y++)
	        {
	                $rgb = ImageColorAt($img, $x, $y); 
	                $r = ($rgb >> 16) & 0xFF;
	                $g = ($rgb >> 8) & 0xFF;
	                $b = $rgb & 0xFF;
	                $l = round(($r + $g + $b) / 3);
	                $h_r[$r] += 1;
	                $h_g[$g] += 1;
	                $h_b[$b] += 1;
	                $h_l[$l] += 1;
	        }
	}
	imagedestroy($img);

	//$d['histogram']['luma']=mk_histo($h_l,$n);
	//$d['histogram']['red']=mk_histo($h_r,$n);
	//$d['histogram']['green']=mk_histo($h_g,$n);
	//$d['histogram']['blue']=mk_histo($h_b,$n);
	$h=array();
	$h['luma']=mk_histo($h_l,$n);
	$h['red']=mk_histo($h_r,$n);
	$h['green']=mk_histo($h_g,$n);
	$h['blue']=mk_histo($h_b,$n);
	$fp=fopen('histogram/'.str_replace(':','_',$d['pid']).'.json','w');
	fwrite($fp,json_encode($h,JSON_UNESCAPED_UNICODE));
	fclose($fp);
	$counter++;
}
?>