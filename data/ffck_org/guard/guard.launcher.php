<?php
/*
  Author      : Stargraf
  Title       : Guardian
  Description : Stargraf guardian :: file monitoring script  
  URL         : http://stargraf.com/
*/

require 'guard.config.php';
require 'guard.class.php';

$fw = new twzFilewatch($SiteName, $CheckFolder, $RecurseLevel, $EmailTo);

$fw->saveFile($savedFilePath);
$fw->excludeFolders($excludedFolders);
$fw->emailSubject($emailSubChanges,$emailSubNoChanges);

if($testing) {
  $fw->doSendEmail(false);
  $fw->reportAlways($reportAlways);
  $fw->minInterval($debugMinInterval);
}
else {
  $fw->doSendEmail(true);
  $fw->reportAlways($reportAlways);
  $fw->minInterval($minInterval);
}

$fw->checkFiles();


?>