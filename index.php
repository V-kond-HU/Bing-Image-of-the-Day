<?php

// Bing: Image of the Day
// v0.03 (Non-Release)
// (C) Csikvári Mátyás alias V-kond 2025.
// Terms and conditions of the GNU GPL-3.0 licence apply.



$error = 0;



// PARAMETERS
// > Locale
if (isset ($_GET['loc'])) {
	$param_locale = $_GET['loc'];
}
if (!isset ($_GET['loc']) && isset ($param_locale)) {
	$param_locale = $param_locale;
}
if (!isset ($param_locale) && !isset ($_GET['loc'])) {
	$param_locale = 'auto'; // DEFAULT
}
// > Resolution
if (isset ($_GET['res'])) {
	$param_resolution = $_GET['res'];
	if ($param_resolution === 'auto') {
		$param_resolution = '1920x1200'; // DEFAULT
	}
}
if (!isset ($_GET['res']) && isset ($param_resolution)) {
	if ($param_resolution === 'auto') {
		$param_resolution = '1920x1200'; // DEFAULT
	}
}
if (!isset ($_GET['res']) && !isset ($param_resolution)) {
	$param_resolution = '1920x1200'; // DEFAULT
}
// > Output method
if (isset ($_GET['out'])) {
	$param_output = $_GET['out'];
}
if (!isset ($_GET['out']) && isset ($param_output)) {
	$param_output = $param_output;
}
if (!isset ($_GET['out']) && !isset ($param_output)) {
	$param_output = 0; // DEFAULT
}



// VALIDATE PARAMETERS
$valid_locales = array ('auto', 'de_DE', 'en_AU', 'en_CA', 'en_GB', 'en_IN', 'en_US', 'fr_CA', 'fr_FR', 'ja_JP', 'zh_CN');
foreach ($valid_locales as $valid_locale) {
	if ($valid_locale === $param_locale) {
		$error = 0;
		break;
	}
	else {
		$error = 41;
	}
}
$valid_resolutions = array ('auto', '800x600', '1024x768', '1280x720', '1280x768', '1366x768', '1920x1080', '1920x1200', '720x1280', '768x1024', '768x1280', '768x13661', '1080x1920');
foreach ($valid_resolutions as $valid_resolution) {
	if ($valid_resolution === $param_resolution) {
		$error = 0;
		break;
	}
	else {
		$error = 42;
	}
}
$valid_outputs = array (0, 1);
foreach ($valid_outputs as $valid_output) {
	if ($valid_output == $param_output) {
		$error = 0;
		break;
	}
	else {
		$error = 43;
	}
}



// START SCRIPT //
$var_raw_data = @file_get_contents ('http://www.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1&mkt='.$param_locale);

if ($var_raw_data === FALSE) {
	$error = 1;
}

if ($error == 0) {
	
	$op_check_json = @json_decode ($var_raw_data);
	
	if ($op_check_json === NULL && json_last_error ($op_check_json) !== JSON_ERROR_NONE) {
		$error = 2;
	}
	
	if ($error == 0) {
		
		$op_json_decode = @json_decode ($var_raw_data, true);
		
		if (!is_array ($op_json_decode)) {
			$error = 3;
		}
		else {
			$var_json_array = $op_json_decode;
		}
		
	}
	
	if ($error == 0) {
		
		$var_img_url_base = $var_json_array['images'][0]['urlbase'];
		$var_img_url = 'http://www.bing.com'.$var_img_url_base.'_'.$param_resolution.'.jpg';
		$var_img_caption = $var_json_array['images'][0]['copyright'];
		
		preg_match ('#\((.*?)\)#', $var_img_caption, $var_img_copyright);
		
		$var_img_copyright = $var_img_copyright[1];
		$var_img_copyright = str_replace ("'", "''", $var_img_copyright);
		
		$var_img_title = str_replace (' ('.$var_img_copyright.')', '', $var_img_caption);
		$var_img_title = str_replace ("'", "''", $var_img_title);
		
		$var_img_copyright = str_replace ('©', '', $var_img_copyright);
		
		$RESULT = array (
			0 => $var_img_url,
			1 => $var_img_title,
			2 => $var_img_copyright
		);
		
		if ($param_output == 0) {
			echo '<p style="font-weight: bold;">RESULT</p><p>Image URL: <a href="'.$RESULT[0].'" target="_blank">'.$RESULT[0].'</a><br>Image title: '.$RESULT[1].'<br>Image copyright: '.$RESULT[2].'</p>';
		}
		
	}
	else {
		$RESULT = 0;
	}
	
}
	
switch ($error) {
	
	case 1:
		
		if ($param_output == 0) {
			echo '<p>ERROR (1): Failed to open JSON data file.</p>';
		}
		
		break;
	
	case 2:
		
		if ($param_output == 0) {
			echo '<p>ERROR (2): JSON data file empty.</p>';
		}
		
		break;
	
	case 3:
		
		if ($param_output == 0) {
			echo '<p>ERROR (3): JSON data file corrupted.</p>';
		}
		
		break;
	
	case 41:
		
		if ($param_output == 0) {
			echo "<p>ERROR (41): User-defined parameter for locale ('loc') is non-valid.</p>";
		}
		
		break;
	
	case 42:
		
		if ($param_output == 0) {
			echo "<p>ERROR (42): User-defined parameter for resolution ('res') is non-valid.</p>";
		}
		
		break;
	
	case 43:
		
		if ($param_output < 0 || $param_output > 1) {
			echo "<p>ERROR (43): User-defined parameter for output method ('out') is non-valid.</p>";
		}
		
		break;
	
}

// END SCRIPT //

?>
