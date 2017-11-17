<?php
/*
  Author      : Stargraf
  Title       : Guardian
  Description : Stargraf guardian :: file monitoring script
  URL         : http://stargraf.com/
*/

  $SiteName          = 'ffck';

  $CheckFolder       = '/var/home/ffck/public_html/';
  $excludedFolders   = array(
    '/var/home/ffck/public_html/wp-content/uploads/',
    '/var/home/ffck/public_html/clubs/wp-content/uploads/',
  );

  $EmailTo           = 'security@stargraf.com,webmaster@ffck.org';

  $debugMinInterval  = '5 seconds';
  $minInterval       = '10 seconds';

  $savedFilePath     = '/var/home/ffck/guard-save/guard-ffck.saved.txt';

  $RecurseLevel      = 999;
  $reportAlways      = false;
  $testing           = false;
?>