<?php if (!defined(JZ_SECURE_ACCESS)) die ('Security breach detected.');
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* JINZORA | Web-based Media Streamer
	*
	* Jinzora is a Web-based media streamer, primarily desgined to stream MP3s
	* (but can be used for any media file that can stream from HTTP).
	* Jinzora can be integrated into a CMS site, run as a standalone application,
	* or integrated into any PHP website.  It is released under the GNU GPL.
	*
	* Jinzora Author:
	* Ross Carlson: ross@jasbone.com
	* http://www.jinzora.org
	* Documentation: http://www.jinzora.org/docs
	* Support: http://www.jinzora.org/forum
	* Downloads: http://www.jinzora.org/downloads
	* License: GNU GPL <http://www.gnu.org/copyleft/gpl.html>
	*
	* Contributors:
	* Please see http://www.jinzora.org/modules.php?op=modload&name=jz_whois&file=index
	*
	* Code Purpose: Processes data for the jlGui embedded Java Player
	* Created: 03.03.05 by Ross Carlson
	*
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

	define('SERVICE_PLAYERS_flvplayer','true');
	$noeq='false';


	/**
	* Returns the player width
	*
	* @author Ben Dodson
	* @version 8/23/05
	* @since 8/23/05
	*/
	function SERVICE_RETURN_PLAYER_WIDTH_flvplayer(){
	  return 300;
	}

	/**
	* Returns the players height.
	*
	* @author Ben Dodson
	* @version 8/23/05
	* @since 8/23/05
	*/
	function SERVICE_RETURN_PLAYER_HEIGHT_flvplayer(){
	  return 150;
	}


	/**
	* Returns the data for the form posts for the player
	*
	* @author Ross Carlson
	* @version 06/05/05
	* @since 06/05/05
	* @param $formname The name of the form that is being created
	*/



	function SERVICE_RETURN_PLAYER_FORM_LINK_flvplayer($formname){
		//global $flvw, $flvh;
		return "document.". $formname. ".target='embeddedPlayer'; openMediaPlayer('', 300, 150);";
	}


	/**
	* Returns the data for the href's to open the popup player
	*
	* @author Ross Carlson
	* @version 06/05/05
	* @since 06/05/05
	*/
	function SERVICE_RETURN_PLAYER_HREF_flvplayer(){
		//global $flvw, $flvh;
		return ' target="embeddedPlayer" onclick="openMediaPlayer(this.href,300,150); return false;"';
	}


	/**
	* Actually displays this embedded player
	*
	* @author Ross Carlson
	* @version 3/03/05
	* @since 3/03/05
	* @param $list an array containing the tracks to be played
	*/
	function SERVICE_DISPLAY_PLAYER_flvplayer($width, $height, $noeq, $dheight, $ostretch){
		global $root_dir, $this_site, $css;;

		$urlData = "";
		//$urlData .=$this_site. $root_dir. "/temp/Playlist.xml";
		$urlData .= $this_site. $root_dir."/temp/Playlist.xml";



		?>
		<SCRIPT LANGUAGE=JAVASCRIPT TYPE="TEXT/JAVASCRIPT"><!--\
			window.resizeTo(<?php echo $width; ?>,<?php echo $height; ?>)
		-->
		</SCRIPT>
		<script type="text/javascript" src="<?php print $this_site. $root_dir; ?>/services/services/players/ufo.js"></script>

		<script type="text/javascript">

	var FU = { 	movie:"<?php print $this_site. $root_dir; ?>/services/services/players/flvplayer.swf",id:"flvplayer",name:"flvplayer",width:"<?php print ($width-30); ?>",height:"<?php print ($height-100); ?>",majorversion:"8",build:"0",bgcolor:"#000000",allowfullscreen:"true",
		flashvars:"file=<?php print $urlData; ?>&bufferlength=5<?php print $dheight; ?>&showdigits=stream&lightcolor=0x557722&backcolor=0x000000&frontcolor=0xCCCCCC&autostart=true&thumbsinplaylist=true<?php if($noeq=='false') {print '&showeq=false';}; ?>&enablejs=true&repeat=true&shuffle=false&overstretch=false" };
	UFO.create(	FU, "flvplayer");

	</script>

		<?php
		// Lets setup the page
		echo '<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0" bgcolor="#000000">';
		echo '<title>Jinzora FLV Media Player</title>';
		echo '<center>';

		$playlist = $this_site. $root_dir. "/temp/Playlist.wpl?". time();
		$height = "260";

		?>
		<center>
		<!-- FLV Player Code -->
		<p id="flvplayer"><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.</p>


<script type="text/javascript">
	onLoad =closeffmpeg();
	onUnload=closeffmpeg();

	function closeffmpeg() {
	var dummy = new Image();
	dummy.src="<?php print $this_site. $root_dir; ?>/services/services/players/flvplayer/pid.php?uid=<?php print $_SESSION['jzUserID']; ?>";

	}
</script>

		<!-- End FLV Player Code -->
		</center>
		<?php
		exit();
	}

	/**
	* Processes data for the jlGui embedded player
	*
	* @author Ross Carlson
	* @version 3/03/05
	* @since 3/03/05
	* @param $list an array containing the tracks to be played
	*/
	function SERVICE_OPEN_PLAYER_flvplayer($list){
		global $include_path, $root_dir, $this_site;

		if(isset($_GET['flvquality'])) {
		$flvquality=$_GET['flvquality'];
	} else { $flvquality=""; }

	$ostretch="true";
	switch($flvquality) {
		case "high":
			$flvh=600;
			$ostretch="false";
			break;
		case "medium":
			$flvh=400;
			$ostretch="false";
			break;
		case "mobile":
			$flvh=200;
			$ostretch="false";
			break;
		default:
			$flvh=600;
			$dheight='&displayheight=200';
		}

	switch($flvquality) {
		case "high":
			$flvw=800;
			break;
		case "medium":
			$flvw=550;
			break;
		case "mobile":
			$flvw=320;
			break;
		default:
			$flvw=400;

		}

		$display = new jzDisplay();

		// Lets set the name of this player for later
		$player_type = "flvplayer";

		// Now lets loop through each file
		$list->flatten();

		$output_content = '
		<?xml version="1.0"?>'."\n".'
		<playlist version="1" xmlns="http://xspf.org/ns/0/">
	<trackList>';
		// Now lets loop throught the items to create the list
		foreach ($list->getList() as $track) {
			// Should we play this?
			if ((stristr($track->getPath("String"),".lofi.")
				or stristr($track->getPath("String"),".clip."))
				and $_SESSION['jz_play_all_tracks'] <> true){continue;}

			// Let's get the meta
			$meta = $track->getMeta();

			// Let's get the art
			$parent = $track->getParent();
			if (($art = $parent->getMainArt("150x150")) !== false) {
				$image = jzCreateLink($art,"image");
			} else {
				$image = "";
			}
			// Now let's fix the track URL & image
			$tUrl = urlencode($track->getFileName("user"));
			$tUrl = str_replace("http%3A%2F%2F","http://",$tUrl);
			$tUrl = str_replace("https%3A%2F%2F","https://",$tUrl);
			$tUrl = str_replace("%2F","/",$tUrl);
			$image = urlencode($image);
			$image = str_replace("http%3A%2F%2F","http://",$image);
			$image = str_replace("https%3A%2F%2F","https://",$image);
			$image = str_replace("%2F","/",$image);

			$pArr = explode("/",$track->getPath("String"));
			$eArr = explode(".",$pArr[count($pArr)-1]);
			$ext = $eArr[count($eArr)-1];

			$movie_ext = "asf|wmv|wvx|dvr-ms|avi|mpg|mpeg|m1v|mpv2|wv|m4a|";

			if(stristr($movie_ext,$ext."|")){$flv_ext='flv';
			$processfile=$track->getFileName("string");
			$flvfile=$this_site. $root_dir.'/services/services/players/flvplayer/stream.php?file='.urlencode($processfile).'&quality='.$_GET['flvquality'].'&user='.$_SESSION['jzUserID'];
			//$flvfile=$processfile.'&quality='.$_GET['flvquality'].'&user='.$_SESSION['jzUserID'];
			$noeq='true';


			} else {$flv_ext=$ext;
			$flvfile=$track->getFileName("user");
			$noeq='false';};

			$output_content .= '     <track>'. "\n".
							'          <location>'.$flvfile.'</location>'. "\n".
								'          <creator>'. ($meta['artist']). '</creator>'. "\n".
								'          <title>'.($meta['album']).' - '.($meta['title']). '</title>'. "\n".
								'	    <meta rel="type">'.$flv_ext.'</meta>'. "\n".
								'	    <image>'.$image.'</image>'. "\n".
								'	    <album>'.$meta['length'].'</album>'. "\n".
								'     </track>'. "\n";
		}

		// Now let's finish up the content
		$output_content .= '</tracklist></playlist>';

		// Now that we've got the playlist, let's write it out to the disk
		$plFile = $include_path."temp/Playlist.xml";
		@unlink($plFile);
		$handle = fopen ($plFile, "w");
		fwrite($handle,$output_content);
		fclose($handle);

		// Ok, now we need to pop open the Wimpy player

		$width = $flvw;
		$height = $flvh;
		SERVICE_DISPLAY_PLAYER_flvplayer($width, $height, $noeq, $dheight, $ostretch);
		exit();
	}
?>