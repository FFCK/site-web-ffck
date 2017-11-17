<?php
/**
 * This class contains all logic for SarbacaneDesktop's Wordpress plugin.
 * 
 * @author SarbacaneSoftware
 *
 */
class Sarbacane {
	function __construct() {
	}
	
	/**
	 * Method called on plugin activation.
	 * Initiate some options, creates the sd updates table
	 */
	public static function plugin_activation() {
		update_option ( "sarbacane_sd_token", "" );
		update_option ( "sarbacane_sd_id_list", array () );
		update_option ( 'sarbacane_news_registration_button', __ ( 'Inscription', 'sarbacane-desktop' ) );
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'sd_updates';
		
		$charset_collate = $wpdb->get_charset_collate ();
		
		$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		user_id int(9) NULL,
		user_email varchar(255) NULL,
		action text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";
		
		require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta ( $sql );
	}
	/**
	 * Method called on plugin deactivation.
	 * Deletes all options created by the plugin and drops the sd_updates table
	 */
	public static function plugin_deactivation() {
		delete_option ( 'sarbacane_sd_token' );
		$sd_idEnregistres = get_option ( 'sarbacane_sd_id_list', array () );
		foreach ( $sd_idEnregistres as $sd_idEnregistre ) {
			delete_option ( 'sarbacane_sd_list_' . $sd_idEnregistre );
			delete_option ( 'sarbacane_sd_news_' . $sd_idEnregistre );
			delete_option ( 'sarbacane_news_list_reset_' . $sd_idEnregistre );
			delete_option ( 'sarbacane_user_list_reset_' . $sd_idEnregistre );
		}
		delete_option ( 'sarbacane_sd_id_list' );
		delete_option ( 'sarbacane_news_list' );
		delete_option ( 'sarbacane_users_list' );
		delete_option ( 'sarbacane_theme_sync' );
		delete_option ( 'sarbacane_blog_content' );
		delete_option ( 'sarbacane_media_content' );
		delete_option ( 'sarbacane_rss_data' );
		
		global $wpdb;
		$table_name = $wpdb->prefix . 'sd_updates';
		$sql = "DROP TABLE IF EXISTS $table_name";
		$wpdb->query ( $sql );
	}
	
	/**
	 * Called on menu generation (admin_menu hook).
	 * Adds this plugin menus
	 */
	public function sarbacane_admin_menu() {
		$sd_list_news = get_option ( 'sarbacane_news_list', false );
		
		if (function_exists ( 'add_menu_page' )) {
			add_menu_page ( __ ( 'configuration', 'sarbacane-desktop' ), __ ( 'Sarbacane Desktop', 'sarbacane-desktop' ), 'administrator', 'sarbacane', array (
					SarbacaneAbout,
					'afficher_le_parametrage' 
			), WP_PLUGIN_URL . '/' . SARBACANE__PLUGIN_DIRNAME .'/images/favicon_sarbacane.png' );
			add_submenu_page ( 'sarbacane', __ ( 'Connection', 'sarbacane-desktop' ), __ ( 'Connection', 'sarbacane-desktop' ), 'administrator', 'wp_interconnection', array (
					$this,
					'afficher_le_parametrage' 
			) );
			add_submenu_page ( 'sarbacane', __ ( 'configuration', 'sarbacane-desktop' ), __ ( 'Configuration', 'sarbacane-desktop' ), 'administrator', 'wp_lists_sync', array (
					SarbacaneListsSync,
					'afficher_le_parametrage' 
			) );
			if ($sd_list_news) {
				add_submenu_page ( 'sarbacane', __ ( 'widget', 'sarbacane-desktop' ), __ ( 'widget', 'sarbacane-desktop' ), 'administrator', 'wp_news_widget', array (
						SarbacaneNewsWidget,
						'afficher_le_parametrage' 
				) );
			}
		}
	}
	
	/**
	 * Loads this plugin locale
	 */
	public function sarbacane_load_locales() {
		load_plugin_textdomain ( 'sarbacane-desktop', false, dirname ( plugin_basename ( __FILE__ ) ) . '/locales' );
	}
	
	/**
	 * Cette méthode permet d'afficher la page de param�trage du plugin.
	 * Elle lance également la génération du sd_token (si elle n'existe pas) et de la clé de configuration.
	 */
	public function afficher_le_parametrage() {
		$sd_token = get_option ( 'sarbacane_sd_token' );
		if (isset ( $_POST ['sarbacane_redo_token'] )) {
			$sd_token = delete_option ( 'sarbacane_sd_token' );
			do_action ( 'sarbacane-paramssaved' );
			$sd_token = $this->generer_token ();
			update_option ( 'sarbacane_sd_token', $sd_token );
			update_option ( 'sarbacane_sd_id_list', array () );
		}
		if ($sd_token != null && $sd_token != "") {
			$cle = $this->generer_cle ( $sd_token );
		}
		$sd_list_news = get_option ( 'sarbacane_news_list', false );
		$sdid_array = get_option ( 'sarbacane_sd_id_list' );
		require_once ('views/sarbacane-adminpanel.php');
	}
	
	/**
	 * Permet d'afficher un message lorsque la clé est regénérée
	 */
	public function sarbacane_flash_message() {
		echo '<div class="updated">' . __ ( 'a_new_key_has_been_generated', 'sarbacane-desktop' ) . '</div>';
	}
	
	/**
	 * Cette méthode permet d'effectuer la concaténation des chaines constituants la clé et lance la rotation (str_rot13)
	 *
	 * @param unknown $token        	
	 * @return string
	 */
	public function generer_cle($token) {
		$cle = str_replace(home_url(), '', plugin_dir_url(__FILE__)) . 'views/sarbacane-getlist.php?sd_token=' . $token;
		$cle = str_rot13 ( $cle );
		return $cle;
	}
	
	/**
	 * Cette méthode permet de générer le sd_token qui sera utilisé pour la synchronisation de Sarbacane Desktop à WordPress
	 * Longueur de 24 caractères choisis aléatoirement dans [0-9A-Za-z]
	 */
	public function generer_token() {
		$longueur_cle = 24;
		$cle = "";
		while ( strlen ( $cle ) < $longueur_cle ) {
			$type_char = mt_rand ( 0, 2 );
			switch ($type_char) {
				case 0 :
					$char = chr ( mt_rand ( 48, 57 ) );
					break;
				case 1 :
					$char = chr ( mt_rand ( 65, 90 ) );
					break;
				case 2 :
					$char = chr ( mt_rand ( 97, 122 ) );
					break;
			}
			$cle .= $char;
		}
		return $cle;
	}
	
	/**
	 * Cette fonction permet de récupérer la liste des nouveaux inscrits au site Wordpress
	 *
	 * @param string $sd_id
	 *        	le sd_id fourni par sarbacane lors de l'appel à la page.
	 * @param string $sd_token
	 *        	contient le token permettant d'assurer la provenance de l'appel
	 * @param string $sd_list_id.
	 *        	Si vide, la page retourne la liste des listes de mail. Si présent on retourne les mails pour cette liste.
	 * @throws WP_Error
	 */
	public function sarbacane_get_list($sd_id, $sd_token, $sd_list_id) {
		// Here we check if the provided list id is correct
		if (isset ( $sd_list_id )) {
			if ($sd_list_id != "N" && $sd_list_id != "U") {
				header ( 'HTTP/1.1 404 Not found' );
				header ( "Content-type: application/json ; charset=utf-8" );
				die ( 'FAILED_ID' );
			}
		}
		
		$sd_list_news = get_option ( 'sarbacane_news_list', false );
		$sd_list_users = get_option ( 'sarbacane_users_list', false );
		
		// If first connect for this client, reset flags set to 1, sdid save
		$sd_id_enregistres = get_option ( 'sarbacane_sd_id_list', array () );
		if (array_search ( $sd_id, $sd_id_enregistres ) === FALSE) {
			array_push ( $sd_id_enregistres, $sd_id );
			update_option ( sarbacane_sd_id_list, $sd_id_enregistres );
			update_option ( 'sarbacane_user_list_reset_' . $sd_id, true );
			update_option ( 'sarbacane_news_list_reset_' . $sd_id, true );
		}
		if (isset ( $sd_list_id )) {
			if ("U" == $sd_list_id) {
				$this->get_users_list ( $sd_id );
			} else if ("N" == $sd_list_id) {
				$this->get_newsletter_list ( $sd_id );
			}
		} else {
			$this->generate_available_lists ( $sd_id, $sd_list_users, $sd_list_news );
		}
	}
	public function generate_available_lists($sd_id, $user_sync, $newsletter_sync) {
		echo 'list_id;name;reset;is_updated;type;version' . "\r\n";
		
		$sd_list_users_reset = get_option ( 'sarbacane_user_list_reset_' . $sd_id, false );
		$sd_list_news_reset = get_option ( 'sarbacane_news_list_reset_' . $sd_id, false );
		
		if ($sd_list_users_reset) {
			$sd_list_users_reset = 'Y';
		} else {
			$sd_list_users_reset = 'N';
		}
		if ($sd_list_news_reset) {
			$sd_list_news_reset = 'Y';
		} else {
			$sd_list_news_reset = 'N';
		}
		
		$last_call_date_N = get_option ( 'sarbacane_N_call_' . $sd_id );
		$last_call_date_C = get_option ( 'sarbacane_C_call_' . $sd_id );
		if ($last_call_date_N != '') {
			if ($this->check_newsletter_list ( $last_call_date_N )) {
				$newsletter_updated = 'Y';
			} else {
				$newsletter_updated = 'N';
			}
		} else {
			$newsletter_updated = 'Y';
		}
		if ($last_call_date_C != '') {
			if ($this->check_users_list ( $last_call_date_C )) {
				$user_updated = 'Y';
			} else {
				$user_updated = 'N';
			}
		} else {
			$user_updated = 'Y';
		}
		if ($user_sync) {
			echo 'U;' . get_bloginfo ( 'name' ) . ';' . $sd_list_users_reset . ';' . $user_updated . ';Wordpress;' . get_bloginfo ( 'version' ) . "\r\n";
		}
		if ($newsletter_sync) {
			echo 'N;' . get_bloginfo ( 'name' ) . ';' . $sd_list_news_reset . ';' . $newsletter_updated . ';Wordpress;' . get_bloginfo ( 'version' ) . "\r\n";
		}
	}
	
	/**
	 * Cette méthode permet de savoir si la liste des utilisateurs a changé depuis le dernier appel à la page
	 *
	 * @param string $sd_id        	
	 * @param string $sd_token        	
	 * @return boolean
	 */
	public function check_users_list($last_call_date) {
		global $wpdb;
		$wp_prefix = $wpdb->prefix;
		$table_name = $wpdb->prefix . 'sd_updates';
		
		$new_users_since_last_call = $wpdb->get_var ( 'SELECT COUNT(*) FROM ' . $wp_prefix . 'users AS wu WHERE wu.user_registered >= "' . $last_call_date . '"' );
		$update_users_since_last_call = $wpdb->get_var ( 'SELECT COUNT(*) FROM ' . $table_name . ' AS wsu WHERE wsu.time >= "' . $last_call_date . '"' );
		return $new_users_since_last_call > 0 || $update_users_since_last_call > 0;
	}
	
	/**
	 * Cette méthode permet de savoir si la liste des inscrits à la newsletter a changé depuis le dernier appel à la page
	 *
	 * @param string $sd_id        	
	 * @param string $sd_token        	
	 * @return boolean
	 */
	public function check_newsletter_list($last_call_date = '') {
		$all_subscribers = $this->get_all_subscribers ();
		foreach ( $all_subscribers as $one_subscriber ) {
			if ($one_subscriber->registration_date > $last_call_date) {
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Cette méthode permet de générer le CSV pour la liste des inscrits à la newsletter
	 *
	 * @param string $sd_id        	
	 * @param string $sd_token        	
	 */
	public function get_newsletter_list($sd_id) {
		$sd_news_updated_structure = get_option ( 'sarbacane_news_list_reset_' . $sd_id, false );
		$last_call_date = get_option ( 'sarbacane_N_call_' . $sd_id, '' );
		update_option ( 'sarbacane_N_call_' . $sd_id, gmdate ( 'Y-m-d H:i:s' ) );
		
		$email_field = 'email';
		$all_subscribers = $this->get_all_subscribers ();
		
		if ($sd_news_updated_structure) {
			delete_option ( 'sarbacane_news_list_reset_' . $sd_id );
			$last_call_date = '';
		}
		$new_or_updated_users = array ();
		foreach ( $all_subscribers as $one_subscriber ) {
			if ($one_subscriber->registration_date > $last_call_date) {
				$new_entry = array (
						$one_subscriber->$email_field => $one_subscriber 
				);
				$new_or_updated_users = array_merge ( $new_or_updated_users, $new_entry );
			}
		}
		$this->clear_update_history ();
		echo $this->generate_csv ( $new_or_updated_users, array (), 'N' );
	}
	
	/**
	 * Cette méthode permet de générer le CSV pour la liste des inscrits au site
	 *
	 * @param string $sd_id        	
	 * @param string $sd_token        	
	 */
	public function get_users_list($sd_id) {
		$last_call_date = get_option ( 'sarbacane_C_call_' . $sd_id, '' );
		update_option ( 'sarbacane_C_call_' . $sd_id, gmdate ( 'Y-m-d H:i:s' ) );
		$sd_users_updated_structure = get_option ( 'sarbacane_user_list_reset_' . $sd_id, false );
		if ($sd_users_updated_structure) {
			delete_option ( 'sarbacane_user_list_reset_' . $sd_id );
			$last_call_date = '';
		}
		// Récupération ou création de la liste d'emails pour le SD_ID
		$all_users = $this->sarbacanedesktop_get_all_users ( $last_call_date );
		$deleted_users = $this->sarbacanedesktop_get_all_deleted_users ( $last_call_date );
		$this->clear_update_history ();
		echo $this->generate_csv ( $all_users, $deleted_users, 'U' );
	}
	
	/**
	 * Cette méthode génère le CSV final que Sarbacane Desktop inteprètera
	 *
	 * @param array $new_or_updated_users
	 *        	un <code>Array</code> d'<code>Object</code> contenant les informations utilisateurs
	 * @param array $users_deleted
	 *        	un <code>Array</code> de <code>String</code> représentant les emails à supprimer
	 * @return une chaine au format CSV (séparateur de champ <code>;</code> séparateur de ligne <code>\r\n</code>
	 */
	public function generate_csv($new_or_updated_users, $deleted_users = array(), $list_type) {
		if ("N" == $list_type) {
			$fields = get_option ( 'sarbacane_news_fields', null );
			// Entete
			$csv_string .= "email;";
			foreach ( $fields as $field ) {
				if (strcmp ( $field->label, __ ( 'email', 'sarbacane-desktop' ) ) != 0 && strcmp ( strtolower ($field->label),  stripslashes ( __ ( 'email', 'sarbacane-desktop' ) ) )  != 0) {
					$csv_string .= stripslashes ( $field->label ) . ';';
				}
			}
			$csv_string .= "action\r\n";
			
			foreach ( $new_or_updated_users as $one_user_updated ) {
				$label = strtolower ( stripslashes ( __ ( 'email', 'sarbacane-desktop' ) ) );
				$csv_string .= stripslashes ( $one_user_updated->$label ) . ';';
				
				foreach ( $fields as $field ) {
					if (strcmp ( $field->label, __ ( 'email', 'sarbacane-desktop' ) ) != 0 && strcmp ( $field->label, strtolower ( stripslashes ( __ ( 'email', 'sarbacane-desktop' ) ) ) ) != 0) {
						$label = strtolower ( stripslashes ( $field->label ) );
						$csv_string .= stripslashes ( $one_user_updated->$label ) . ';';
					}
				}
				$csv_string .= 'S' . "\r\n";
			}
		} else {
			// Entete
			$csv_string = 'email;lastname;firstname;login;role;post_count;action' . "\r\n";
			if (sizeof ( $new_or_updated_users ) > 0) {
				foreach ( $new_or_updated_users as $one_user_updated ) {
					$role = "";
					if ($one_user_updated->user_role != null) {
						$role_array = unserialize ( $one_user_updated->user_role );
						if ($role_array != null && is_array ( $role_array )) {
							$role_array_keys = array_keys ( $role_array );
							if ($role_array_keys != null && sizeof ( $role_array_keys ) > 0) {
								$role = $role_array_keys [0];
							}
						}
					}
					$csv_string .= $one_user_updated->email . ';' . $one_user_updated->lastname . ';' . $one_user_updated->firstname . ';' . $one_user_updated->user_login . ';' . $role . ';' . $one_user_updated->user_posts . ';S' . "\r\n";
				}
			}
			if (sizeof ( $deleted_users ) > 0) {
				foreach ( $deleted_users as $deleted_user ) {
					$csv_string .= $deleted_user->user_email . ';;;;;;U' . "\r\n";
				}
			}
		}
		return $csv_string;
	}
	
	/**
	 * Permet de récupérer l'ensemble des utilisateurs inscrits au site.
	 * La méthode retourne un array d'Object représentant chacun un utilisateur
	 *
	 * @return mixed
	 */
	public function sarbacanedesktop_get_all_users($last_call_date) {
		global $wpdb;
		$wp_prefix = $wpdb->prefix;
		$table_name = $wpdb->prefix . 'sd_updates';
		if ($last_call_date == '') {
			$all_users = $wpdb->get_results ( 'SELECT wu.id as user_id,wu.user_login as user_login,wu.user_email AS email,wmf.meta_value AS firstname, wml.meta_value AS lastname, wum.meta_value AS user_role FROM ' . $wp_prefix . 'users AS wu LEFT JOIN ' . $wp_prefix . 'usermeta AS wmf ON wu.id=wmf.user_id AND wmf.meta_key="first_name" LEFT JOIN ' . $wp_prefix . 'usermeta AS wml ON wu.id=wml.user_id AND wml.meta_key="last_name" LEFT JOIN ' . $wp_prefix . 'usermeta AS wum ON wu.id=wum.user_id AND wum.meta_key="' . $wp_prefix . 'capabilities"', OBJECT );
		} else {
			$all_users = $wpdb->get_results ( 'SELECT wu.id as user_id,wu.user_login as user_login,wu.user_email AS email,wmf.meta_value AS firstname, wml.meta_value AS lastname, wum.meta_value AS user_role FROM ' . $wp_prefix . 'users AS wu LEFT JOIN ' . $wp_prefix . 'usermeta AS wmf ON wu.id=wmf.user_id AND wmf.meta_key="first_name" LEFT JOIN ' . $wp_prefix . 'usermeta AS wml ON wu.id=wml.user_id AND wml.meta_key="last_name" LEFT JOIN ' . $wp_prefix . 'usermeta AS wum ON wu.id=wum.user_id AND wum.meta_key="' . $wp_prefix . 'capabilities" LEFT JOIN ' . $table_name . ' AS wsu ON wsu.user_id = wu.id AND wsu.action = "S" WHERE wu.user_registered>="' . $last_call_date . '" OR wsu.time >="' . $last_call_date . '"', OBJECT );
		}
		if ($all_users != null && sizeof ( $all_users ) > 0) {
			foreach ( $all_users as $one_user ) {
				$one_user->user_posts = count_user_posts ( $one_user->user_id );
			}
		}
		return $all_users;
	}
	public function sarbacanedesktop_get_all_deleted_users($last_call_date) {
		global $wpdb;
		$wp_prefix = $wpdb->prefix;
		$table_name = $wpdb->prefix . 'sd_updates';
		$deleted_users = $wpdb->get_results ( 'SELECT user_email FROM ' . $table_name . ' AS wsu WHERE wsu.action = "U" AND wsu.time >="' . $last_call_date . '"', OBJECT );
		return $deleted_users;
	}
	/**
	 * Cette méthode retourne l'ensemble des utilisateurs inscrits à la newsletter
	 *
	 * @return array
	 */
	public function get_all_subscribers() {
		$subscribers = get_option ( 'sarbacane_newsletter_list', array () );
		$all_subscribers = array ();
		if (sizeof ( $subscribers ) > 0) {
			foreach ( $subscribers as $one_subscriber ) {
				$object_properties = get_object_vars ( $one_subscriber );
				$subscriber_lowered = new stdClass ();
				foreach ( $object_properties as $property => $value ) {
					$label = strtolower ( $property );
					$subscriber_lowered->$label = $value;
				}
				array_push ( $all_subscribers, $subscriber_lowered );
			}
		}
		return $all_subscribers;
	}
	public function sarbacane_delete_sdid($sd_id) {
		delete_option ( 'sarbacane_news_list_reset_' . $sd_id );
		delete_option ( 'sarbacane_user_list_reset_' . $sd_id );
		delete_option ( 'sarbacane_C_call_' . $sd_id );
		delete_option ( 'sarbacane_N_call_' . $sd_id );
		
		$sdid_array = get_option ( 'sarbacane_sd_id_list' );
		$index = array_search ( $sd_id, $sdid_array );
		if ($index !== false) {
			unset ( $sdid_array [$index] );
		}
	}
	/**
	 * Called on user update.
	 * Stores into sd_updates the user_id, this moment time and the action, U here
	 *
	 * @param unknown $user_id        	
	 */
	function trigger_user_update($user_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sd_updates';
		
		$sql = "INSERT INTO $table_name (id,time,user_id,action) VALUES (NULL,'" . gmdate ( 'Y-m-d H:i:s' ) . "',$user_id,'S')";
		$wpdb->query ( $sql );
	}
	
	/**
	 * Called on user delete.
	 * Stores into sd_updates the user_id, this moment time and the action, S here
	 *
	 * @param unknown $user_id        	
	 */
	function trigger_user_delete($user_id) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sd_updates';
		$user_obj = get_userdata ( $user_id );
		$sql = "INSERT INTO $table_name (id,time,user_email,action) VALUES (NULL,'" . gmdate ( 'Y-m-d H:i:s' ) . "','$user_obj->user_email','U')";
		$wpdb->query ( $sql );
	}
	function clear_update_history() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'sd_updates';
		$option_table = $wpdb->prefix . 'options';
		$sql = "DELETE FROM $table_name WHERE time <= (SELECT MIN(option_value) FROM $option_table WHERE option_name LIKE 'sarbacane_%_call_%')";
		$wpdb->query ( $sql );
	}
	function sarbacane_query_vars($vars) {
		$vars = array_merge($vars, Array (
				'my-plugin',
				'sdid',
				'sd_token',
				'list',
				'action',
				'type',
				'id',
				'limit' ,
				'sarbacane_form_token'
		));
		return $vars;
	}
	function sarbacane_process_request($wp) {
		if (! array_key_exists ( 'my-plugin', $wp->query_vars ) || $wp->query_vars ['my-plugin'] != 'sarbacane') {
			return;
		}
		if (isset ( $_POST ['sarbacane_form_token'] ) && "" != $_POST ['sarbacane_form_token'] && wp_verify_nonce($_POST['sarbacane_form_token'],'newsletter_registration')) {
			$sarbacane_desktop_form_token = sanitize_text_field ( $_POST ['sarbacane_form_token'] );
		}
		if (isset ( $wp->query_vars ['sdid'] ) && "" != $wp->query_vars ['sdid']) {
			$sd_id = sanitize_text_field ( $wp->query_vars ['sdid'] );
		}
		if (isset ( $wp->query_vars ['sd_token'] ) && "" != $wp->query_vars ['sd_token']) {
			$sd_token = sanitize_text_field ( $wp->query_vars ['sd_token'] );
		}
		if (isset ( $wp->query_vars ['list'] ) && "" != $wp->query_vars ['list']) {
			$sd_list_id = sanitize_text_field ( $wp->query_vars ['list'] );
		}
		if (isset ( $wp->query_vars ['action'] ) && "" != $wp->query_vars ['action']) {
			$action = sanitize_text_field ( $wp->query_vars ['action'] );
		}
		if (isset ( $wp->query_vars ['type'] ) && "" != $wp->query_vars ['type']) {
			$type = sanitize_text_field ( $wp->query_vars ['type'] );
		}
		if (isset ( $wp->query_vars ['id'] ) && "" != $wp->query_vars ['id']) {
			$id = sanitize_text_field ( $wp->query_vars ['id'] );
		}
		if (isset ( $wp->query_vars ['limit'] ) && "" != $wp->query_vars ['limit']) {
			$limit = $wp->query_vars ['limit'];
		}
		if(isset($sarbacane_desktop_form_token)){
			header('Content-Type: text/html; charset=utf-8');
			do_action("sarbacane-savewidget");
			exit;
		}
		if (! isset ( $sd_id )) {
			header ( "HTTP/1.1 400 Bad request" );
			header ( "Content-type: application/json; charset=utf-8" );
			die ( 'FAILED_SDID' );
		}
		if (! isset ( $sd_token )) {
			header ( "HTTP/1.1 400 Bad request" );
			header ( "Content-type: application/json; charset=utf-8" );
			die ( 'FAILED_SDTOKEN' );
		}
		$sd_token_enregistre = get_option ( 'sarbacane_sd_token' );
		if ($sd_token != $sd_token_enregistre) {
			header ( "HTTP/1.1 403 Unauthorized" );
			header ( "Content-type: application/json; charset=utf-8" );
			die ( 'FAILED_SDTOKEN' );
		} else {
			// Content retrieving
			if (isset ( $type )) {
				if ("posts" == $type) {
					header ( "Content-Type: application/rss+xml ; charset=utf-8" );
					// One article
					if (isset ( $id )) {
						do_action ( 'sarbacane_article', $id );
					} else {
						// All articles
						do_action ( 'sarbacane_allarticles', $limit );
					}
				} else if ("settings" == $type) {
					header ( "Content-Type: application/json ; charset=utf-8" );
					header ( "Content-Transfer-Encoding: binary" );
					do_action ( 'sarbacane_settings' );
				} else if ("medias" == $type) {
					header ( "Content-Type: application/json ; charset=utf-8" );
					do_action ( 'sarbacane_medias' );
				}
			} else {
				// List retrieving
				header ( "Content-Type: text/plain ; charset=utf-8" );
				header ( "Content-Transfer-Encoding: binary" );
				if ("delete" == $action) {
					do_action ( 'sarbacane-deletesdid', $sd_id );
				} else {
					do_action ( 'sarbacane-getlist', $sd_id, $sd_token, $sd_list_id );
				}
			}
		}
		exit;
	}
}

