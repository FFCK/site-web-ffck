<?php
/**
 * @author Sarbacane Software
 */
if ("N" == $_GET ['list_type']) {
	$title = get_option ( 'sarbacane_news_title', '' );
	$description = get_option ( 'sarbacane_news_description', '' );
	$list_type = 'N';
	$registration_button = get_option ( 'sarbacane_news_registration_button', __ ( 'Inscription', 'sarbacane-desktop' ) );
	$fields = get_option ( 'sarbacane_news_fields', array (__ ( 'email', 'sarbacane-desktop' ) => null ) );
} else if ("C" == $_GET ['list_type']) {
	$title = get_option ( 'sarbacane_users_title', '' );
	$description = get_option ( 'sarbacane_users_description', '' );
	$list_type = 'C';
	$registration_button = get_option ( 'sarbacane_users_registration_button', __ ( 'Inscription', 'sarbacane-desktop' ) );
	$fields = get_option ( 'sarbacane_users_fields', array (__ ( 'email', 'sarbacane-desktop' ) => null ) );
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri() . '/style.css'?>" />
</head>
<body>
	<div id="widget-area" class="widget-area">
		<?php include_once('sarbacane-widget.php')?>
	</div>
</body>
</html>