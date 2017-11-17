<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) & !(IE 8)]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	
	<!-- Bootstrap -->
<link href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/fonts/fonts.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/fonts/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/animate.min.css" rel="stylesheet">
<!-- owl Start -->
<link href="<?php echo get_template_directory_uri(); ?>/css/owl.carousel.css" rel="stylesheet">
<!-- owl Start -->

<!-- flex Start -->
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/flexslider.css" type="text/css" media="screen" />
<!-- flex Start -->

<link href="<?php echo get_template_directory_uri(); ?>/css/developer.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/style.css" rel="stylesheet">
<link href="<?php echo get_template_directory_uri(); ?>/css/responsive.css" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!--Windows Phone Js Code Start-->
<script type="text/javascript">
    // Copyright 2014-2015 Twitter, Inc.
    // Licensed under MIT (https://github.com/twbs/bootstrap/blob/master/LICENSE)
    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
      var msViewportStyle = document.createElement('style')
      msViewportStyle.appendChild(
        document.createTextNode(
          '@-ms-viewport{width:auto!important}'
        )
      )
      document.querySelector('head').appendChild(msViewportStyle)
    }
</script>
<!--End Windows Phone Js Code Start-->
	
	
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="main_wapper">

    <!--Main Header-->
    <header id="header"  >
    	<div class="header_wapper">
        	<div class="container">
            	<!-- logo -->
                	<div class="logo">
                    	<a href="<?php echo home_url(); ?>"><img src="<?php echo ot_get_option('logo'); ?>"   alt=""></a>
                    </div>
                <!-- logo -->
                <!--header right -->
                	<div class="header_right">
                    	<div class="header_top">
                        	<div class="top_nav">
                            	
									<ul>
                                	<li>
                                    	<a href="#">
                                        	<i><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/top_nav_icon_1.png"></i>
                                            <span>Espace licencié</span>
                                        </a> 
                                    </li>
                                    <li>
                                    	<a href="#">
                                        	<i><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/top_nav_icon_2.png"></i>
                                            <span>Espace club</span>
                                        </a> 
                                    </li>
                                    <li>
                                    	<a href="#">
                                        	<i><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/top_nav_icon_3.png"></i>
                                            <span>Espace presse</span>
                                        </a> 
                                    </li>
                                    <li>
                                    	<a href="#">
                                        	<i><img alt="" src="<?php echo get_template_directory_uri(); ?>/images/top_nav_icon_4.png"></i>
                                            <span>contact</span>
                                        </a> 
                                    </li>
                                </ul>
								
                                	
                               
                            </div>
                            	<?php 
									$fb=ot_get_option('facebook_link');
									$tw=ot_get_option('twitter_link');
									$in=ot_get_option('instagram_link');
									$pl=ot_get_option('social_play');
									if($fb!='')
									{
											$fb_link=ot_get_option('facebook_link');
									}
									if($tw!='')
									{
											$tw_link=ot_get_option('twitter_link');
									}
									if($fb!='')
									{
											$in_link=ot_get_option('instagram_link');
									}
									if($fb!='')
									{
											$pl_link=ot_get_option('social_play');
									}
								 ?>
                            <div class="h_social">
                            	<a href="<?php echo $fb_link; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png"  alt=""></a>
                                <a href="<?php echo $tw_link; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/twitter.png"  alt=""></a>
                                <a href="<?php echo $in_link; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/instagram.png"  alt=""></a>
                                <a href="<?php echo $pl_link; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/youtube.png"  alt=""></a>
                            </div>
                      </div>
                      
                      <div class="navigaction_block">
                      	<div class="navi">
                        	
                        	<!--ul>
                            	<li><a href="#"><span><i class="fa fa-chevron-down"></i></span>Sports olympiques </a></li>
                                <li><a href="#"><span><i class="fa fa-chevron-down"></i></span> Sports de compétitions</a></li>
                                <li><a href="#"><span><i class="fa fa-chevron-down"></i></span>Randonnée nautique</a></li>
                                <li><a href="#"><span><i class="fa fa-chevron-down"></i></span>ffck</a></li>
                            </ul-->
                        </div>
                      	<div class="search_block" >
                      		<a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/search_icon.png"   alt=""></a>
                      	</div>	
                      </div>
                     
                    </div>
                <!--header right -->
                <!-- mobile nav -->
                	<div class="mobile_nav_block">
                    	<div class="nav_icon"><a href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/nav_icon.png"   alt=""></a></div>
                    </div>
                <!-- mobile nav -->
                
            </div>
            
        </div>
        <div class="container"><?php uberMenu_easyIntegrate(); ?></div>
         <!-- search_block_hidden -->
            <div style="display:none;" id="search_form" class="search_block_hidden">
            	 <form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input type="submit" id="searchsubmit" value=" " />
					<input placeholder="votre recherche" type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" />
		
			</form>
               
         	
            </div>
         <!-- search_block_hidden -->
          
    </header>     
    <!--End Main Header-->

