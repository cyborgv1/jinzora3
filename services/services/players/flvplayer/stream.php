<?php
$uid=$_GET['user'];

$pos = (isset($_GET["pos"]))  ? intval($_GET["pos"]): 0;

$file=$_GET["file"];
$quality=$_GET["quality"];
/*$parts=explode('++++',$_GET["file"]);
$file=$parts[0];
$quality=$parts[1];
$uid=$parts[2];*/
switch ($quality) {
	case "high":
	$q="-qscale 6";
	break;
	case "medium":
	$q="";
	break;
	case "mobile":
	$q="-s qcif -b 64k";
	break;
};
$rootdir=explode('stream',$_SERVER['SCRIPT_FILENAME']);
$root=$rootdir[0];
exec($root.'pid.sh '.$uid.' >/dev/null &');

//exec('php '.$root.'pid.php '.$uid.' &');
passthru('/usr/bin/ffmpeg -re -y -ss '.$pos.' -i "'.$file.'" -ar 44100 -async 1 '.$q.' -f flv - &');
?>