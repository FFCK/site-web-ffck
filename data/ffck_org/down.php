<?php
/*
//exec("wget http://downloads.sourceforge.net/project/phpmyadmin/phpMyAdmin/4.0.10.9/phpMyAdmin-4.0.10.9-english.zip?r=http%3A%2F%2Fwww.phpmyadmin.net%2Fhome_page%2Fdownloads.php&ts=1430230874&use_mirror=softlayer-sng");
exec("wget --no-check-certificate -o upload_ffck.zip http://demo3.wp-coders.com/ffck/upload_ffck.zip");
exit;
*/

include "unzip.cls.php";
$zip=new UnZIP('upload_ffck.zip');
$zip->extract();

?>
