<?php
/**
 * Cette classe contient toute la logique pour le Widget Sarbacane Desktop
 * @author Sarbacane Software
 */
class SarbacaneNewsWidget extends WP_Widget {
	public function __construct() {
		parent::__construct ( 'sarbacane_newsletter', __ ( 'Sarbacane Desktop Newsletter', 'sarbacane-desktop' ), array (
				'description' => __ ( 'Have visitors fill out this form and the associated list will be updated accordingly', 'sarbacane-desktop' ) 
		) );
	}
	
	/**
	 * Cette methode permet d'enregistrer les informations saisies par un utilisateur dans le widget
	 */
	public function sarbacane_save_widget() {
		$this->save_newsletter ();
	}
	
	/**
	 * Cette methode permet d'enregistrer les informations d'un utilisateur pour une liste de type newsletter
	 */
	public function save_newsletter() {
		$fields = get_option ( 'sarbacane_news_fields' );
		$users_registred = get_option ( 'sarbacane_newsletter_list', array () );
		$user_registring = new stdClass ();
		foreach ( $fields as $field ) {
			$field_label = stripslashes ( $field->label );
			$field_label_html = str_replace ( ' ', '_', $field_label );
			$field_label = strtolower ( $field_label );
			if (isset ( $_POST [$field_label_html] )) {
				$fieldValue = sanitize_text_field ( $_POST [$field_label_html] );
			} else {
				$fieldValue = "";
			}
			$user_registring->$field_label = $fieldValue;
		}
		$user_registring->registration_date = gmdate ( 'Y-m-d H:i:s' );
		array_push ( $users_registred, $user_registring );
		update_option ( 'sarbacane_newsletter_list', $users_registred );
		$this->display_registration_message ();
	}
	
	/**
	 * Cette methode permet d'afficher le message a� la fin de l'enregistrement d'un utilisateur et de rediriger vers la home page
	 */
	public function display_registration_message() {
		$registration_message = get_option ( 'sarbacane_news_registration_message', __ ( 'congrats_you_just_opt_in_our_newsletter', 'sarbacane-desktop' ) );
		?>
<script type="text/javascript">

			alert("<?php echo $registration_message ?>");
			document.location = "<?php echo get_home_url(); ?>";
		</script>
<?php
	}
	
	/**
	 * Cette methode est appele quand on cherche a� afficher le widget.
	 * Ici on recupere les infos sur les champs, le titre et la description puis on fait
	 * appel a� la page chargee de l'affichage
	 *
	 * @see WP_Widget::widget()
	 */
	public function widget($args, $instance) {
		$title = esc_html ( get_option ( 'sarbacane_news_title', '' ) );
		$description = esc_html ( get_option ( 'sarbacane_news_description', '' ) );
		$list_type = esc_html ( get_option ( 'sarbacane_news_list_type', 'users' ) );
		$fields = get_option ( 'sarbacane_news_fields' );
		if ($fields == null || sizeof ( $fields ) <= 0) {
			$default_email = new stdClass ();
			$email_field = __ ( 'email', 'sarbacane-desktop' );
			$default_email->label = $email_field;
			$default_email->mandatory = true;
			update_option ( 'sarbacane_news_fields', array (
					$default_email 
			) );
			$fields = get_option ( 'sarbacane_news_fields' );
		}
		$registration_button = esc_html ( get_option ( 'sarbacane_news_registration_button', __ ( 'Inscription', 'sarbacane-desktop' ) ) );
		$list_type = "N";
		wp_enqueue_script ( "sarbacane-widget.js", plugins_url ( "js/sarbacane-widget.js", __FILE__ ), array (
				'jquery' 
		) );
		wp_enqueue_style ( "sarbacane_widget.css", plugins_url ( "css/sarbacane_widget.css", __FILE__ ) );
		include ("views/sarbacane-widget.php");
	}
	/**
	 * Inutilisee ici, elle sort normalement a� l'enregistrement du parametrage
	 *
	 * @see WP_Widget::update()
	 */
	function update($new_instance, $old_instance) {
		return $old_instance;
	}
	/**
	 * Cette fonction est appelee pour l'affichage du parametrage du widget dans la gestion des widgets.
	 * Ici on demande de se referer a� l'onglet sarbacane widget
	 *
	 * @see WP_Widget::form()
	 */
	function form($instance) {
		_e ( 'Setup this widget by clicking the Sarbacane Desktop widget menu', 'sarbacane-desktop' );
	}
	
	/**
	 * Cette methode est appelee lors de l'ajout de l'extension a� WordPress.
	 * Elle enregistre le widget dans la liste
	 */
	function sarbacane_init_widget() {
		register_widget ( 'SarbacaneNewsWidget' );
	}
	/**
	 * Cette methode est appelee lors du clic sur le menu Widget Sarbacane
	 * On initialise les styles, et on enregistre les parametres si le formulaire a ete soumis puis on affiche la page de configuration
	 * du widget
	 */
	static function afficher_le_parametrage() {
		if (is_plugin_active ( SARBACANE__PLUGIN_DIRNAME . "/sarbacane.php" )) {
			wp_enqueue_style ( "sarbacane_global.css", plugins_url ( "css/sarbacane_global.css", __FILE__ ), array (
					'wp-admin' 
			) );
			wp_enqueue_style ( "sarbacane_widget_admin_panel.css", plugins_url ( "css/sarbacane_widget_admin_panel.css", __FILE__ ), array (
					'wp-admin' 
			) );
			wp_enqueue_script ( "sarbacane-widget-adminpanel.js", plugins_url ( "js/sarbacane-widget-adminpanel.js", __FILE__ ), array (
					'jquery',
					'jquery-ui-dialog',
					'underscore' 
			) );
			wp_enqueue_style ( "jquery-ui.min.css", plugins_url ( "css/jquery-ui.min.css", __FILE__ ) , array (
					'wp-admin' 
			) );
		}
		
		if (isset ( $_POST ['sarbacane_save_configuration'] )) {
			$sanitized_post = sanitize_post ( $_POST, 'db' );
			SarbacaneNewsWidget::save_parameters ( $sanitized_post );
		}
		
		$title = get_option ( 'sarbacane_news_title', __ ( 'newsletter', 'sarbacane-desktop' ) );
		$description = get_option ( 'sarbacane_news_description', __ ( 'get_our_news_and_promotion_monthly', 'sarbacane-desktop' ) );
		$registration_message = get_option ( 'sarbacane_news_registration_message', __ ( 'congrats_you_just_opt_in_our_newsletter', 'sarbacane-desktop' ) );
		$registration_button = get_option ( 'sarbacane_news_registration_button', __ ( 'Inscription', 'sarbacane-desktop' ) );
		
		$fields = get_option ( 'sarbacane_news_fields' );
		if ($fields == null || sizeof ( $fields ) <= 0) {
			$default_email = new stdClass ();
			$email_field = __ ( 'email', 'sarbacane-desktop' );
			$default_email->label = $email_field;
			$default_email->mandatory = true;
			update_option ( 'sarbacane_news_fields', array (
					$default_email 
			) );
			$fields = get_option ( 'sarbacane_news_fields' );
		}
		
		$list_type = "N";
		
		require_once 'views/sarbacane-widget-adminpanel.php';
	}
	/**
	 * Cette methode permet d'enregistrer les options choisies par l'utilisateur
	 *
	 * @param $sanitized_post un
	 *        	$_POST qui a ete nettoye par Wordpress
	 */
	static function save_parameters($sanitized_post) {
		$title = $sanitized_post ['sarbacane_widget_title'];
		$description = $sanitized_post ['sarbacane_widget_description'];
		$registration_button = $sanitized_post ['sarbacane_widget_registration_button'];
		$registration_message = $sanitized_post ['sarbacane_widget_registration_message'];
		$field_number = $sanitized_post ['sarbacane_field_number'];
		$fields = get_option ( "sarbacane_news_fields", array () );
		$new_fields = array ();
		// On parse le resultat de la requete pour recuperer les libelles et les valeurs par defaut parametres
		if (isset ( $field_number ) && $field_number > 0) {
			for($i = 0; $i < $field_number; $i ++) {
				$field_config = new stdClass ();
				if (isset ( $sanitized_post ['sarbacane_label_' . $i] ) && '' != $sanitized_post ['sarbacane_label_' . $i]) {
					$field_config->label = $sanitized_post ['sarbacane_label_' . $i];
					if (isset ( $sanitized_post ['sarbacane_field_' . $i] ) && '' != $sanitized_post ['sarbacane_field_' . $i]) {
						$field_config->placeholder = $sanitized_post ['sarbacane_field_' . $i];
					} else {
						$field_config->placeholder = "";
					}
					$field_config->mandatory = isset ( $sanitized_post ['sarbacane_mandatory_' . $i] ) && $sanitized_post ['sarbacane_mandatory_' . $i] == "true";
					array_push ( $new_fields, $field_config );
				}
			}
		}
		
		// Ici on a une difference de structure, des champs ont ete ajoutes ou supprimes
		// On flag une option pour qu'a la prochaine syncro, tout soit vide puis ajoute.
		if ($new_fields != $fields) {
			$sd_idEnregistres = get_option ( 'sarbacane_sd_id_list', array () );
			foreach ( $sd_idEnregistres as $sd_idEnregistre ) {
				update_option ( 'sarbacane_news_list_reset_' . $sd_idEnregistre, true );
			}
		}
		update_option ( 'sarbacane_news_title', $title );
		update_option ( 'sarbacane_news_description', $description );
		update_option ( 'sarbacane_news_fields', $new_fields );
		update_option ( 'sarbacane_news_registration_message', $registration_message );
		update_option ( 'sarbacane_news_registration_button', $registration_button );
	}
}
?>