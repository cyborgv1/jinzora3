<?php if (!defined(JZ_SECURE_ACCESS)) die ('Security breach detected.');
	// Let's figure out the path stuff so we'll know how/where to include from
	$form_action = setThisPage() . "install=step2";

	// Now let's include the left
	include_once($include_path. 'install/leftnav.php');

	// Let's set a session variable so we can test for session support
	$_SESSION['jz_sess_test'] = 0;
?>

<div id="main">
	<a href="http://www.jinzora.com" target="_blank"><img src="<?php echo $include_path; ?>install/logo.gif" border="0" align="right" vspace="5" hspace="0"></a>
	<h1>Welcome to Jinzora <?php echo $version; ?>!</h1>
	<p>
	The Web Based Installer (WBI) will guide you through the process of installing Jinzora on your server.
	<br>
	<?php
		// Lets reset our tracking session variables just in case the user restarts the install
		unset($_SESSION['all_media_paths']);
	?>
	<br><br>
	<div class="go">
		<span class="goToNext">
			Language
		</span>
	</div>
	<form action="<?php echo $form_action; ?>" name="setup2" method="post">
		Please select a language to use during installation. You can change to another language once the installer is finished.
		<br><br>
		<table width="100%" cellspacing="0" cellpadding="3" border="0">
			<tr>
				<td width="20%" align="left" class="td">
					Language:
				</td>
				<td width="1">&nbsp;</td>
				<td width="80%" align="left">
						<?php
							// Let's get all the possible language files
							$lang_dir = $include_path. "install/lang/";
							$retArray = readDirInfo($lang_dir,"dir");

							sort($retArray);
							$languages = array();

							for ($c=0; $c < count($retArray); $c++){
								$entry = $retArray[$c];
								// Let's make sure this isn't the local directory we're looking at
								if ($entry == "." || $entry == ".." || $entry == "master.php") { continue;}
								if (!stristr($entry,"-setup") and !stristr($entry,".html")){
									if (strrpos($entry,'-') !== false) {
										$languages[substr($entry,0,strrpos($entry,'-'))] = true;
									} else {
										$languages[$entry] = true;
									}
								}
							}

                                                        include_once(dirname(__FILE__).'/../lib/languageDetect.php');
                                                        $defaultLanguage = getDefaultLanguage();
                                                        if (!isset($languages[$defaultLanguage])) {
                                                          $defaultLanguage = 'english';
                                                        }
							$languages = array_keys($languages);

							echo '<select name="jz_lang_file">';
							foreach ($languages as $entry) {
								echo '<option ';
								if ($entry == $defaultLanguage){echo 'selected'; }
								echo ' value="'. $entry. '">'. $entry. '</option>'. "\n";
							}
						?>
					</select>
				</td>
			</tr>
		</table>
		<br>
		<div class="go">
			<span class="goToNext">
				&nbsp; <input type="submit" name="submit_step2" value="Proceed to Requirements >>" class="submit">
			</span>
		</div>
	</form>
	</div>
<?php
	// Now let's include the footer
	include_once($include_path. 'install/footer.php');
?>
