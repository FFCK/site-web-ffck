<?php
include "adv/advBase.php";

class MyBaseOBS extends advBase
{
    // Constructeur
	function __construct($bConnect=true)
	{
    $this->m_login = getenv("COMPET_DB_USER");
		$this->m_password = getenv("COMPET_DB_PASSWORD");
		$this->m_database = getenv("COMPET_DB_NAME");
		$this->m_server = getenv("COMPET_DB_HOST");

		if ($bConnect)
			$this->Connect();
	}


// Fonctions pour affichage du calendrier

	function LoadCalendrier(&$arrayCalendrier, $dateDebut, $dateFin, $codeTypeEvt = null, $codeTypeActivite = null, $niveaux = null, $region = null, $codeStructure = null, $lstColumns="*", $resulttype=MYSQLI_ASSOC)
	{
		$sql = "select t2.urlPhoto, t1.$lstColumns from cal_evenement t1 ";
		$sql .= "left join cal_evenement_photos t2 on t2.codex = t1.codex and t2.typePhoto = 'AFFICHE' " ;
		$sql .= "where t1.etat = 'Validé' " ;
		$sql .="and t1.dateFin between '$dateDebut' and '$dateFin' ";
		if ($codeStructure = 0){$sql .= "and t1.structureOrganisatrice = '0 - FEDERATION FRANCAISE DE CANOE-KAYAK' " ;}
		if ($codeTypeEvt != null){$sql .= "and t1.codeTypeEvenement in ($codeTypeEvt) " ;}
		if ($codeTypeActivite != null){$sql .= "and t1.codeActivite = '$codeTypeActivite' " ;}
		if ($niveaux != null){$sql .= "and t1.codeNiveau = '$niveaux' " ;}
		if ($region != null){$sql .= "and t1.comiteRegional = ' $region' " ;}
		$sql .= "order by t1.dateDebut ";

		$this->LoadTable($sql, $arrayCalendrier, $resulttype);

		//echo $sql;
	}

	function LoadCalendrierFormations(&$arrayCalendrierFormations, $dateDebut, $dateFin, $familleFormation = null, $typeFormation = null, $lstColumns="*", $resulttype=MYSQLI_ASSOC)
	{
		$sql = "Select $lstColumns from cal_formation ";
		$sql .="where dateFin between '$dateDebut' and '$dateFin' ";
		if ($familleFormation != null){$sql .= "and familleFormation = '$familleFormation' " ;}
		if ($typeFormation != null){$sql .= "and typeFormation = '$typeFormation' " ;}
		$sql .= "order by dateDebut ";

		$this->LoadTable($sql, $arrayCalendrierFormations, $resulttype);

		//echo $sql;
	}

	function getFichiersJoints(&$arrayFichiersJoints, $codex, $type = null, $resulttype=MYSQLI_ASSOC)
	{

		if($type=='form'){
			$sql = "select * from cal_formation_fichiersjoints ";
			$sql .= "where id_formation = '$codex' ";
		}
		else
		{
			$sql = "select * from cal_evenement_fichiersjoints ";
			$sql .= "where codex = '$codex' ";
		}

		$sql .= "Order By numero " ;

		//echo $sql;

		$this->LoadTable($sql, $arrayFichiersJoints, $resulttype); // faut-il charger dans un tableau ?
	}

	// function getPhoto(&$arrayFichiersJoints, $codex, $type = 'AFFICHE')
	// {
	// 	$sql = "select urlPhoto from cal_evenement_photos ";
	// 	$sql .= "where codex = '$codex' ";
	// 	$sql .= "And typePhoto = $type " ;

	// 	$result = $this->Query($sql);
	// 	$this->LoadTable($sql, $arrayPhoto, $resulttype); // faut-il charger dans un tableau ?

	// 	//return $value->urlPhoto;
	// }

}
?>
