<?php
define("TYPE_INSCRIPTION_LICENCE", 1);
define("TYPE_INSCRIPTION_LISTE", 2);
define("TYPE_INSCRIPTION_BATEAUX_LICENCE", 4);
define("TYPE_INSCRIPTION_BATEAUX", 5);
define("TYPE_INSCRIPTION_LISTE_BATEAUX", 6);
define("TYPE_INSCRIPTION_LISTE_BATEAUX_PARA", 7);

define("ETAT_COMPETITION_PROGRAMME", 1);
define("ETAT_COMPETITION_INSCRIPTION", 2);
define("ETAT_COMPETITION_CONFIRMATION", 3);
define("ETAT_COMPETITION_CLOTUREE", 4);
define("ETAT_COMPETITION_LIVE", 5);
define("ETAT_COMPETITION_TERMINEE", 6);
define("ETAT_COMPETITION_EN_PAIEMENT", 7);
define("ETAT_COMPETITION_PAYEE", 8);

define("ACTIVE_SAISON", 2016);

if (strstr($_SERVER['DOCUMENT_ROOT'],'www') == false)
{
	define("PRODUCTION", true); 
}
else
{
	define("PRODUCTION", false); 
}

include_once($_SERVER['DOCUMENT_ROOT'].'/module/adv/advBase.php');	

function cmpListeCoureurMatric($a, $b)
{
	return strcmp($a['Matric'], $b['Matric']);
}

function cmpDistanceOrdre($a, $b)
{
	return $a['Ordre'] - $b['Ordre'];
}

class MyBase extends advBase
{
    // Constructeur 
    function __construct($bConnect=true)
    {
		if (PRODUCTION)
		{
			// Sous domaine compet.ffck.org
			$this->m_login = "competffck_read";
			$this->m_password = "FF-ahaZQ5dxH6y9XaK6TZ3cHEV2LZ81td";
			$this->m_database = "competffck";
			$this->m_server = "localhost";
			$this->m_directory = "/module/";
			$this->m_url = "http://www.ffck.org/module";
		}
		else
		{
			// wampserver 
			$this->m_login = "root";
			$this->m_password = "";
			$this->m_database = "base_ffck";
			$this->m_server = "localhost";
			$this->m_directory = "/module/";
			$this->m_url = "http://localhost/module/calendrier";
		}

		if ($bConnect)
			$this->Connect();
    }
}

?>
