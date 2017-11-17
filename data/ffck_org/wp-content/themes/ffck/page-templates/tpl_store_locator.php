<?php
/**
 * Template Name: Store Locator
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header();
/*echo "<pre>";
print_r($_POST['toc_postcode']);
echo "</pre>";*/

$_POST['nearbylocation'];
?>
<!-- main slider start -->
<div class="storelocator_banner_block" style="height:570px;">
    <div id="store_map" style="width:100%; height:570px;"></div>
    <div class="container"> 
    	<form method="post" action="">
            <div class="map_block">
                <h1>Zoeken op kaart</h1>
                <input type="text" class="postcode" placeholder="Postcode" name="toc_postcode" value="<?php echo $_POST['toc_postcode']?>">
                <div class="range_main">	
                    <div class="strall_text">Straal</div> 
                    <div class="slider-range-max"></div>
                    <div class="range_sliders">
                        <label for="amount"></label>
                        <input type="text" name="nearbylocation" class="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
                        <span>km</span>
                    </div>
                </div>
                <?php $store_categories = get_terms("store-categories");
                if ( !empty( $store_categories ) && !is_wp_error( $store_categories ) )
                {?>
                <ul>
                    <?php
                    foreach ( $store_categories as $store_category ) 
                    {
                    $cat_url = get_option( "toc_cat_images-".$store_category->term_id."" );	 
                    ?>
                    <li>
                        <div class="icon">
                            <img src="<?php echo aq_resize($cat_url,35,47,true); ?>" alt="<?php echo $store_category->name; ?>">
                        </div>
                        <div class="check-box">
                        <?php 
						if(is_array($_POST['toc_categorie']))
						{			
							$checked='';			
							if(in_array($store_category->slug,$_POST['toc_categorie']))
								$checked='checked="checked"';						
						}
						else
						{
							$checked =($_POST['toc_categorie']==$store_category->slug)?'checked="checked"':""; 
						}
						
						
						?>
                             <input <?php echo $checked ?> class="styled" type="checkbox" name="toc_categorie[]" value="<?php echo $store_category->slug?>" >
                             <span><?php echo $store_category->name; ?></span>
                        </div>
                    </li>
                                                                                                    
                    <?php }?>
                </ul>
                <?php }?>
                <input type="submit" value="Zoek">
            </div>
        </form>
	</div>
</div>
<!-- main slider end -->
<!-- contain warp start -->
<div id="contain_warp"  >
	<div class="container">
		<div class="row">
			<div id="storelocator_page_block">
                <div class="col-md-10 col-sm-10 left_news">
                    <div class="shorting_box">
                        <h1>Sorteren op</h1>
						<select name="sort" id="shortby" onchange="getval(this);" class="selectpicker select-1 ">
							<option value="alfabet">Alfabet</option>
							<option value="afstand">Afstand</option>
							<option value="beoordeling/review">Beoordeling/review</option>
							<option value="categorie">Categorie</option>
						</select>
                    </div>
					<?php
 
 /*$re_post_ids = $wpdb->get_results("SELECT a.post_id, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1) as a_latitude, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1) as a_longitude, ((ACOS(SIN(52.3559
* PI() / 180) * SIN( (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1) * PI() / 180) + COS(52.3559
* PI() / 180) * COS( (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1) * PI() / 180) * COS((4.89909 - (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1)) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance FROM `wp_postmeta` as a where a.meta_key='martygeocoderlatlng' having distance <= 200" );
		print_r($re_post_ids);
   */
   
   
   
   
		$_SERVER['REMOTE_ADDR'];
		$ip = json_decode(get_location($_SERVER['REMOTE_ADDR']),true);
		$latitude= $ip['latitude'].'<br>';
		$longitude= $ip['longitude'];
		$country=$list['country'];
		
		
	
	$city =$list['city'];

	global $wpdb;

	
$resulr =  $wpdb->get_results("SELECT a.post_id, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1) as a_latitude, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1) as a_longitude, ((ACOS(SIN('".$latitude."' * PI() / 180) * SIN(
(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)  * PI() / 180) + COS('".$latitude."' * PI() / 180) * COS(

(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)

* PI() / 180) * COS(('".$longitude."' - (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1)) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance  FROM `wp_postmeta` as a where a.meta_key='martygeocoderlatlng' having distance <= 200");
									
			//echo get_the_title(312);


 
				$address = '178.62.128.67';
				$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address="'.$address.'"&sensor=true');
				$coordinates = json_decode($coordinates);
			 
				$coordinates->results[0]->geometry->location->lat;
				$coordinates->results[0]->geometry->location->lng;
			 
				$lat = $coordinates->results[0]->geometry->location->lat;
				$lng = $coordinates->results[0]->geometry->location->lng;
 
		

					
					function title_filter( $where = '' )
					{
					 	// posts  30 to 60 days old
						$where .= " AND post_date >= '" . date('Y-m-d', strtotime('-13 days')) . "'" . " AND post_date <= '" . date('Y-m-d', strtotime('-1 days')) . "'";
						return $where;
					}
					$args =  array('post_type' => 'stores', 'posts_per_page' => -1);
						
					if( !empty($_POST['toc_postcode']))
					{
						
						$args['meta_query'] = 
							array( array( 'key'=>'martygeocoderaddress', 
							'value'=> $_POST['toc_postcode'], 'compare' => 'LIKE'), );
					}
						
						
					if( !empty($_POST['toc_categorie']) )
					{
						$args['tax_query'][] = 
							array(
								'taxonomy'=>'store-categories', 
								'field'=>'slug', 
								'terms'=>$_POST['toc_categorie']
								);		
					}
					if( !empty($_POST['nearbylocation']) && empty($_POST['toc_postcode']) )
					{	
				
						$address = $_SERVER['REMOTE_ADDR'];
						$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address="'.$address.'"&sensor=true');
						//echo 'http://maps.googleapis.com/maps/api/geocode/json?address="'.$address.'"&sensor=true';
						$coordinates = json_decode($coordinates);
					 
						$coordinates->results[0]->geometry->location->lat;
						$coordinates->results[0]->geometry->location->lng;
					 
						$latitude = $coordinates->results[0]->geometry->location->lat;
						$longitude = $coordinates->results[0]->geometry->location->lng;
						
						
						
						$result_near =  $wpdb->get_results("SELECT a.post_id, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1) as a_latitude, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1) as a_longitude, ((ACOS(SIN('".$latitude."' * PI() / 180) * SIN(
						(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)  * PI() / 180) + COS('".$latitude."' * PI() / 180) * COS(

						(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)

						* PI() / 180) * COS(('".$longitude."' - (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1)) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance  FROM `wp_postmeta` as a where a.meta_key='martygeocoderaddress' having distance <= '".$_POST['nearbylocation']."'");



						foreach($result_near as $res)
						{
							$array_id[]=$res->post_id;							
						}
						//print_r($array_id);
						$args =  array('post_type' => 'stores', 'post__in' => $array_id);
						//print_r($args);
						if( !empty($_POST['toc_postcode']))
						{
							$args['meta_query'] = 
							array( array( 'key'=>'martygeocoderaddress', 
							'value'=> $_POST['toc_postcode'], 'compare' => 'LIKE'), );
						}	
										
						if( !empty($_POST['toc_categorie']) )
						{
							$args['tax_query'][] = 
								array(
									'taxonomy'=>'store-categories', 
									'field'=>'slug', 
									'terms'=>$_POST['toc_categorie']
									);		
						}	
					}
					
					
					
					if( $_POST['nearbylocation']!='' && $_POST['toc_postcode']!='' )
					{	
				
										
						$address = $_POST['toc_postcode'];
						$coordinates = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address="'.$address.'"&sensor=true');
						//echo 'http://maps.googleapis.com/maps/api/geocode/json?address="'.$address.'"&sensor=true';
						$coordinates = json_decode($coordinates);
					 
						$coordinates->results[0]->geometry->location->lat;
						$coordinates->results[0]->geometry->location->lng;
					 
						$latitude = $coordinates->results[0]->geometry->location->lat;
						$longitude = $coordinates->results[0]->geometry->location->lng;
					
						
						
					
						$result_near =  $wpdb->get_results("SELECT a.post_id, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1) as a_latitude, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1) as a_longitude, ((ACOS(SIN('".$latitude."' * PI() / 180) * SIN(
						(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)  * PI() / 180) + COS(".$latitude." * PI() / 180) * COS(
						(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)
						* PI() / 180) * COS((".$longitude." - (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1)) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance  FROM `wp_postmeta` as a where a.meta_key='martygeocoderlatlng' having distance <= ".$_POST['nearbylocation']."  order by distance asc");
 
						
/*						echo "SELECT a.post_id, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1) as a_latitude, (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1) as a_longitude, ((ACOS(SIN('".$latitude."' * PI() / 180) * SIN(
						(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)  * PI() / 180) + COS(".$latitude." * PI() / 180) * COS(
						(SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 1), ' ', -1) * 1)
						* PI() / 180) * COS((".$longitude." - (SUBSTRING_INDEX(SUBSTRING_INDEX(TRIM(TRAILING ')' FROM TRIM(LEADING '(' FROM a.meta_value)), ' ', 2), ' ', -1) * 1)) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance  FROM `wp_postmeta` as a where a.meta_key='martygeocoderlatlng' having distance <= ".$_POST['nearbylocation']."";
						*/
						//print_r($result_near);
						foreach($result_near as $res)
						{
							$array_id2[]=$res->post_id;
						//	echo $res->post_id.'<br>';
							
						}
						//print_r($array_id2);
						
						$args =  array('post_type' => 'stores', 'post__in' => $array_id2, 'posts_per_page' => -1);
						//print_r($args);
						
						/*if( !empty($_POST['toc_postcode']))
						{
							$args['meta_query'] = 
							array( array( 'key'=>'martygeocoderaddress', 
							'value'=> $_POST['toc_postcode'], 'compare' => 'LIKE'), );
						}*/	
										
						if( !empty($_POST['toc_categorie']) )
						{
							$args['tax_query'][] = 
								array(
									'taxonomy'=>'store-categories', 
									'field'=>'slug', 
									'terms'=>$_POST['toc_categorie']
									);		
						}	
					}
					
					if(count($array_id2)!=0){
					//$args =  array('post_type' => 'stores', 'post__in' => $array_id2);
					}else{
					$args['orderby'] = 'FIELD(ID,'.implode(",",$array_id2).')';
					$args['order'] = 'ASC';
					}
					
		
					
					
				    // The Query
                   // add_filter( 'posts_where', 'title_filter', 10, 2 );
					$the_query = new WP_Query( $args );		
		//			global $wpdb;
			//	echo "<pre>";
				//print_r( $wpdb->queries );
		//		echo "</pre>";		
								//remove_filter( 'posts_where', 'title_filter', 10, 2 );  
					// The Loop
					//	echo $GLOBALS['wp_query']->request;
					
                    if ( $the_query->have_posts() ) 
                    {
                    	$total_stores = $the_query->post_count;
					?>
                 	<div class="bx_slider_div load_store">
                    	<ol class="bxslider">
                        <?php
                        $store_counter = 1;
						while ( $the_query->have_posts() ) 
                        {
                            $the_query->the_post();
							echo ($store_counter%5==1) ?"<li>":"";
							$has_data[] =get_the_ID();
							$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
							$address = get_post_meta(get_the_ID(),'wpcf-store-address',true);
							
							//$toc_lat = get_post_meta(get_the_ID(),'wpcf-store-latitude',true);
							//$toc_log = get_post_meta(get_the_ID(),'wpcf-store-longitude',true);
							$toc_lat = get_geocode_lat( get_the_ID()); 
							$toc_log = get_geocode_lng(get_the_ID()); 
							if($toc_lat!='')
							{
								$toc_lat = get_geocode_lat( get_the_ID() ); 
								
								//$toc_lat = get_post_meta(get_the_ID(),'wpcf-store-latitude',true);
							}
							else
							{
								$toc_lat = "52.370216";
							}
							if($toc_log!='')
							{
								//$toc_log = get_post_meta(get_the_ID(),'wpcf-store-longitude',true);
								$toc_log = get_geocode_lng( get_the_ID() ); 
							} 
							else
							{
								$toc_log = "4.895168";
							}
							?>
                            <div class="storelocator_box">
                                <img src="<?php echo aq_resize($feat_image,768,370,true,true,true); ?>" class="image"  alt="<?php echo get_the_title();?>"> 
                                <?php
                                $terms = get_the_terms($post->ID, 'store-categories');
                                $all_cat="";
                                foreach($terms as $term)
                                {
                                    $all_cat .= $term->name." ";	
                                    $cat_url_big = get_option( "toc_cat_images-".$term->term_id."" );	
                                }
                                ?>
                                <h1><?php echo $all_cat; ?></h1>
                                <div class="left_col">
                                    <div class="center_image">
                                        <img src="<?php echo aq_resize($cat_url_big,102,130,true,true,true); ?>"  alt="">
                                    </div>
                                    <div class="star_block_2">
                                        <div class="reating_in"><?php echo count_reviews_number(get_the_ID())?></div>
                                        <div class="text_in"><?php echo count_reviews_store(get_the_ID())?></div>
                                    </div>
                                </div>
                                <div class="address_block">
                                    <div class="details_box">
                                        <h2><?php the_title();?></h2>
                                        <p><?php echo $address; ?></p>
										<span><?php echo get_post_meta(get_the_id(),'wpcf-opening-time',true) ?></span>
                                    </div>
                                    <div class="arrow">
                                        <a href="<?php echo get_the_permalink();?>">
                                            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/arrow.png"  alt="">
                                        </a>z`
                                    </div>
                                </div>
                           	</div>
                           	
							<?php
							$markers.= '
							latlng2 = new google.maps.LatLng('.$toc_lat.', '.$toc_log.');
							marker2 = new google.maps.Marker(
							{
								position: latlng2,
								map: map,
								draggable: false, 
								icon: "'.aq_resize($cat_url_big,'36','47', true, true, true).'",
								animation: google.maps.Animation.DROP
							});
							
							var infowindow =  new google.maps.InfoWindow(
							{
								content: "",
							});
							markers.push(marker2);
							google.maps.event.addListener(marker2, "mouseover", (function(marker2) 
							{
								return function() 
								{
									infowindow.setContent("'.get_the_title().'");
									infowindow.open(map, marker2);		
								}
							})
							(marker2));
							 google.maps.event.addListener(marker2, "click", function() {
								window.location = "'.get_the_permalink().'";
							});';
							$arrLatLong[] = array($toc_lat, $toc_log);
							$bounds.= 'bounds.extend('.$toc_lat.', '.$toc_log.');';
							
							echo ($store_counter%5==0 || $total_stores == $store_counter)?"</li>":"";
								//echo ($store_counter%5==0) ?"</li>":"";
						
                        $store_counter++;
						}
                        ?>
                        </li>
                        </ol>
                   	</div>
                    <?php
                    }
					else
					{
						?>
						<p>There is no any store in you cateriya, try another</p>
                    	<?php   
					} 
                    wp_reset_postdata();
                    ?>      
                    <div class="clearfix"></div>
                    <?php echo do_shortcode('[social_media_share]');?>                
                </div>
                <div class="col-md-2 col-sm-2 right_news">
                	<div class="full_add_hegit2">
                    <img src="<?php echo get_post_meta(get_the_ID(),'wpcf-horizontal-advertise-image',true);?>"  alt="horizontal"/>
					<span>(Advertentie)</span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-12">
                	<?php echo do_shortcode('[vertical_advertise_image]');?>
               	</div>
        	</div>   
		</div>
	</div>
</div>

<?php print_r($_GET['toc_categorie']); ?>
<!-- contain warp end -->
 
<!---code for google map--->
<!-- map -->
<script src="https://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclusterer/src/markerclusterer.js"></script>
<script type="text/javascript">
	var lan = 52.370216;
	var lat = 4.895168;
	var zoomdata = 8;
	var markers = [];

	google.maps.event.addDomListener(window, 'load', function (){init(lan, lat, false);});
	<?php
	$markers = str_replace("\r","",$markers);
	$markers = str_replace("\n","",$markers);
	?>
	
	var map_details= '<?php echo $markers; ?>';
	function init(lan, lat) 
	{	
		var	zoomlevel = 12;
		var mapOptions = 
		{				
			scrollwheel: false,
			zoom: zoomlevel,
			center: new google.maps.LatLng(lan, lat),
			//styles: 
		};
		var mapElement = document.getElementById('store_map');
		var map = new google.maps.Map(mapElement, mapOptions);
		var bounds = new google.maps.LatLngBounds();
		eval(map_details);	
		<?php
		if(count($has_data)>0)
		{
		?>
		var markerCluster = new MarkerClusterer(map, markers);
		<?php
		for($xi=0; $xi<sizeof($arrLatLong); $xi++)
		{
		?>
		bounds.extend(new google.maps.LatLng(<?php echo $arrLatLong[$xi][0].', '.$arrLatLong[$xi][1]; ?>));
		<?php 
		}
		?>
		/*google.maps.event.addListener(map, 'zoom_changed', function() {
			zoomChangeBoundsListener = 
				google.maps.event.addListener(map, 'bounds_changed', function(event) {
					if (this.getZoom() > 2 && this.initialZoom == true) {
						// Change max/min zoom here
						this.setZoom(2);
						this.initialZoom = false;
					}
				google.maps.event.removeListener(zoomChangeBoundsListener);
			});
		});
		map.initialZoom = true;*/
		map.fitBounds(bounds);
		<?php
		}
		?>	
		
	}
	
	
	
	
	
	
	
	
	
    //load more post 
    jQuery(function()
    {
      
	   jQuery('#shortby').change(function() {		   
        //alert($(this).val());
			// add loader
		$vval=$(this).val();
//		alert($vval);
		var zipcode="<?php echo $_POST['toc_postcode'] ?>";
		var toc_categorie="<?php implode(',',$_POST['toc_categorie'])  ?>";
		var nearbylocation="<?php echo $_POST['nearbylocation'] ?>";
            jQuery.post("<?php echo get_template_directory_uri(); ?>/store_locator_short.php/?shortby="+$vval+"&zipcode="+zipcode+"&toc_categorie="+toc_categorie+"&nearbylocation="+nearbylocation,
			function(data) 
            {
		//		alert(data);
                jQuery(".load_store").html(data);
				jQuery('.bxslider').bxSlider();

            }); 
            return false;
        });
    });

</script>
<script type="text/javascript">
jQuery(function() {
jQuery('#shortby').change(function() {
//alert($(this).val())
})
})
</script>


<?php get_footer(); ?>