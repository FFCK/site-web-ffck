<?php
class SarbacaneListsSync{

	public static function afficher_le_parametrage(){
		if(isset($_POST['sarbacane_config']) && '1' == $_POST['sarbacane_config']){
			$sd_idEnregistres = get_option ( 'sarbacane_sd_id_list', array () );
			foreach ($sd_idEnregistres  as $sd_idEnregistre){
				update_option ( 'sarbacane_news_list_reset_' .$sd_idEnregistre, true );
			}

			if(isset($_POST['sarbacane_users_list']) && "true" == $_POST['sarbacane_users_list']){
				update_option('sarbacane_users_list',true);
			}else{
				update_option('sarbacane_users_list',false);
			}
			
			if(isset($_POST['sarbacane_news_list']) && "true" == $_POST['sarbacane_news_list']){
				update_option('sarbacane_news_list',true);
				$fields = get_option ( 'sarbacane_news_fields' );
				if($fields == null || sizeof($fields) <= 0){
					$default_email = new stdClass ();
					$email_field = __('email', 'sarbacane-desktop' );
					$default_email->label = $email_field;
					$default_email->mandatory = true;
					update_option ( 'sarbacane_news_fields', array ($default_email ) );
				}
			}else{
				update_option('sarbacane_news_list',false);
			}
			
			
			if(isset($_POST['sarbacane_theme_sync']) && "true" == $_POST['sarbacane_theme_sync']){
				update_option('sarbacane_theme_sync',true);
			}else{
				update_option('sarbacane_theme_sync',false);
			}
			
			if(isset($_POST['sarbacane_blog_content']) && "true" == $_POST['sarbacane_blog_content']){
				update_option('sarbacane_blog_content',true);
			}else{
				update_option('sarbacane_blog_content',false);
			}
			
			if(isset($_POST['sarbacane_media_content']) && "true" == $_POST['sarbacane_media_content']){
				update_option('sarbacane_media_content',true);
			}else{
				update_option('sarbacane_media_content',false);
			}
			
			if(isset($_POST['sarbacane_rss_data']) && "true" == $_POST['sarbacane_rss_data']){
				update_option('sarbacane_rss_data',true);
			}else{
				update_option('sarbacane_rss_data',false);
			}
		}
		require_once ("views/sarbacane-lists-sync.php");
	}
}