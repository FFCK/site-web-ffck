<?php
include "adv/advBase.php";


class MyBaseCompet extends advBase
{
    // Constructeur
	function __construct($bConnect=true)
	{

		// Sous domaine compet.ffck.org
		$this->m_login = getenv("COMPET_DB_USER");
		$this->m_password = getenv("COMPET_DB_PASSWORD");
		$this->m_database = getenv("COMPET_DB_NAME");
		$this->m_server = getenv("COMPET_DB_HOST");


		if ($bConnect)
			$this->Connect();
	}

	function LoadCompetitions(&$arrayCompetition, $Code_activite, $etat, $saison = null, $dateDebut = null, $dateFin = null, $lstColumns="*", $resulttype=MYSQLI_ASSOC)
	{
		$sql = "select $lstColumns from Competition ";
		$sql .= "where Etat = $etat ";
		$sql .= "and Code_activite = '$Code_activite' ";
		if($saison != null) $sql .= "and Code_saison in ($saison) ";
		if($dateFin != null && $dateDebut !=null) $sql .= "and Date_fin between $dateDebut and $dateFin ";

		$this->LoadTable($sql, $arrayCompetition, $resulttype);

		//echo '<p>' . $sql . '</p>';
	}

	function LoadCompetition(&$arrayCompetition, $CodeCompetition, $lstColumns="*", $resulttype=MYSQLI_ASSOC)
	{

		$sql = "select $lstColumns from Competition ";
		$sql .= "where Code = '$codeCompetition' ";

		$this->LoadTable($sql, $arrayCompetition, $resulttype);

		//echo '<p>' . $sql . '</p>';
	}



	function LoadBateaux(&$arrayParticipants, $codeCompetition, $codeClub, $lstColumns="*", $order="Code_categorie, Bateau", $resulttype=MYSQLI_ASSOC)
	{
		$sql  = "Select $lstColumns from Resultat ";
		$sql .= "Where Code_competition = $codeCompetition ";
		if($codeClub != null){$sql .= "And Numero_club = $codeClub ";}
		$sql .= "Order By $order ";
		$this->LoadTable($sql, $arrayParticipants, $resulttype);

		//echo '<p>' . $sql . '</p>';
	}

	function LoadParticipants(&$arrayParticipants, $codeCompetition, $codeActivite, $codeCategorie = null,  $codeClub = null, $resulttype=MYSQLI_ASSOC)
	{
		$sql = "Select t1.Code_categorie, t1.Code_Bateau, t1.Bateau, t2.Matric, t3.Nom, t3.Prenom, t3.Club, t3.Numero_club from Resultat t1 ";
		$sql .= "left join Liste_Bateaux_Coureur t2 on t2.Numero = t1.Code_bateau ";
		$sql .= "inner join Liste_Coureur t3 on t3.Matric = t2.Matric ";
		$sql .= "Where t1.Code_competition = $codeCompetition ";
		if($codeCategorie != null) $sql .= "and t1.Code_categorie = '$codeCategorie' ";
		$sql .= "and t2.Origine = '$codeActivite' ";
		if($codeClub != null) $sql .= "Having t3.Numero_club = $codeClub ";
		$sql .= "Order By t1.Code_categorie, t1.Code_Bateau, t2.Matric ";
		$this->LoadTable($sql, $arrayParticipants, $resulttype);

		//echo '<p>' . $sql . '</p>';
	}

	function LoadCategories(&$arrayCategories, $codeCompetition, $codeActivite, $codeClub = null, $resulttype=MYSQLI_ASSOC)
	{
		$sql = "Select Count(*) Nb, t1.Code_categorie from Resultat t1 ";
		$sql .= "left join Liste_Bateaux_Coureur t2 on t2.Numero = t1.Code_bateau ";
		$sql .= "inner join Liste_Coureur t3 on t3.Matric = t2.Matric ";
		$sql .= "Where t1.Code_competition = $codeCompetition ";
		$sql .= "and t2.Origine = '$codeActivite' ";
		if($codeClub != null) $sql .= "and t3.Numero_club = $codeClub ";
		$sql .= "Group By t1.Code_categorie ";
		$sql .= "Order By t1.Code_categorie ";
		$this->LoadTable($sql, $arrayCategories, $resulttype);

		//echo '<p>' . $sql . '</p>';
	}
}

?>
