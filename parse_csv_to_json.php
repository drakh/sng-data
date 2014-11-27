<?php
$data=file('SNG-metadata.csv');
$i=0;
//http://www.webumenia.sk/cedvuweb/image/SVK_SNG.O_5952-th3.jpeg?id=SVK:SNG.O_5952
$dx=array();
$fp=fopen('SNG-metadata.json','w');
foreach($data as $k => $v)
{
	if($i>0)
	{
		$d=explode(';',$v);
		$dt=array();
		$start=false;
		$end=false;
		foreach($d as $md)
		{
			$md=trim($md);
			$fs=substr($md,0,1);
			$ls=substr($md,-1,1);
			$md=str_replace('"','',$md);
			if($fs=='"')
			{
				$start=true;
				$sa=array();
			}
			elseif($ls=='"')
			{
				$end=true;
			}
			if($start===true && $end===false)
			{
				$sa[]=$md;
			}
			elseif($start===true && $end===true)
			{
				$sa[]=$md;
				$start=false;
				$end=false;
				$dt[]=implode(', ', $sa);
			}
			else
			{
				$dt[]=$md;
			}
		}
		$dx[]=array(
			'pid'=>$dt[0],
			'incentory_number'=>$dt[1],
			'authority'=>$dt[2],
			'name'=>$dt[3],
			'date'=>$dt[4],
			'medium'=>$dt[5],
			'technique'=>$dt[6],
			'size'=>$dt[7],
			'organisation'=>$dt[8],
			'curator'=>$dt[9],
			'genre'=>$dt[10],
			'type'=>$dt[11],
			'visual_type'=>$dt[12],
			'add_number'=>$dt[13]
		);
	}
	$i++;
}
fwrite($fp,json_encode($dx,JSON_UNESCAPED_UNICODE));
fclose($fp);
?>