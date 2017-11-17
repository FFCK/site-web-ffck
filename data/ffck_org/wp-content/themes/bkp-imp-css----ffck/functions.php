<?php
/**
 * Twenty Fourteen functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link https://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see twentyfourteen_content_width()
 *
 * @since Twenty Fourteen 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

/**
 * Twenty Fourteen only works in WordPress 3.6 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '3.6', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentyfourteen_setup' ) ) :
/**
 * Twenty Fourteen setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_setup() {

	/*
	 * Make Twenty Fourteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Fourteen, use a find and
	 * replace to change 'twentyfourteen' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'twentyfourteen', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css', twentyfourteen_font_url(), 'genericons/genericons.css' ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'twentyfourteen-full-width', 1038, 576, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'twentyfourteen' ),
		'secondary' => __( 'Secondary menu in left sidebar', 'twentyfourteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'twentyfourteen_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'twentyfourteen_get_featured_posts',
		'max_posts' => 6,
	) );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
endif; // twentyfourteen_setup
add_action( 'after_setup_theme', 'twentyfourteen_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'twentyfourteen_content_width' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return array An array of WP_Post objects.
 */
function twentyfourteen_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Twenty Fourteen.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'twentyfourteen_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return bool Whether there are featured posts.
 */
function twentyfourteen_has_featured_posts() {
	return ! is_paged() && (bool) twentyfourteen_get_featured_posts();
}

/**
 * Register three Twenty Fourteen widget areas.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_widgets_init() {
	require get_template_directory() . '/inc/widgets.php';
	register_widget( 'Twenty_Fourteen_Ephemera_Widget' );

	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Main sidebar that appears on the left.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'twentyfourteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Additional sidebar that appears on the right.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'twentyfourteen' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	
	
		register_sidebar( array(
		'name'          => __( 'First Content Block', 'twentyfourteen' ),
		'id'            => 'first-block',
		'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '',
		'after_title'   => '',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Newslatter Block', 'twentyfourteen' ),
		'id'            => 'footer_newslatter_block',
		'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Newslatter Block', 'twentyfourteen' ),
		'id'            => 'footer_newslatter_block',
		'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );
	
	
	
}
add_action( 'widgets_init', 'twentyfourteen_widgets_init' );

/**
 * Register Lato Google font for Twenty Fourteen.
 *
 * @since Twenty Fourteen 1.0
 *
 * @return string
 */
function twentyfourteen_font_url() {
	$font_url = '';
	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Lato, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Lato font: on or off', 'twentyfourteen' ) ) {
		$query_args = array(
			'family' => urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$font_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_scripts() {
	// Add Lato font, used in the main stylesheet.
	wp_enqueue_style( 'twentyfourteen-lato', twentyfourteen_font_url(), array(), null );

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.3' );

	// Load our main stylesheet.
	wp_enqueue_style( 'twentyfourteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentyfourteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentyfourteen-style' ), '20131205' );
	wp_style_add_data( 'twentyfourteen-ie', 'conditional', 'lt IE 9' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentyfourteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		wp_enqueue_script( 'twentyfourteen-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
		wp_localize_script( 'twentyfourteen-slider', 'featuredSliderDefaults', array(
			'prevText' => __( 'Previous', 'twentyfourteen' ),
			'nextText' => __( 'Next', 'twentyfourteen' )
		) );
	}

	wp_enqueue_script( 'twentyfourteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150315', true );
}
add_action( 'wp_enqueue_scripts', 'twentyfourteen_scripts' );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_admin_fonts() {
	wp_enqueue_style( 'twentyfourteen-lato', twentyfourteen_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'twentyfourteen_admin_fonts' );

if ( ! function_exists( 'twentyfourteen_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Twenty Fourteen attachment size.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'twentyfourteen_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( reset( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

if ( ! function_exists( 'twentyfourteen_list_authors' ) ) :
/**
 * Print a list of all site contributors who published at least one post.
 *
 * @since Twenty Fourteen 1.0
 */
function twentyfourteen_list_authors() {
	$contributor_ids = get_users( array(
		'fields'  => 'ID',
		'orderby' => 'post_count',
		'order'   => 'DESC',
		'who'     => 'authors',
	) );

	foreach ( $contributor_ids as $contributor_id ) :
		$post_count = count_user_posts( $contributor_id );

		// Move on if user has not published a post (yet).
		if ( ! $post_count ) {
			continue;
		}
	?>

	<div class="contributor">
		<div class="contributor-info">
			<div class="contributor-avatar"><?php echo get_avatar( $contributor_id, 132 ); ?></div>
			<div class="contributor-summary">
				<h2 class="contributor-name"><?php echo get_the_author_meta( 'display_name', $contributor_id ); ?></h2>
				<p class="contributor-bio">
					<?php echo get_the_author_meta( 'description', $contributor_id ); ?>
				</p>
				<a class="button contributor-posts-link" href="<?php echo esc_url( get_author_posts_url( $contributor_id ) ); ?>">
					<?php printf( _n( '%d Article', '%d Articles', $post_count, 'twentyfourteen' ), $post_count ); ?>
				</a>
			</div><!-- .contributor-summary -->
		</div><!-- .contributor-info -->
	</div><!-- .contributor -->

	<?php
	endforeach;
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image except in Multisite signup and activate pages.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function twentyfourteen_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( get_header_image() ) {
		$classes[] = 'header-image';
	} elseif ( ! in_array( $GLOBALS['pagenow'], array( 'wp-activate.php', 'wp-signup.php' ) ) ) {
		$classes[] = 'masthead-fixed';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( ( ! is_active_sidebar( 'sidebar-2' ) )
		|| is_page_template( 'page-templates/full-width.php' )
		|| is_page_template( 'page-templates/contributors.php' )
		|| is_attachment() ) {
		$classes[] = 'full-width';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() && 'slider' == get_theme_mod( 'featured_content_layout' ) ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	return $classes;
}
add_filter( 'body_class', 'twentyfourteen_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function twentyfourteen_post_classes( $classes ) {
	if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'twentyfourteen_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page  WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function twentyfourteen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentyfourteen' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'twentyfourteen_wp_title', 10, 2 );

// Implement Custom Header features.
require get_template_directory() . '/inc/custom-header.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Featured_Content' ) && 'plugins.php' !== $GLOBALS['pagenow'] ) {
	require get_template_directory() . '/inc/featured-content.php';
}







//*************************   check box for artist it display in event page   ***********************************************************//



// action to add meta boxes
add_action( 'add_meta_boxes', 'voodoo_dropdown_metabox2' );
// action on saving post
add_action( 'save_post', 'voodoo_dropdown_save2' );

// function that creates the new metabox that will show on post
function voodoo_dropdown_metabox2() {
    add_meta_box( 
        'voodoo_dropdown2',  // unique id
        __( 'Select Artist', 'mytheme_textdomain' ),  // metabox title
        'voodoo_dropdown_display2',  // callback to show the dropdown
        'page'   // post type
    );
}
// voodoo dropdown display
function voodoo_dropdown_display2( $post ) {

	
	wp_nonce_field( basename( __FILE__ ), 'voodoo_dropdown_nonce' );

	
	$dropdown_value = get_post_meta( get_the_ID(), 'voodoo_dropdown2', true );
	
	$args = array( 'post_type' => 'event', 'posts_per_page' => -1 );
						$loop = new WP_Query( $args );
						$the_query = new WP_Query( $args );
						
		while ( $loop->have_posts() ) : $loop->the_post();  
		$arrval=explode(',',$dropdown_value)
		?>
		
        <input type="checkbox" name="voodoo_dropdown2[]" value="<?php the_id(); ?>" <?php if(in_array(get_the_id(),$arrval)){ echo "checked='checked'"; } ?> ><b><?php the_title(); ?></b><br/>
  
  <?php endwhile;
} 

// dropdown saving
function voodoo_dropdown_save2( $post_id ) {

    // if doing autosave don't do nothing
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify nonce
  if ( !wp_verify_nonce( $_POST['voodoo_dropdown_nonce'], basename( __FILE__ ) ) )
      return;

  // save the new value of the dropdown
  //print_r($_POST['voodoo_dropdown2']);
  $new_value2 = implode(',',$_POST['voodoo_dropdown2']);
  update_post_meta( $post_id, 'voodoo_dropdown2', $new_value2 );

}




/*
add_shortcode( 'list-posts-basic', 'rmcc_post_listing_shortcode1' );
function rmcc_post_listing_shortcode1( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'big-access-slider',
        'posts_per_page' => -1,
        'order' => 'ASC',
    ) );
    if ( $query->have_posts() ) { ?>
        <ul class="clothes-listing">
            <?php while ( $query->have_posts() ) : $query->the_post(); ?>
            <li id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </li>
            <?php endwhile;
            wp_reset_postdata(); ?>
        </ul>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}
*/


// shortcode for big-access-slider display at bellow main slider
add_shortcode( 'big-access-slider', 'big_access_slider_shortcode' );
function big_access_slider_shortcode( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'big-access-slider',
        'posts_per_page' => -1,
    ) );
    if ( $query->have_posts() ) { ?>
       <!-- top_slider -->
        	<div class="container">
            	<div class="row">
                	<div class="col-lg-9 center-block float_none">
                    	<div class="acces_slider">
                        	<div class="owl-carousel">
								
            <?php while ( $query->have_posts() ) : $query->the_post(); 
            $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            ?>
            <!--item -->
			 <div class="item">
				<div class="acces_block">
					<div class="acces_block_image"><span><img src="<?php echo $image_url; ?>"  alt=""></span></div>
					<div class="acces_title"><?php echo get_the_title(); ?></div>
				</div>
			 </div>
               <!--item -->
            <?php endwhile;
            wp_reset_postdata(); wp_reset_query(); ?>
       </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}


//shortcode for display post

add_shortcode( 'display_news', 'display_news_shortcode' );
function display_news_shortcode( $atts ) {
    ob_start();
    $args = array( 'post_type' => 'post', 'posts_per_page' => 6 );
	$loop = new WP_Query( $args );
    if ( $loop->have_posts() ) { ?>
        
                	<!--item -->
                	<?php	
							
							$counter=1;		
							?>
				<div class="container">
            	<div class="actus_wapper">
            	<div class="big_title">
                	<h2><?php echo $atts['title']; ?></h2>
                    <div class="more_button">
                    	<a href="#">
                        	<span>
                            	<i class="fa fa-chevron-right"></i>
                               <?php echo $atts['subtitle']; ?>
                            </span>
                        </a>
                    </div>
                </div>
                <div class="actus_block_main">
							<?php		 
							while ( $loop->have_posts() ) : $loop->the_post();
							$image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
					 if($counter==1){ ?>
                		<div class="row">
					<?php } ?>
							<?php if($counter==1 || $counter==5){ ?>
                    		<div class="col-md-6 actus_block_desktop">
                            	<div class="actus_box">
                                	<div class="actus_box_Sub">
                                    	 <div class="details_box">
                                         	<div class="icon_row"><img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon.png"   alt="">  Slalom</div>
                                            <h3><?php echo get_the_title(); ?></h3>
                                            <p><?php echo get_the_excerpt() ?></p>
                                            <div class="plue_link">
												<?php $cat_name=get_the_category(); ?>
                                            	<a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[0]->slug; ?>">
                                                	<span><?php $cat_name=get_the_category(); 
															echo $cat_name[0]->name;
												  ?></span>
                                                </a>
                                            </div>
                                           
                                         </div>
                                          <div class="date"><span><?php echo get_the_date('d') ?></span><?php echo get_the_date('M') ?></div>
                                    </div>
                                	<div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                                </div>
                            </div>
                            <?php }else{ ?>
                            
                            <div class="col-md-3 actus_block_desktop">
								<?php  $hoglight=get_post_meta(get_the_id(),'wpcf-higlighted-news',true);  
								if($hoglight==1)
								{
										$add_class="third";
								}else{
									$add_class="";
								}
								?>
								
                            	<div class="actus_box_second <?php echo $add_class; ?>">
                                	
                                	<div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                                    <div class="actus_box_Sub">
                                    	 <div class="details_box">
                                         	<div class="icon_row">
												<img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon.png"   alt="">
												 <?php $cat_name=get_the_category();  ?>
												<a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[0]->slug; ?>">
												  <?php $cat_name=get_the_category(); 
															echo $cat_name[0]->name;
												  ?>
												  </a>
												</div>
                                            <h3><?php echo get_the_title(); ?></h3>
                                         </div>
                                          <div class="date"><span><?php echo get_the_date('d') ?></span><?php echo get_the_date('M') ?></div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            
                            
                          <?php if($counter%3==0){ ?>
                    	</div>
                    	<?php } 
                    	$counter++;
                    	endwhile;
                    	 wp_reset_postdata(); 
                    	?>
                    <!--item -->
                    <!--item -->
            
                
                <!------------------------mobile lay out---------------------------->
                 <!-- actus_wapper mobile -->
                	<div class="actus_mobile_block">
                    	<div class="actus-mobile">
                       	<?php 	while ( $loop->have_posts() ) : $loop->the_post();
								$image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); 
						?>
                        <!-- item -->
                        	<div class="item">
                            	<div class="actus_mobile_div">
                            	<div class="actus_box">
                                	<div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                                    <div class="actus_box_Sub">
                                    	 <div class="details_box">
                                         	<div class="icon_row"><img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon.png"   alt="">  Slalom</div>
                                            <h3><?php echo get_the_title(); ?></h3>
                                           <p><?php echo get_the_excerpt() ?></p>
                                            <div class="plue_link">
                                            	<a href="#">
                                                	<span><?php $cat_name=get_the_category(); 
															echo $cat_name[0]->name;
												  ?></span>
                                                </a>
                                            </div>
                                           
                                         </div>
                                          <div class="date"><?php echo get_the_date('d') ?></span><?php echo get_the_date('M') ?></div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- item -->
                            <?php endwhile; wp_reset_postdata(); ?>
                         </div>
                       </div>
                        <!-- actus_wapper mobile -->
                </div>
            </div>
        <!-- actus_wapper -->
                <!------------------------end mobile lay out---------------------------->
                
                
                
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
} 


//after slider block
add_shortcode( 'after_slider_block', 'after_slider_block_shortcode' );
function after_slider_block_shortcode( $atts ) {
    ob_start();
   ?>
        <!-- sensation_wapper -->
        	<div class="container">
            	<div class="sensation_wapper">
                	<div class="row">
						
                    	<div class="col-md-8">
                        	<div class="sensation_left" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/sensation_left.png);">
                            	<div class="sensation_textblock">
                                	<div class="sensation_textblock_sub">
                                    	<?php  dynamic_sidebar( 'first-block' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                        	 <div class="club_box">
                             	<?php if($atts['title']!=''){ ?>
                             	<h2><?php echo $atts['title']; ?></h2>
                             	<?php } ?>
                             	<?php if($atts['subtitle']!=''){ ?>
                                <p><?php echo $atts['subtitle']; ?></p>
                                <?php } ?>
                                <?php echo do_shortcode('[mc4wp_form id="92"]'); ?>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- sensation_wapper -->
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
    
    
//   video gallary shortcode

add_shortcode( 'video_gallary', 'video_gallary_shortcode' );
function video_gallary_shortcode( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'video-gallery',
        'posts_per_page' => -1,
        'order' => 'ASC',
    ) );
    if ( $query->have_posts() ) { ?>
        <!-- actus_wapper mobile -->
              <div class="clearfix"></div>
            	<div class="ffck_tv_wapper">
                	<div class="container">
                    	<div class="big_title">
                        	<i><img src="<?php echo get_template_directory_uri(); ?>/images/tv.png"  alt=""></i>	
                            <h2><?php echo $atts['title']; ?></h2>
                            <div class="more_button">
                                <a href="#">
                                    <span>
                                        <i class="fa fa-chevron-right"></i>
                                       <?php echo $atts['subtitle'] ?>
                                    </span>
                                </a>
                            </div>
                      </div>
                      <div class="ffck_tv_block">
						  <div class="row">
							<?php		 
							while ( $query->have_posts() ) : $query->the_post(); ?>
								<div class=" col-md-3 tv_block_main">
                                	<div class="tv_image">
										<img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt="">
										
										<?php $video_provider=get_post_meta(get_the_id(),'video_provider',true);
											  $vdo_id=get_post_meta(get_the_id(),'video_id',true);
										 ?>
										 <?php 
										 if($video_provider=='youtube')
										 { ?>
											 <iframe width="100%" height="183" src="https://www.youtube.com/embed/<?php echo $vdo_id ?>" frameborder="0" allowfullscreen></iframe>
									<?php }
										 elseif($video_provider=='vimeo')
										 { ?>
											 <iframe src="//player.vimeo.com/video/<?php echo $vdo_id ?>" width="100%" height="183" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
								<?php	 }
										 elseif($video_provider=='dailymotion')
										 { ?>
											<iframe frameborder="0" width="100%" height="183" src="//www.dailymotion.com/embed/video/<?php echo $vdo_id ?>" allowfullscreen></iframe>

								<?php	 }else{ ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt="">
								<?php }
										 ?>
									</div>
                                    <h2><?php echo get_the_title(); ?></h2>
                                    <p>Publiée: <?php echo get_the_date('d M Y'); ?></p>
                                </div>
                            <?php endwhile; ?>
                            </div>
                      </div>
                             <?php wp_reset_postdata();  ?>
                             
                             
                        <div class="mobile_tv_block">
                        	<div class="tv-mobile">
							<?php		 
								while ( $query->have_posts() ) : $query->the_post(); ?>
									<div class="item">
										<div class="tv_mobile tv_block_main">
											<div class="tv_image">
												
												<img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt="">
												<?php 
										 if($video_provider=='youtube')
										 { ?>
											 <iframe width="100%" height="183" src="https://www.youtube.com/embed/<?php echo $vdo_id ?>" frameborder="0" allowfullscreen></iframe>
									<?php }
										 elseif($video_provider=='vimeo')
										 { ?>
											 <iframe src="//player.vimeo.com/video/<?php echo $vdo_id ?>" width="100%" height="183" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
								<?php	 }
										 elseif($video_provider=='dailymotion')
										 { ?>
											<iframe frameborder="0" width="100%" height="183" src="//www.dailymotion.com/embed/video/<?php echo $vdo_id ?>" allowfullscreen></iframe>

								<?php	 }
								else{ ?>
											<img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt="">
								<?php }
										 ?>
												</div>
											<h2>Mag PAu 2015 n°4</h2>
											<p>Publiée: 16 août 2015</p>
										</div>
									</div>
							<?php endwhile; 
							wp_reset_postdata(); ?>
							</div>
						</div>
                       </div>
					</div>
            <div class="clearfix"></div>
                            <!-- item -->
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}


// --------Event shortcode ------------

add_shortcode( 'List-Event', 'list_event_shortcode' );
$postin_array=explode(', ',get_post_meta( get_the_ID(), 'voodoo_dropdown2', true ));
function list_event_shortcode( $atts ) {
    ob_start();
    $query = new WP_Query( array(
        'post_type' => 'event',
        'posts_per_page' => -1,
        'post__in'=>$postin_array,
        
    ) );
    if ( $query->have_posts() ) { 
		//print_r($dropdown_value);
		//echo $dropdown_value;
		?>
        
          <!-- evenements_wapper -->
        	<div class="container">
            	<div class="evenements_wapper">
                	<div class="big_title">
                        		
                            <h2> <?php echo $atts['title']; ?></h2>
                            <div class="more_button">
                                <a href="#">
                                    <span>
                                        <i class="fa fa-chevron-right"></i>
                                        Toute les actualités 
                                    </span>
                                </a>
                            </div>
                      </div>
                      <div class="evenements_block">
                      	<div class="desktop_slider">
                        	<div class="event_slider">
								<?php		 
							while ( $query->have_posts() ) : $query->the_post(); ?>
                            	<!--item -->
                                	<div class="item">
                                    	<div class="evene_box">
                                        	<div class="evene_box_image"><img src="<?php echo get_post_meta(get_the_id(),'wpcf-event-image',true); ?>"  alt=""></div>
                                          <div class="evene_box_sub">
                                          		<div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
                                            	<div class="icon_row"><img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon.png"   alt="">  Slalom</div>
                                                <h3><?php echo get_post_meta(get_the_id(),'wpcf-event-place',true); ?></h3>
                                                <div class="address">
                                                	<span><img src="<?php echo get_template_directory_uri(); ?>/images/address.png"  alt=""></span>
                                                    <p><?php echo get_post_meta(get_the_id(),'wpcf-event-place',true); ?></p>
                                              	</div>
                                                 <div class="address">
                                                	<span><img src="<?php echo get_template_directory_uri(); ?>/images/date.png"  alt=""></span>
                                                    <p><?php echo get_post_meta(get_the_id(),'wpcf-event-address',true); ?></p>
                                              	</div>
                                                <div class="read_more">
                                                	<a href="<?php echo get_the_permalink(); ?>">
                                                    	<span>
                                                        	En savoir plus
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <!--item -->
                                 <?php  endwhile;
										wp_reset_postdata(); ?>
                                
                            </div>
                        </div>
                      </div>
                </div>
            </div>
        <!-- evenements_wapper -->
           
        </ul>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
    }
}


/*************************tab shortcodes*********************/
add_shortcode( 'tab-row-start', 'tab_row_start_shortcode' );
function tab_row_start_shortcode( $atts ) {
    ob_start();
   ?>
		<div class="col-lg-4 col-md-6 col-sm-6">
		<div class="tab_box">

    <?php $myvariable = ob_get_clean();
    return $myvariable;
 }

add_shortcode( 'tab-row-end', 'tab_row_start_end__shortcode' );
function tab_row_start_end__shortcode( $atts ) {
    ob_start();
   ?>
		</div>
		</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
 }

add_shortcode( 'tab-button', 'tab_button_shortcode' );
function tab_button_shortcode( $atts ) {
    ob_start();
   ?>
	<div class="col-lg-4 col-md-6 col-sm-6">
	<div class="tab_box">
		 <div class="classments_link">
			<a href="<?php echo $atts['link'] ?>">
				<span>
					<i class="fa fa-chevron-right"></i>
					<?php echo $atts['text'] ?>  
				</span>
			</a>
		 </div>
	</div>
</div>

    <?php $myvariable = ob_get_clean();
    return $myvariable;
 }
 



function wpex_clean_shortcodes($content){   
    $array = array (
        '<p>[' => '[', 
        ']</p>' => ']', 
        ']<br />' => ']'
    );
    $content = strtr($content, $array);
    return $content;
}
add_filter('acf_the_content', 'wpex_clean_shortcodes');
