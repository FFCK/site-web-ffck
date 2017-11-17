<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

include_once('base.php');

define("VERSION", "Version 1.00");
define("VERSION_BOOTSTRAP", "-3.2.0");

// Classe de Base pour toutes les Pages ...
class MyPage 		
{
	var $m_arrayParams;		// Tableau des Paramètres
	var $m_level;			// Niveau de protection
	var $m_menu;			// Tableau associatif Informations Menu
	var $m_directory;		// Repertoire principal

	// Constructeur ...
	function __construct(&$arrayParams)
	{
		$this->Init($arrayParams);
		$this->Display();
	}
	
	public static function GetDirectory()
	{
		if (PRODUCTION)
			return '/module/';
		else
			return '/module/';
	}

	function Init(&$arrayParams)
	{
		session_start();
		$this->m_arrayParams = &$arrayParams;
		
		$this->m_directory = MyPage::GetDirectory();
		$this->m_level = 0;
		
		$_SESSION['context_menu'] = 'PUB' ; // PUBLIC 
	}
	
    // GetParam ...
    function GetParam($key, $defaultValue='')
    {
        return utyGetString($this->m_arrayParams, $key, $defaultValue);
    }
	
    function GetParamBool($key, $defaultValue=false)
    {
        return utyGetBool($this->m_arrayParams, $key, $defaultValue);
    }
	
    function GetParamInt($key, $defaultValue=-1)
    {
        return utyGetInt($this->m_arrayParams, $key, $defaultValue);
    }

    function GetParamDouble($key, $defaultValue=0.0)
    {
        return utyGetDouble($this->m_arrayParams, $key, $defaultValue);
    }
	
	
	function Head()
    {
        ?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="FFCK">
		<meta name="Keywords" content="ffck, canoe, kayak, course en ligne" />
		<meta name="author" content="FFCK - Agil Informatique">
		<meta name="rating" content="general">
		<meta name="Robots" content="all">
		<link rel="icon" href="./favicon.ico">
		
		<?php $this->HeadTitle(); ?>
		
		<!-- Bootstrap core CSS bootstrap.min_cerulean 1) ou _slate 2) -->
		<link href="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/css/bootstrap.min_cerulean.css" rel="stylesheet"/>
		<link href="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/datepicker/css/datepicker3.css" rel="stylesheet"/>

		<link href="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/select2/select2.css" rel="stylesheet"/>
		<link href="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/select2/select2-bootstrap.css" rel="stylesheet"/>

		<link href="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/bootstrapvalidator/css/bootstrapValidator.min.css" rel="stylesheet"/>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- Global -->
		<link href="./css/global.css" rel="stylesheet">
		
		<?php
	}

	function HeadTitle()
	{
        ?><title>F.F.C.K.</title><?php
	}
	
	function Body()
	{   
		$this->Menu();

		echo "<div class='container'>\n";
		$this->Header();
		$this->Content();
		echo "</div>\n";    // div container end ...

		$this->ModalWaitProgress();
		$this->Footer();
		$this->Script();
	 }

    // Affichage Classique de la Page ...
    function Display()
    {		
		?>
		<!DOCTYPE html>
		<html lang="fr">
 
		<head>
        <?php $this->Head(); ?>
		</head>
  		
        <body>
        <?php $this->Body(); ?>
        </body>

        </html>
		<?php
    }
	
	// Header ...
	function Header()
	{
	?>
		<h3>Tous les Résultats et les Classements des Compétitions de la F.F.C.K.</h3> 
	<?php
	}
	
	// Menu ...
	function Menu()
	{
/*		
		$menu = &$this->m_menu;
	?>		
	<div class="navbar-wrapper">
		<div class="container">
        <div class="navbar navbar-inverse navbar-static-top" role="navigation">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">F.F.C.K.</a>
            </div>
            <div class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                 <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Compétition<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
					<li class="dropdown-header">Eau Vive</li>
                    <li><a href="#">Slalom</a></li>
                    <li><a href="#">Descente</a></li>
                    <li class="divider"></li>
					<li class="dropdown-header">Eau Calme</li>
                     <li><a href="#">Mérathon</a></li>
                     <li><a href="#">Kayak Polo</a></li>
                  </ul>
                </li>

                 <li class="active dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">Calendrier<span class="caret"></span></a>
                  <ul class="dropdown-menu" role="menu">
					<li class="dropdown-header">Eau Vive</li>
                    <li><a href="#">Slalom</a></li>
                    <li><a href="#">Descente</a></li>
                    <li class="divider"></li>
					<li class="dropdown-header">Eau Calme</li>
                     <li><a href="#">Mérathon</a></li>
                     <li><a href="#">Kayak Polo</a></li>
                  </ul>
                </li>
                <li><a href="#">Contact</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
	<?php
	*/
    }
	
    // Section Content ...
    function Content()
    {
    }
	
	function ModalWaitProgress()
	{
	?>
		<div class="modal" id="modal_wait_progress" tabindex="-1" role="dialog" aria-labelledby="modal_wait_progress" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
				<div class="modal-header">
					<h3>Patientez...</h3>
				</div>
				<div class="modal-body">
					<div class="progress progress-striped active">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
					</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	<?php
	}

	static public function InfoLogin()
	{
		$login = utyGetSession('ffck_login');
		if ($login == '')
			return 'aucune identification ...';
		
		$infoLogin = $login.' - '.utyGetSession('ffck_identite').' (Adh : '.utyGetSession('ffck_code_adherent');
		if (utyGetSession('ffck_structure') == 'F')
			$infoLogin .= ' - National) ';
		elseif (utyGetSession('ffck_structure') == 'L')
			$infoLogin .= ' - Ligue : '.utyGetSession('ffck_club').')';
		elseif (utyGetSession('ffck_structure') == 'C')
			$infoLogin .= ' - Club : '.utyGetSession('ffck_club').')';
	
		return $infoLogin;
	}
	
	static public function InfoProduction()
	{
		if (MyPage::IsPreProduction())
			return ' | PRE-PRODUCTION';
		else
			return '';
	}
	
	static public function IsPreProduction()
	{
		if ((strpos(__FILE__, 'entries_test') === false) && (strpos(__FILE__, 'devWEB') === false))
			return false;
		else
			return true;
	}
	
	static public function GetVersion()
	{
		return '1.2';
	}
	
	// Section Footer ...
	function Footer()
	{
		?>		
		<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">
					<div class="col-md-12 widget">
						<h2 class="widget-title">Identification</h2>
						<div class="widget-body">
							<h4 id='info_login'><?php echo $this->InfoLogin().$this->InfoProduction(); ?></h4>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="footer2">
			<div class="container">
				<div class="row">
					<div class="col-offset-5 col-md-7 widget">
						<div class="widget-body">
							<p class="text-right">
								Version <?php echo MyPage::GetVersion() ?> Copyright &copy; 2016, Agil Informatique, F.F.C.K.
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>	
	<?php
    }
	
    function Script()
    {
    ?>
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/js/jquery.js"></script>
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/js/bootstrap.min.js"></script>

		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/js/ie10-viewport-bug-workaround.js"></script>
		
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/js/bootbox.min.js"></script>
		
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/datepicker/js/bootstrap-datepicker.js"></script>
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/datepicker/js/locales/bootstrap-datepicker.fr.js" charset="UTF-8"></script>

		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/select2/select2.js"></script>
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/select2/select2_locale_fr.js"></script>

		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
		<script type="text/javascript" src="<?php echo $this->m_directory.'/lib/bootstrap'.VERSION_BOOTSTRAP;?>/bootstrapvalidator/js/language/fr_FR.js"></script>
		
		<script type="text/javascript" src="<?php echo $this->m_directory;?>/calendrier/js/wait_progress.js" ></script>
		<script type="text/javascript" src="<?php echo $this->m_directory;?>/calendrier/js/messagebox.js" ></script>
    <?php
    }
}
?>