<?php
class SarbacaneWidget{
	public function sarbacane_save_widget(){
		$list_type = sanitize_text_field($_POST['list_type']);
		$instance;
		if("C" == $list_type){
			$instance = new SarbacaneUsersWidget();
			$instance->sarbacane_save_widget();	
		}else if("N" == $list_type){
			$instance = new SarbacaneNewsWidget();
			$instance->sarbacane_save_widget();	
		}
	}
}