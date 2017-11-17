<?php
/**
 * @deprecated Non utilisée dans cette version
 * Cette classe contient toute la logique pour le Widget Sarbacane Desktop
 * @author Sarbacane Software
 */
class SarbacaneUsersWidget extends WP_Widget {
	public function __construct() {
		parent::__construct ( 'sarbacane_users', __ ( 'sarbacane_wordpress_users', 'sarbacane-desktop' ), array ('description' => __ ( 'Have visitors fill out this form and the associated list will be updated accordingly', 'sarbacane-desktop' ) ) );
	}
	
	/**
	 * Cette méthode permet d'enregistrer les informations saisies par un utilisateur dans le widget
	 */
	public function sarbacane_save_widget() {
		$this->save_users ();
	}
	/**
	 * Cette méthode est appelée pour enregistrer un utilisateur lorsque le type de liste est users
	 */
	public function save_users() {
		$fields = get_option ( 'sarbacane_users_fields' );
		$userdata = array ();
		
		$userdata = array_merge ( $userdata, array ('user_login' => sanitize_text_field ( $_POST [__ ( 'email', 'sarbacane-desktop' )] ) ) );
		$userdata = array_merge ( $userdata, array ('user_email' => $userdata ['user_login'] ) );
		$userdata = array_merge ( $userdata, array ('user_pass' => md5 ( $userdata ['user_login'] ) ) );
		$userdata = array_merge ( $userdata, array ('user_login' => $userdata ['user_login'] ) );
		$userdata = array_merge ( $userdata, array ('nickname' => $userdata ['user_login'] ) );
		$userdata = array_merge ( $userdata, array ('display_name' => $userdata ['user_login'] ) );
		$userdata = array_merge ( $userdata, array ('date_registered' => date ( 'Y-m-d H:i:s' ) ) );
		$userdata = array_merge ( $userdata, array ('role' => get_option ( 'default_role' ) ) );
		
		$id = wp_insert_user ( $userdata );
		if (! is_numeric ( $id )) {
			// Ici on a une erreur donc on l'alerte (elle est déjà traduite) et on redirige vers l'accueil
			$errors = array_keys ( $id->errors );
			?>
<script type="text/javascript">
					<!--
						alert("<?php echo utf8_decode(html_entity_decode($id->errors[$errors[0]][0]))?>");
						document.location = "<?php echo get_home_url(); ?>";
						
					//-->
					</script>
<?php
		} else {
			// L'enregistrement de l'utilisateur s'est bien déroulé.
			// On enregistre les infos complémentaires dans les meta
			foreach ( $fields as $field ) {
				if (isset ( $_POST [$field->label] )) {
					$fieldValue = sanitize_text_field ( $_POST [$field->label] );
				}
				switch ($field->label) {
					case __ ( 'email', 'sarbacane-desktop' ) :
						break;
					default :
						update_user_meta ( $id, 'sd_' . strtolower ( $field->label ), $fieldValue );
						break;
				}
			}
			// Puis on redirige à l'accueil
			$this->display_registration_message();
		}
	}
	/**
	 * Cette méthode permet d'afficher le message à la fin de l'enregistrement d'un utilisateur et de rediriger vers la home page
	 */
	public function display_registration_message() {
		$registration_message = get_option('sarbacane_users_registration_message',__('inscription_a_la_newsletter_terminee','sarbacane-desktop'));
		?>
		<script type="text/javascript">
		<!--
			alert("<?php echo $registration_message ?>");
			document.location = "<?php echo get_home_url(); ?>";
		//-->
		</script>
<?php
	}
	
	/**
	 * Cette méthode est appelé quand on cherche à afficher le widget.
	 * Ici on récupère les infos sur les champs, le titre et la description puis on fait
	 * appel à la page chargée de l'affichage
	 *
	 * @see WP_Widget::widget()
	 */
	public function widget($args, $instance) {
		$title = esc_html(get_option ( 'sarbacane_users_title', '' ));
		$description = esc_html(get_option ( 'sarbacane_users_description', '' ));
		$fields = get_option ( 'sarbacane_users_fields', array (__ ( 'email', 'sarbacane-desktop' ) => null ) );
		$registration_button = esc_html(get_option ( 'sarbacane_users_registration_button' , __('Inscription','sarbacane-desktop')));
		$list_type = "C";
		wp_enqueue_script ( "sarbacane-widget.js", plugins_url ( "js/sarbacane-widget.js", dirname(__FILE__) ), array ('jquery' ) );
		
		include ("views/sarbacane-widget.php");
	}
	/**
	 * Inutilisée ici, elle sort normalement à l'enregistrement du paramétrage
	 *
	 * @see WP_Widget::update()
	 */
	function update($new_instance, $old_instance) {
	}
	/**
	 * Cette fonction est appelée pour l'affichage du paramétrage du widget dans la gestion des widgets.
	 * Ici on demande de se référer à l'onglet sarbacane widget
	 *
	 * @see WP_Widget::form()
	 */
	function form($instance) {
		_e ( 'Setup this widget by clicking the Sarbacane Desktop widget menu', 'sarbacane-desktop' );
	}
	
	/**
	 * Cette méthode est appelée lors de l'ajout de l'extension à WordPress.
	 * Elle enregistre le widget dans la liste
	 */
	function sarbacane_init_widget() {
		register_widget ( 'SarbacaneUsersWidget' );
	}
	/**
	 * Cette méthode est appelée lors du clic sur le menu Widget Sarbacane
	 * On initialise les styles, et on enregistre les paramètres si le formulaire a été soumis puis on affiche la page de configuration
	 * du widget
	 */
	function afficher_le_parametrage() {
		wp_enqueue_script ( "sarbacane-widget-adminpanel.js", plugins_url ( "js/sarbacane-widget-adminpanel.js", dirname(__FILE__) ), array ('jquery' ) );
		if (isset ( $_POST ['sarbacane_save_configuration'] )) {
			$sanitized_post = sanitize_post ( $_POST, 'db' );
			SarbacaneUsersWidget::save_parameters ( $sanitized_post );
		}
		$title = get_option ( 'sarbacane_users_title', '' );
		$description = get_option ( 'sarbacane_users_description', '' );
		$registration_message = get_option ( 'sarbacane_users_registration_message');
		$registration_button = sanitize_option('sarbacane_users_registration_button', get_option ( 'sarbacane_users_registration_button' , __('Inscription','sarbacane-desktop')));
		$default_email = new stdClass ();
		$email_field = __ ( 'email', 'sarbacane-desktop' );
		$default_email->label = $email_field;
		$default_email->mandatory = true;
		$fields = get_option ( 'sarbacane_users_fields', array ($default_email ) );
		$list_type="C";
		require_once 'views/sarbacane-widget-adminpanel.php';
	}
	/**
	 * Cette méthode permet d'enregistrer les options choisies par l'utilisateur
	 *
	 * @param $sanitized_post un
	 *        	$_POST qui a été nettoyé par Wordpress
	 */
	static function save_parameters($sanitized_post) {
		$title = $sanitized_post ['sarbacane_widget_title'];
		$description = $sanitized_post ['sarbacane_widget_description'];
		$list_type = $sanitized_post ['sarbacane_widget_list_type'];
		$registration_button = $sanitized_post['sarbacane_widget_registration_button'];
		$registration_message = $sanitized_post['sarbacane_widget_registration_message'];
		$field_number = $sanitized_post ['sarbacane_field_number'];
		$fields = get_option ( "sarbacane_widget_fields", array () );
		$new_fields = array ();
		// On parse le résultat de la requête pour récupérer les libellés et les valeurs par défaut paramétrés
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
					$field_config->mandatory = isset ( $sanitized_post ['sarbacane_mandatory_' . $i] );
					array_push ( $new_fields, $field_config );
				}
			}
		}
		
		// Ici on a une différence de structure, des champs ont été ajoutés ou supprimés
		// On flag une option pour qu'à la prochaine syncro, tout soit vidé puis ajouté.
		if ($new_fields != $fields) {
			update_option ( 'sarbacane_users_updated_structure', true );
		}
		update_option ( 'sarbacane_users_title', $title );
		update_option ( 'sarbacane_users_description', $description );
		update_option ( 'sarbacane_users_fields', $new_fields );
		update_option ( 'sarbacane_users_registration_message', $registration_message);
		update_option ( 'sarbacane_users_registration_button', $registration_button);
	}
}
?>