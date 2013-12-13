<?

$rootdir=explode('pid',$_SERVER['SCRIPT_FILENAME']);
$root=$rootdir[0];
$uid=$argv[1];
if(isset($_GET['uid'])){$uid=$_GET['uid'];};
if($fh=fopen($root.'temp/'.$uid.'.flvplayer_pid','r')) {
	$pid=fread($fh,255);
fclose($fh);
};

if(isset($pid)) {
	exec('kill '.$pid);
};

sleep(1);
$processes=shell_exec('ps -U www-data -u www-data -o comm,pid');
//print $processes;
$p=explode(chr(10),$processes);
$z=0;
for($i=0; $i<count($p);$i++)
{
$pp=$p[$i];
$p2=explode(" ",$pp);
if($p2[0]=="ffmpeg"){
$a=count($p2)-1;
$ffmpeg[$z]=$p2[$a];
$z++;
}
}

if($fh=fopen($root.'temp/'.$uid.'.flvplayer_pid','w')) {
	fputs($fh,$ffmpeg[(count($ffmpeg)-1)]);
fclose($fh);
}

?>
