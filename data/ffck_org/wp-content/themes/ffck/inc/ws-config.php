<?php

header('Access-Control-Allow-Origin: http://' . getenv("OBS_HOST") . "/");
//TODO //FIXME remove this line ? :
header('Access-Control-Allow-Origin: http://ffck-goal-prp.multimediabs.com/');

// URLs PROD
$wsEndpoint = "http://" . getenv("OBS_USER") . ":" . getenv("OBS_PASSWORD") . "@" . getenv("OBS_HOST") . "/wsprivate";
$wsUrl['calendrier'] = $wsEndpoint . "/calendriers/get";
$wsUrl['detailEvenement'] = $wsEndpoint . "/manifestations/detailManifestation";
$wsUrl['detailFormation'] =  $wsEndpoint . "/sessionsformations/detailSession";
$wsUrl['athletes'] = $wsEndpoint . "/hautniveau/getListeAthletes";
$wsUrl['athleteDetail'] = $wsEndpoint . "/hautniveau/getInfosAthlete";
$wsUrl['instancesFFCK'] = $wsEndpoint . "/structures/annuaire?codeStructure=0";
$wsUrl['preCalendrier'] = $wsEndpoint . "/manifestations/getprecalendrier";
$wsUrl['listeStructures'] = $wsEndpoint . "/structures/annuaire";

function simplexml_load_file_from_url($url, $timeout = 60){
  $opts = array(
    'http' => array(
      'timeout' => (int)$timeout
      )
    );
  $context = stream_context_create($opts);
  $data = file_get_contents($url, false, $context);
  // print_r($data);
  if(!$data){
    echo 'Délai d\'attente dépassé : les données n\'ont pas pu être chargées.';
    trigger_error('Cannot load data from url: ' . $url, E_USER_NOTICE);
    return false;
  }
  return simplexml_load_string($data);
}


function getCalendrier($dateDebut, $dateFin, $codeStructure, $codeTypeFormation, $codeTypeActiviteFormation, $codeTypeEvt, $codeTypeActivite, $niveaux, $codeStructureMere, $optional = "") {
  global $wsUrl;

  $url =
  $wsUrl['calendrier'] .
  "?dateDebut=" . $dateDebut .
  "&dateFin=" . $dateFin .
  "&codeStructure=" . $codeStructure .
  "&codeTypeFormation=" . $codeTypeFormation .
  "&codeTypeActiviteFormation=" . $codeTypeActiviteFormation .
  "&codeTypeEvt=" . $codeTypeEvt .
  "&codeTypeActivite=" . $codeTypeActivite .
  "&niveaux=" . $niveaux .
  "&codeStructureMere=" . $codeStructureMere .
  $optional;

  // echo '<p>' . $url . '</p>';

  $xml = simplexml_load_file_from_url($url);

  return $xml;
}

function getDetailEvenement($codex) {
  global $wsUrl;

  $url =
  $wsUrl['detailEvenement'] .
  "?code=" . $codex;

  $xmldetail = simplexml_load_file_from_url($url);

  return $xmldetail;
}

function getDetailFormation($idSession) {
  global $wsUrl;

  $url =
  $wsUrl['detailFormation'] .
  "?idSession=" . $idSession;

  $xmldetail = simplexml_load_file_from_url($url);

  return $xmldetail;
}

function getAthletes($saison, $discipline, $collectif) {
  global $wsUrl;
  $url =
  $wsUrl['athletes'] .
  "?saison=" . $saison .
  "&discipline=" . $discipline .
  "&collectif=" . $collectif;

  $xml = simplexml_load_file_from_url($url);

  // echo '<p>' . $url . '</p>';

  return $xml;
}

function getAthleteDetail($code) {
  global $wsUrl;
  $url =
  $wsUrl['athleteDetail'] .
  "?codeAdherent=" . $code;

  $xml = simplexml_load_file_from_url($url);

  // echo '<p>' . $url . '</p>';

  return $xml;
}

function getInstance() {
  global $wsUrl;
  $url =
  $wsUrl['instancesFFCK'] ;

  $xml = simplexml_load_file_from_url($url);

  // echo '<p>' . $url . '</p>';

  return $xml;
}

function getPreCalendrier($saison, $activite, $niveau)
{
  global $wsUrl;
  $url =
  $wsUrl['preCalendrier'] .
  "?idSaisonEvt=" . $saison .
  "&codeTypeActivite=" . $activite .
  "&niveaux=" . $niveau;
  $xml = simplexml_load_file_from_url($url);

  //echo '<p>' . $url . '</p>';

// *** trie du tableau avant retour ***

$arr = array(); // déclaration d'un tableau
foreach($xml->evenements->evenement as $evenement) { // on remplit le tableau d'evt
$arr[] = array(
  'codeNiveau'     => (string)$evenement->codeNiveau,
  'libelleNiveau'     => (string)$evenement->libelleNiveau,
  'libelleEvenement'     => (string)$evenement->libelleEvenement,
  'dateDebut'            => (string)$evenement->dateDebut,
  'dateFin'              => (string)$evenement->dateFin
  );
}

//trie sur un champ date
usort($arr,function($a,$b){ //on applique un trie
  $date1 = str_replace('/', '-', $a['dateDebut']);
  $date2 = str_replace('/', '-', $b['dateDebut']); // JJ-MM-AAAA
  $date1 = date('Y-m-d', strtotime($date1)); // AAAA-MM-JJ
  $date2 = date('Y-m-d', strtotime($date2));
  return strtotime($date1) - strtotime($date2);
});

// trie sur un champ texte
//usort($arr, function($a, $b) {
//return strcmp($a->libelleTypeEvenement, $b->libelleTypeEvenement);
// });

return $arr;

// fin du trie

//return $xml;
}


function getStructures($codeStructureMere, $details = 'false')
{
  global $wsUrl;
  $url =
  $wsUrl['listeStructures'] .
  "?codeStructureMere=" . $codeStructureMere .
  "&moreDetails=" . $details;

  $xml = simplexml_load_file_from_url($url);

  //echo '<p>' . $url . '</p>';

  return $xml;
}



$DTZ = new DateTimeZone('Europe/Paris');

class DateTimeFrench extends DateTime {
  public function format($format) {
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche');
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre');
    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, parent::format($format)));
  }
}

function wd_remove_accents($str, $charset='utf-8') {
  $str = htmlentities($str, ENT_NOQUOTES, $charset);
  $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
  $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
  $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères
  $str = str_replace(' ', '-', $str); // supprime les espaces
  return $str;
}

?>
