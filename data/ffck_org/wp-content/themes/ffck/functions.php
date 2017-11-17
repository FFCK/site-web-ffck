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


/* JWC */
require(get_template_directory() . "/inc/ws-config.php");

remove_filter( 'the_content', 'wpautop' );
add_action('admin_head', 'my_custom_fonts');
function my_custom_fonts() {
  echo '<style>
  .media-selection { right: auto !important; }
  </style>';
}

function my_mce4_options($init) {
  $default_colours = '"000000", "Black",
                      "993300", "Burnt orange",
                      "333300", "Dark olive",
                      "003300", "Dark green",
                      "003366", "Dark azure",
                      "000080", "Navy Blue",
                      "333399", "Indigo",
                      "333333", "Very dark gray",
                      "800000", "Maroon",
                      "FF6600", "Orange",
                      "808000", "Olive",
                      "008000", "Green",
                      "008080", "Teal",
                      "0000FF", "Blue",
                      "666699", "Grayish blue",
                      "808080", "Gray",
                      "FF0000", "Red",
                      "FF9900", "Amber",
                      "99CC00", "Yellow green",
                      "339966", "Sea green",
                      "33CCCC", "Turquoise",
                      "3366FF", "Royal blue",
                      "800080", "Purple",
                      "999999", "Medium gray",
                      "FF00FF", "Magenta",
                      "FFCC00", "Gold",
                      "FFFF00", "Yellow",
                      "00FF00", "Lime",
                      "00FFFF", "Aqua",
                      "00CCFF", "Sky blue",
                      "993366", "Red violet",
                      "FFFFFF", "White",
                      "FF99CC", "Pink",
                      "FFCC99", "Peach",
                      "FFFF99", "Light yellow",
                      "CCFFCC", "Pale green",
                      "CCFFFF", "Pale cyan",
                      "99CCFF", "Light sky blue",
                      "CC99FF", "Plum"';

  $custom_colours =  '"1e64af", "Blue main",
                      "549fd0", "Blue secondary",
                      "ce5e2d", "Orange button"';

  // build colour grid default+custom colors
  $init['textcolor_map'] = '['.$default_colours.','.$custom_colours.']';

  // enable 6th row for custom colours in grid
  $init['textcolor_rows'] = 6;

  return $init;
}
add_filter('tiny_mce_before_init', 'my_mce4_options');

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}

function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).' ...';
  } else {
    $content = implode(" ",$content);
  }
  $content = preg_replace('/\[.+\]/','', $content);
  $content = apply_filters('the_content', $content);
  $content = str_replace(']]>', ']]&gt;', $content);
  $content = str_replace('<a', '<p', $content);
  $content = str_replace('/a>', '/a>', $content);
  return $content;
}

// Add Shortcode
function mapdir_shortcode( $atts ) {
  // Attributes
  extract( shortcode_atts(array(
    'src' => 'null',
    'name' => 'null',
  ), $atts ) );


  // $requete = "";
  // if ( isset($_REQUEST['requete']) ) {
  //   $requete = $_REQUEST['requete'];
  // }

  $query = $_SERVER['QUERY_STRING'];

  // Code
  return '<iframe style="border:0; width:100%;" src="' . $src . $query . $requete .'" width="100%" height="700" name="' . $name . '"><p>Votre navigateur ne supporte pas l\'élément iframe</p></iframe>';
}
add_shortcode( 'mapdir', 'mapdir_shortcode' );


function fbgallery_shortcode( $atts ) {
  // Attributes
  extract( shortcode_atts(array(
    'account' => 'null',
    'skipAlbums' => 'null',
  ), $atts ) );

  $str = '<div class="fb-album-container"></div>
  <script type="text/javascript">
      jQuery(document).ready(function () {
        jQuery(".fb-album-container").FacebookAlbumBrowser({
          account: "' . $account . '",
          accessToken: "418207791625564|UWUglA7bQLO4qrguvpnk-h_BoaA",
          skipAlbums: ["Profile Pictures", "Timeline Photos", "Cover Photos", "Mobile Uploads"],
          showAccountInfo: true,
          showImageCount: true,
          lightbox: true,
          photosCheckbox: false,
          photoChecked: function(photo){
              console.log("PHOTO CHECKED: " + photo.id + " - " + photo.url + " - " + photo.thumb);
              console.log("CHECKED PHOTOS COUNT: " + this.checkedPhotos.length);
          },
          photoUnchecked: function (photo) {
              console.log("PHOTO UNCHECKED: " + photo.id + " - " + photo.url + " - " + photo.thumb);
              console.log("CHECKED PHOTOS COUNT: " + this.checkedPhotos.length);
          },
          albumSelected: function (photo) {
            console.log("ALBUM CLICK: " + photo.id + " - " + photo.url + " - " + photo.thumb);

          },
          photoSelected: function (photo) {
              console.log("PHOTO CLICK: " + photo.id + " - " + photo.url + " - " + photo.thumb);
          }
        });
      });
  </script>';

  // Code
  return $str;
}
add_shortcode( 'fbgallery', 'fbgallery_shortcode' );




// Breadcrumbs
function custom_breadcrumbs() {

  // Settings
  $separator          = '&gt;';
  $breadcrums_id      = 'breadcrumbs';
  $breadcrums_class   = 'breadcrumbs';
  $home_title         = 'Accueil';

  // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
  $custom_taxonomy    = 'product_cat';

  // Get the query & post information
  global $post,$wp_query;

  // Do not display on the homepage
  if ( !is_front_page() ) {

    echo '<div class="breadcrumb_wapper"><div class="container"><div class="row"><div class="col-lg-12 center-block float_none">';
    // Build the breadcrums
    echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

    // Home page
    echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '"><img src="' . get_template_directory_uri() . '/images/home-icon.png" alt=""></a></li>';

    if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

      echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

    } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

      // If post is a custom post type
      $post_type = get_post_type();

      // If it is a custom post type display name and link
      if($post_type != 'post') {

        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

      }

      $custom_tax_name = get_queried_object()->name;
      echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

    } else if ( is_single() ) {

      // If post is a custom post type
      $post_type = get_post_type();

      // If it is a custom post type display name and link
      if($post_type != 'post') {

        $post_type_object = get_post_type_object($post_type);
        $post_type_archive = get_post_type_archive_link($post_type);

        echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';

      }

      // Get post category info
      $category = get_the_category();

      if(!empty($category)) {

        // Get last category post is in
        $last_category = end(array_values($category));

        // Get parent any categories and create array
        $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
        $cat_parents = explode(',',$get_cat_parents);

        // Loop through parent categories and store in variable $cat_display
        $cat_display = '';
        foreach($cat_parents as $parents) {
          $cat_display .= '<li class="item-cat">'.$parents.'</li>';
        }

      }

      // If it's a custom post type within a custom taxonomy
      $taxonomy_exists = taxonomy_exists($custom_taxonomy);
      if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

        $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
        $cat_id         = $taxonomy_terms[0]->term_id;
        $cat_nicename   = $taxonomy_terms[0]->slug;
        $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
        $cat_name       = $taxonomy_terms[0]->name;

      }

      // Check if the post is in a category
      if(!empty($last_category)) {
        echo $cat_display;
        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

        // Else if post is in a custom taxonomy
      } else if(!empty($cat_id)) {

        echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

      } else {

        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

      }

    } else if ( is_category() ) {

      // Category page
      echo '<li class="item-cat"><strong class="bread-current bread-cat">' . single_cat_title("", false) . '</strong></li><li class="item-current">Actualités</li>';

    } else if ( is_page() ) {

      // Standard page
      if( $post->post_parent ){

        // If child page, get parents
        $anc = get_post_ancestors( $post->ID );

        // Get parents in the right order
        $anc = array_reverse($anc);

        // Parent page loop
        foreach ( $anc as $ancestor ) {
          if ( get_field( "fa_titre", $ancestor ) != "" ) { $titrefa = get_field( "fa_titre", $ancestor ); }
          else { $titrefa = get_the_title($ancestor); }
          if ( get_field( "fa_cache", $ancestor ) == false ) {
            $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . $titrefa . '">' . $titrefa . '</a></li>';
          }
          else {
            $parents .= '<li class="item-parent item-parent-' . $ancestor . '">' . $titrefa . '</li>';
          }
        }

        // Display parent pages
        echo $parents;

        // Current page
        if ( get_field( "fa_titre", $post->ID ) != "" ) { $titrefacur = get_field( "fa_titre", $post->ID ); }
        else { $titrefacur = get_the_title($post->ID); }
        echo '<li class="item-current item-' . $post->ID . '"><strong title="' . $titrefacur . '"> ' . $titrefacur . '</strong></li>';

      } else {
        if ( get_field( "fa_titre", $post->ID ) != "" ) { $titrefacur = get_field( "fa_titre", $post->ID ); }
        else { $titrefacur = get_the_title($post->ID); }

        // Just display current page if not parents
        echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . $titrefacur . '</strong></li>';

      }

    } else if ( is_tag() ) {

      // Tag page

      // Get tag information
      $term_id        = get_query_var('tag_id');
      $taxonomy       = 'post_tag';
      $args           = 'include=' . $term_id;
      $terms          = get_terms( $taxonomy, $args );
      $get_term_id    = $terms[0]->term_id;
      $get_term_slug  = $terms[0]->slug;
      $get_term_name  = $terms[0]->name;

      // Display the tag name
      echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

    } elseif ( is_day() ) {

      // Day archive

      // Year link
      echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

      // Month link
      echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';

      // Day display
      echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

    } else if ( is_month() ) {

      // Month Archive

      // Year link
      echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';

      // Month display
      echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

    } else if ( is_year() ) {

      // Display year archive
      echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

    } else if ( is_author() ) {

      // Auhor archive

      // Get the author information
      global $author;
      $userdata = get_userdata( $author );

      // Display author name
      echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

    } else if ( get_query_var('paged') ) {

      // Paginated archives
      echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

    } else if ( is_search() ) {

      // Search results page
      echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

    } elseif ( is_404() ) {

      // 404 page
      echo '<li>' . 'Error 404' . '</li>';
    }

    echo '</ul></div></div></div></div>';

  }

}




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
    ));

    /*
    * Switch default core markup for search form, comment form, and comments
    * to output valid HTML5.
    */
    add_theme_support( 'html5', array(
      'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
    ));

    /*
    * Enable support for Post Formats.
    * See https://codex.wordpress.org/Post_Formats
    */
    add_theme_support( 'post-formats', array(
      'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
    ));

    // This theme allows users to set a custom background.
    add_theme_support( 'custom-background', apply_filters( 'twentyfourteen_custom_background_args', array(
      'default-color' => 'f5f5f5',
    )));

    // Add support for featured content.
    add_theme_support( 'featured-content', array(
      'featured_content_filter' => 'twentyfourteen_get_featured_posts',
      'max_posts' => 6,
    ));

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
  ));
  register_sidebar( array(
    'name'          => __( 'Content Sidebar', 'twentyfourteen' ),
    'id'            => 'sidebar-2',
    'description'   => __( 'Additional sidebar that appears on the right.', 'twentyfourteen' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ));
  register_sidebar( array(
    'name'          => __( 'Footer Widget Area', 'twentyfourteen' ),
    'id'            => 'sidebar-3',
    'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h1 class="widget-title">',
    'after_title'   => '</h1>',
  ));
  register_sidebar( array(
    'name'          => __( 'First Content Block', 'twentyfourteen' ),
    'id'            => 'first-block',
    'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ));
  register_sidebar( array(
    'name'          => __( 'Footer Newslatter Block', 'twentyfourteen' ),
    'id'            => 'footer_newslatter_block',
    'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));
  register_sidebar( array(
    'name'          => __( 'Footer Newslatter Block', 'twentyfourteen' ),
    'id'            => 'footer_newslatter_block',
    'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));
  register_sidebar( array(
    'name'          => __( 'Sidebar Mailchamp', 'twentyfourteen' ),
    'id'            => 'sidebar_mailchamp',
    'description'   => __( 'Appears in the footer section of the site.', 'twentyfourteen' ),
    'before_widget' => '',
    'after_widget'  => '',
    'before_title'  => '',
    'after_title'   => '',
  ));
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

function register_my_menu() {
  register_nav_menu('mobile-menu',__( 'Mobile Menu' ));
}
add_action( 'init', 'register_my_menu' );

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
    ));
  }

  wp_enqueue_script( 'twentyfourteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150315', true );
  wp_enqueue_script( 'twentyfourteen-custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), false, true );
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
    ));

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

    printf( '<a href="%1$s" rel="attachment">%2$s</a>',esc_url( $next_attachment_url ),wp_get_attachment_image( $post->ID, $attachment_size ));
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
    ));

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
  __( 'Select Event', 'mytheme_textdomain' ),  // metabox title
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
  if($_POST['voodoo_dropdown2']!=''){
    $new_value2 = implode(',',$_POST['voodoo_dropdown2']);

    update_post_meta( $post_id, 'voodoo_dropdown2', $new_value2 );
  }
}



// action to add meta boxes
add_action( 'add_meta_boxes', 'voodoo_dropdown_metabox3' );
// action on saving post
add_action( 'save_post', 'voodoo_dropdown_save3' );

// function that creates the new metabox that will show on post
function voodoo_dropdown_metabox3() {
  add_meta_box(
  'voodoo_dropdown3',  // unique id
  __( 'Select Post Category', 'mytheme_textdomain' ),  // metabox title
  'voodoo_dropdown_display3',  // callback to show the dropdown
  'page'   // post type
);
}
// voodoo dropdown display
function voodoo_dropdown_display3( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'voodoo_dropdown_nonce' );
  $dropdown_value = get_post_meta( $_GET['post'], 'voodoo_dropdown', true );
  $args = array(
    'orderby' => 'name',
    'parent' => 0
  );
  $categories = get_categories( $args );

  ?>

  <select name=voodoo_dropdown>
    <option>Select Category</option>
    <?php foreach ( $categories as $category ) { $arrval=explode(',',$dropdown_value) ?>
    <option <?php if($dropdown_value==$category->term_id){ echo 'selected="selected"'; } ?> value="<?php echo $category->term_id; ?>" ><b><?php echo $category->name; ?></b></option>
    <?php } ?>
  </select>
  <?php
}

// dropdown saving
function voodoo_dropdown_save3( $post_id ) {

  // if doing autosave don't do nothing
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
  return;

  // verify nonce
  if ( !wp_verify_nonce( $_POST['voodoo_dropdown_nonce'], basename( __FILE__ ) ) )
  return;

  // save the new value of the dropdown
  //print_r($_POST['voodoo_dropdown2']);
  if($_POST['voodoo_dropdown']!=''){
    $new_value2 = $_POST['voodoo_dropdown'];

    update_post_meta( $post_id, 'voodoo_dropdown', $new_value2 );
  }
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
  $query = new WP_Query(array(
    'post_type' => 'big-access-slider',
    'posts_per_page' => -1,
  ));
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
                  <div class="acces_block_image"><a href="<?php echo get_field('link'); ?>"><span><img src="<?php echo $image_url; ?>"  alt=""></span></div>
                    <div class="acces_title"><?php echo get_the_title(); ?></a></div>
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
  $args = array( 'category__and' => array(28), 'post_type' => 'post', 'posts_per_page' => 6 );
  $loop = new WP_Query( $args );
  if ( $loop->have_posts() ) { ?>
    <!--item -->
    <?php $counter=1; ?>
    <div class="container">
      <div class="actus_wapper">
        <div class="big_title">
          <h2><?php echo $atts['title']; ?></h2>
          <div class="more_button">
            <a href="<?php echo $atts['link']; ?>">
              <span>
                <i class="fa fa-chevron-right"></i>
                <?php echo $atts['subtitle']; ?>
              </span>
            </a>
          </div>
        </div>
        <div class="actus_block_main">
          <?php while ( $loop->have_posts() ) : $loop->the_post(); $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
            <?php if($counter==1 || $counter==5){ ?>
              <div class="col-md-6 actus_block_desktop">
                <div class="actus_box">
                  <div class="actus_box_Sub">
                    <div class="details_box">
                      <?php $cat_name=get_the_category(); ?>
                      <div class="icon_row"><img src="<?php echo get_field('category_image', 'category_'.$cat_name[1]->term_taxonomy_id);  ?>" alt="">
                        <a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[1]->slug; ?>"><?php echo $cat_name[1]->name; ?></a>
                      </div>
                      <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                      <p><?php echo content(33); ?></p>
                      <div class="plue_link">
                        <a href="<?php echo the_permalink(); ?>"><span>En savoir plus</span></a>
                      </div>
                    </div>
                    <div class="date">
                      <span><?php echo get_the_date('d') ?></span><?php echo get_the_date('M') ?>
                    </div>
                  </div>
                  <a href="<?php the_permalink(); ?>">
                    <div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                  </a>
                </div>
              </div>
            <?php } else { ?>
              <div class="col-md-3 actus_block_desktop">
                <?php  $hoglight=get_post_meta(get_the_id(),'wpcf-higlighted-news',true);
                if($hoglight==1) {
                  $add_class="third";
                  $img="salon_icon2.png";
                } else {
                  $add_class="";
                  $img="salon_icon.png";
                }
                ?>
                <div class="actus_box_second <?php echo $add_class; ?>">
                  <a href="<?php the_permalink(); ?>">
                    <div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                  </a>
                  <div class="actus_box_Sub">
                    <div class="details_box">
                      <div class="icon_row">
                        <?php $cat_name=get_the_category();  ?>
                        <img src="<?php echo get_field('category_image', 'category_'.$cat_name[1]->term_taxonomy_id); ?>" alt="">
                        <a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[1]->slug; ?>"><?php echo $cat_name[1]->name; ?></a>
                      </div>
                      <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                      <p></p>
                    </div>
                    <div class="date"><span><?php echo get_the_date('d') ?></span><?php echo get_the_date('M') ?></div>
                  </div>
                </div>
              </div>
            <?php } $counter++; ?>
          <?php endwhile; wp_reset_postdata(); ?>
          <!-- mobile layout -->
          <div class="actus_mobile_block"> <!-- actus_wapper mobile -->
            <div class="actus-mobile">
              <?php while ( $loop->have_posts() ) : $loop->the_post(); $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); ?>
                <div class="item"> <!-- item -->
                  <div class="actus_mobile_div">
                    <div class="actus_box">
                      <a href="<?php the_permalink(); ?>">
                        <div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div>
                      </a>
                      <div class="actus_box_Sub">
                        <div class="details_box">
                          <div class="icon_row">
                            <!--img src="<?php echo get_template_directory_uri(); ?>/images/salon_icon.png" alt=""-->
                            <?php $cat_name=get_the_category();  ?>
                            <img src="<?php echo get_field('category_image', 'category_'.$cat_name[1]->term_taxonomy_id);  ?>" alt="">
                            <a href="<?php echo home_url(); ?>/category/<?php echo $cat_name[1]->slug; ?>"><?php echo $cat_name[1]->name; ?></a>
                          </div>
                          <h3><a href="<?php the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
                          <p><?php echo excerpt(25); ?></p>
                          <div class="plue_link">
                            <a href="<?php the_permalink(); ?>"><span>En savoir plus</span></a>
                          </div>
                        </div>
                        <div class="date"><?php echo get_the_date('d') ?></span><?php echo get_the_date('M') ?></div>
                      </div>
                    </div>
                  </div>
                </div> <!-- /.item -->
              <?php endwhile; wp_reset_postdata(); ?>
            </div>
          </div><!-- /.actus_wapper mobile -->
          <!-- end mobile layout -->
        </div> <!-- /.actus_block_main -->
      </div> <!-- /actus_wapper -->
    </div> <!-- /container -->
    <?php $myvariable = ob_get_clean(); return $myvariable;
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
          <div class="sensation_left" style="background-image:url(<?php echo get_template_directory_uri(); ?>/images/sensation_left2.png);">
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
            <?php // echo do_shortcode('[mc4wp_form id="92"]'); ?>
            <form id="form-annuaire" class="mc4wp-form mc4wp-form-92">
              <div class="mc4wp-form-fields">
                <div class="main_club_box">
                  <div class="sub_div">
                    <input id="autocomplete" type="text" name="ville" placeholder="Ville ou code postal" required="">
                  </div>
                  <span class="club_icon"><img alt="" id="geofindme" src="<?php get_site_url (); ?>/wp-content/themes/ffck/images/club_icon.png" onclick="geoFindMe()" style="cursor:pointer;"></span>
                </div>
                <div class="button_block">
                  <input id="button-annuaire" type="submit" value="Rechercher">
                </div>
                <div id="geoloc-out" style="color:#FFF;"></div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- sensation_wapper -->
  <?php $myvariable = ob_get_clean(); return $myvariable;
}

// video gallary shortcode
add_shortcode( 'video_gallary', 'video_gallary_shortcode' );
function video_gallary_shortcode( $atts ) {
  ob_start();
?>

  <!-- actus_wapper mobile -->
  <div class="clearfix"></div>
  <div class="ffck_tv_wapper">
    <div class="container">
      <div class="big_title">
        <i><img src="<?php echo get_template_directory_uri(); ?>/images/tv.png"  alt=""></i>
        <h2><?php echo $atts['title']; ?></h2>
        <div class="more_button">
          <a href="<?php echo $atts['link']; ?>"><span><i class="fa fa-chevron-right"></i><?php echo $atts['subtitle'] ?></span></a>
        </div>
      </div>
      <div id="sc-video-gallery"><img src="<?php echo get_template_directory_uri(); ?>/images/loader.gif">&nbsp;&nbsp;Chargement</div>
    </div>
  </div> <!-- /ffck_tv_wapper -->
  <div class="clearfix"></div>


<?php
  $myvariable = ob_get_clean(); return $myvariable;
}

// --------Event shortcode ------------

add_shortcode( 'List-Event', 'list_event_shortcode' );
print_r($postin_array);
function list_event_shortcode( $atts ) {
  ob_start();

  $scActivite = $atts['activite'];
  $scTitle = $atts['title'];
  $scLink = $atts['link'];
  $scSubtitle = $atts['subtitle'];

?>

	<div class="container">

    <div class="evenements_wapper">
      <div class="big_title">
        <h2><?php echo $scTitle; ?></h2>
        <div class="more_button">
          <a href="<?php echo $scLink; ?>"><span><i class="fa fa-chevron-right"></i><?php echo $scSubtitle; ?></span></a>
        </div>
      </div>
      <div id="sc-list-event" class="evenements_block" data-activite="<?php echo $scActivite; ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/loader.gif">&nbsp;&nbsp;Chargement</div>
    </div> <!-- /evenements_wapper -->

  </div> <!-- /container -->

  <?php $myvariable = ob_get_clean(); return $myvariable;
}

/* tab shortcodes */
add_shortcode( 'tab-row-start', 'tab_row_start_shortcode' );
function tab_row_start_shortcode( $atts ) {
  ob_start();
  ?>
  <div class="col-lg-4 col-md-6 col-sm-6">
    <div class="tab_box">
  <?php $myvariable = ob_get_clean(); return $myvariable;
}

add_shortcode( 'tab-row-end', 'tab_row_start_end__shortcode' );
function tab_row_start_end__shortcode( $atts ) {
  ob_start();
  ?>
    </div>
  </div>
  <?php $myvariable = ob_get_clean(); return $myvariable;
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

add_shortcode( 'button-red', 'button_red_shorecode' );
function button_red_shorecode( $atts ) {
  ob_start();
  ?>
  <div class="button_red">
    <a href="<?php echo $atts['link']; ?>">
      <span>
        <i class="fa fa-chevron-right"></i>
        <?php echo $atts['text']; ?>
      </span>
    </a>
  </div>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
}

add_shortcode( 'button-blue', 'button_blue_shorecode' );
function button_blue_shorecode( $atts ) {
  ob_start();
  ?>
  <div class="button_red blue">
    <a href="<?php echo $atts['link']; ?>">
      <span>
        <i class="fa fa-chevron-right"></i>
        <?php echo $atts['text']; ?>
      </span>
    </a>
  </div>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
}

add_shortcode( 'button-orange', 'button_orange_shorecode' );
function button_orange_shorecode( $atts ) {
  ob_start();
  ?>
  <div class="button_red orange">
    <a href="<?php echo $atts['link']; ?>">
      <span>
        <i class="fa fa-chevron-right"></i>
        <?php echo $atts['text']; ?>
      </span>
    </a>
  </div>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
}

add_shortcode( 'button-gray', 'button_gray_shorecode' );
function button_gray_shorecode( $atts ) {
  ob_start();
  ?>
  <div class="button_red gray">
    <a href="<?php echo $atts['link']; ?>">
      <span>
        <i class="fa fa-chevron-right"></i>
        <?php echo $atts['text']; ?>
      </span>
    </a>
  </div>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
}



add_shortcode( 'accordian-video-gallary', 'accordian_video_gallary_shortcode' );
function accordian_video_gallary_shortcode( $atts ) {
  ob_start();
  $query = new WP_Query( array(
    'post_type' => 'video-gallery',
    'posts_per_page' => -1,
    'order' => 'ASC',
    'tax_query' => array(
      array(
        'taxonomy' => 'video-categories',
        'field' => 'id',
        'terms' => $atts['cat-id'],
        'operator' => 'IN',
      )
    )
  ) );
  if ( $query->have_posts() ) { ?>
    <div class="ac_block">
      <div class="row">
        <?php while ( $query->have_posts() ) : $query->the_post(); ?>
          <div class="col-lg-4 col-md-6 col-sm-6 tv_block_main">
            <div class="tv_image">
              <img alt="" src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg">
              <?php $video_provider=get_post_meta(get_the_id(),'video_provider',true); $vdo_id=get_post_meta(get_the_id(),'video_id',true); ?>
              <?php if ($video_provider=='youtube') { ?>
                <iframe width="100%" height="183" src="https://www.youtube.com/embed/<?php echo $vdo_id ?>" frameborder="0" allowfullscreen></iframe>
              <?php } elseif ($video_provider=='vimeo') { ?>
                <iframe src="//player.vimeo.com/video/<?php echo $vdo_id ?>" width="100%" height="183" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
              <?php	 } elseif ($video_provider=='dailymotion') { ?>
                <iframe frameborder="0" width="100%" height="183" src="//www.dailymotion.com/embed/video/<?php echo $vdo_id ?>" allowfullscreen></iframe>
              <?php	} else { ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/tv_1.jpg"   alt="">
              <?php } ?>
            </div>
            <h2><?php the_title(); ?></h2>
            <p>Publiée: <?php echo get_the_date('d M Y') ?></p>
          </div>
        <?php endwhile; wp_reset_postdata(); ?>
        <div class="button_center">
          <a href="<?php echo $atts['link']; ?>">
            <span><i class="fa fa-chevron-right"></i><?php echo $atts['button-text']; ?></span>
          </a>
        </div>
      </div>
    </div>
    <?php $myvariable = ob_get_clean();
    return $myvariable;
  }
}

add_shortcode( 'master-page-event-slider', 'master_page_event_slider_shortcode' );
function master_page_event_slider_shortcode( $atts ) {
  ob_start();
  $dateDebut = date("d/m/Y");
  $dateFin = date('d/m/Y', strtotime('+2 months'));
  $codeStructure = "";
  $codeTypeFormation = "";
  $codeTypeActiviteFormation = "";
  $codeTypeEvt = "COMPOPEN,COMPOFF";
  $codeTypeActivite = $atts['activite'];
  $niveaux = "";
  $codeStructureMere = "";
  $optional = "";

  $xml = getCalendrier($dateDebut, $dateFin, $codeStructure, $codeTypeFormation, $codeTypeActiviteFormation, $codeTypeEvt, $codeTypeActivite, $niveaux, $codeStructureMere, $optional);

  foreach($xml->calendrier->evenements->evenement as $evenement) {
    $arr[] = $evenement;
  }
  usort($arr,function($a,$b){
    return strtotime(str_replace('/', '-', $a->dateDebut))-strtotime(str_replace('/', '-', $b->dateDebut));
  });
?>
  <!-- vanir -->
  <div class="venir_wapper">
    <div class="big_title_inner">
      <h2><?php echo $atts['title']; ?></h2>
      <div class="more_button_inner">
        <a href="<?php echo $atts['link'] ?>">
          <span>
            <i class="fa fa-chevron-right"></i>
            <?php echo $atts['button-text'] ?>
          </span>
        </a>
      </div>
    </div>
    <div class="venir_wapper_sub">
      <div class="venir_slider">
        <?php foreach($arr as $event){ ?>

        <?php
          // On met les dates dans un format lisible
          $dateDebut = DateTime::createFromFormat('d/m/Y', $event->dateDebut);
          $dateFin = DateTime::createFromFormat('d/m/Y', $event->dateFin);
          $dateDebut = new DateTimeFrench($dateDebut->format('d-m-Y'), $DTZ);
          $dateFin = new DateTimeFrench($dateFin->format('d-m-Y'), $DTZ);

          // on charge le détail de l'évènement
          $xmldetail = getDetailEvenement($event->codex);

          // On initialise les variables d'affichage générales
          $regionId = explode(" - ", $event->structureOrganisatrice)[0];
          $codeNiveau = $event->codeNiveau;
          $codeActivite = $event->codeActivite;

          $libelle = $event->nomEvenement;
          $sousLibelle = ucfirst(strtolower($xmldetail->manifestation->lieuEvenement->ville));
          $sousLibelle .= ',&nbsp;' . strtoupper($xmldetail->manifestation->lieuEvenement->pays);

        ?>
        <!-- item -->
        <div class="item" >
          <div class="venir_box_main">
            <?php $clsaa=""; if(get_post_meta(get_the_id(),'wpcf-higlighted-news',true)==1){ $clsaa="heighlight"; } ?>
            <div class="venir_box <?php echo $clsaa; ?>">
              <div class="date"><span><?php echo $dateDebut->format('d'); ?></span><?php echo substr($dateDebut->format('F'), 0, 4); ?></div>
              <!-- <div class="nav_icon2"></div> -->
              <h4 style="margin-top:8px;"><?php echo $libelle ?></h4>
              <div class="address">
                <span class="pin"> </span>
                <p><?php echo $sousLibelle ?></p>
              </div>
              <div class="address">
                <span class="date3"> </span>
                <p><?php if($dateDebut != $dateFin): ?>du <?php endif; ?>
                <?php echo $dateDebut->format('d') . ' ' . $dateDebut->format('F'); ?>
                <?php if($dateDebut != $dateFin): ?>
                  <?php echo ' au ' . $dateFin->format('d') . ' ' . $dateFin->format('F'); ?>
                <?php endif; ?></p>
              </div>
            </div>
          </div>
        </div>
        <!-- item -->
        <?php } //endforeach ?>
      </div>
    </div>
  </div>
<!-- vanir -->

  <?php $myvariable = ob_get_clean();
  return $myvariable;
}



add_shortcode( 'masterpage-news', 'masterpage_news_shortcode' );
function masterpage_news_shortcode( $atts ) {
  ob_start();
  ?>
  <div class="une_wapper">
    <div class="big_title_inner">
      <h2><?php echo $atts['title']; ?></h2>
      <div class="more_button_inner">
        <a href="<?php echo $atts['link']; ?>"><span><i class="fa fa-chevron-right"></i><?php echo $atts['button-text']; ?> </span></a>
      </div>
    </div>
    <div class="une_block_main">
      <div class="une_block_desktop">
        <?php
          $counter = 1;
          // Start the Loop
          $argss =  array(
            'post_type' => 'post',
            'posts_per_page' => 5,
            'tax_query' => array(
              array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => array($atts['cat-id'])
              )
            )
          );
          $loop = new WP_Query( $argss );
          $the_query = new WP_Query( $args );
          //while ( have_posts() ) : the_post();
          while ( $loop->have_posts() ) : $loop->the_post();
          query_posts( 'cat=2' );
          $cat_name=get_the_category();
          if (strtolower($cat_name[0]->slug) == 'accueil' || strtolower($cat_name[0]->slug) == 'presse') {
            if (strtolower($cat_name[1]->slug) == 'accueil' || strtolower($cat_name[1]->slug) == 'presse') {
              $nomcat = $cat_name[2]->name;
              $slugcat = $cat_name[2]->slug;
              $idcat = $cat_name[2]->term_taxonomy_id;
            }
            else {
              $nomcat = $cat_name[1]->name;
              $slugcat = $cat_name[1]->slug;
              $idcat = $cat_name[1]->term_taxonomy_id;
            }
          }
          else {
            $nomcat = $cat_name[0]->name;
            $slugcat = $cat_name[0]->slug;
            $idcat = $cat_name[0]->term_taxonomy_id;
          }

          $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );

          if($counter==1 || $counter==3) {
        ?>
          <div class="row">
        <?php } if($counter==1) { ?>
          <div class="col-md-8 actus_block_desktop">
            <div class="actus_box">
              <div class="actus_box_Sub">
                <div class="details_box">
                  <div class="icon_row">
                    <a href="<?php the_permalink(); ?>"><img src="<?php echo get_field('category_image', 'category_'.$idcat);  ?>" alt=""></a>
                    <a href="<?php echo home_url(); ?>/category/<?php echo $slugcat; ?>">
                      <?php echo $nomcat; ?>
                    </a>
                  </div>
                  <a href="<?php the_permalink(); ?>"><h3><?php echo get_the_title(); ?></h3></a>
                  <p><?php echo content(30); ?></p>
                  <div class="plue_link">
                    <a href="<?php the_permalink(); ?>"><span>En savoir plus</span></a>
                  </div>
                </div>
                <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
              </div>
              <a href="<?php the_permalink(); ?>"><div class="actus_box_image" style="background-image:url(<?php echo $image_url ?>);"></div></a>
            </div>
          </div>
        <?php } else { ?>
          <?php  $hoglight=get_post_meta(get_the_id(),'wpcf-higlighted-news',true); if($hoglight==1) { ?>
            <div class="col-md-4 actus_block_desktop">
              <div class="actus_box_second third">
                <div class="actus_box_image"><a href="<?php the_permalink(); ?>"><img src="<?php echo $image_url ?>"   alt=""></a></div>
                <div class="actus_box_Sub">
                  <div class="details_box">
                    <div class="icon_row">
                      <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo get_field('category_image', 'category_'.$idcat);  ?>" alt="">
                      </a>
                      <a href="<?php echo home_url(); ?>/category/<?php echo $slugcat; ?>">
                        <?php echo $nomcat; ?>
                      </a>
                    </div>
                    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                  </div>
                  <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
                </div>
              </div>
            </div>
          <?php } else { ?>
            <div class="col-md-4 actus_block_desktop">
              <div class="actus_box_second">
                <a href="<?php the_permalink(); ?>"><div class="actus_box_image" style="background-image:url(<?php echo $image_url ?>);"></div></a>
                <div class="actus_box_Sub">
                  <div class="details_box">
                    <div class="icon_row">
                      <img src="<?php echo get_field('category_image', 'category_'.$idcat);  ?>" alt="">
                      <a href="<?php echo home_url(); ?>/category/<?php echo $slugcat; ?>">
                        <?php echo $nomcat; ?>
                      </a>
                    </div>
                    <a href="<?php the_permalink(); ?>"> <h3><?php the_title(); ?></h3></a>
                  </div>
                  <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
                </div>
              </div>
            </div>
          <?php } ?>
        <?php } ?>
        <?php if ($counter==2 || $counter==5 || $counter==count($posts)) { ?>
          </div>
        <?php } $counter++; endwhile; wp_reset_postdata(); wp_reset_query(); ?>
          <!-- mobile view -->
          </div>
        </div>
        <div class="actus_mobile_block">
          <div class="actus-mobile">
            <?php //$args = array( 'post_type' => 'post', 'posts_per_page' => 5 ,'category' => 3);
            $argsss =  array(
              'post_type' => 'post',
              'posts_per_page' => -1,
              'tax_query' => array(
                array(
                  'taxonomy' => 'category',
                  'field' => 'id',
                  'terms' => $atts['cat-id']
                )
              )

            );
            $loop = new WP_Query( $argsss );
            $the_query = new WP_Query( $args );
            //while ( have_posts() ) : the_post();
            while ( $loop->have_posts() ) : $loop->the_post();
            $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
            $cat_name=get_the_category();
            if (strtolower($cat_name[0]->slug) == 'accueil' || strtolower($cat_name[0]->slug) == 'presse') {
              if (strtolower($cat_name[1]->slug) == 'accueil' || strtolower($cat_name[1]->slug) == 'presse') {
                $nomcat = $cat_name[2]->name;
                $slugcat = $cat_name[2]->slug;
                $idcat = $cat_name[2]->term_taxonomy_id;
              }
              else {
                $nomcat = $cat_name[1]->name;
                $slugcat = $cat_name[1]->slug;
                $idcat = $cat_name[1]->term_taxonomy_id;
              }
            }
            else {
              $nomcat = $cat_name[0]->name;
              $slugcat = $cat_name[0]->slug;
              $idcat = $cat_name[0]->term_taxonomy_id;
            }
            ?>
              <div class="item"> <!-- item -->
                <div class="actus_mobile_div">
                  <div class="actus_box">
                    <a href="<?php the_permalink(); ?>"><div class="actus_box_image" style="background-image:url(<?php echo $image_url; ?>);"></div></a>
                    <div class="actus_box_Sub">
                      <div class="details_box">
                        <div class="icon_row">
                          <img src="<?php echo get_field('category_image', 'category_'.$idcat);  ?>" alt="">
                          <a href="<?php echo home_url(); ?>/category/<?php echo $slugcat; ?>">
                            <?php echo $nomcat; ?>
                          </a>
                        </div>
                        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
                        <?php the_excerpt(); ?>
                        <div class="plue_link">
                          <a href="<?php the_permalink(); ?>"><span>En savoir plus</span></a>
                        </div>
                      </div>
                      <div class="date"><span><?php echo get_the_date('d'); ?></span><?php echo get_the_date('M'); ?></div>
                    </div>
                  </div>
                </div>
              </div> <!-- item -->
            <?php	endwhile; wp_reset_postdata(); wp_reset_query(); ?>
          </div>
        </div>
      </div>
    </div>
  <?php $myvariable = ob_get_clean();
  return $myvariable;
}

add_shortcode( 'sidebar-menu', 'sidebar_menu_shortcode' );
function sidebar_menu_shortcode( $atts ) {
  ob_start();
  $shorecode=get_field('menu_shortcode');
  $query = new WP_Query( array(
    'post_type' => 'big-access-slider',
    'posts_per_page' => -1,
    'order' => 'ASC',
  ) );
  if ( $query->have_posts() ) {
    $manu_arg = array(
      'menu'            => $atts['name'],
      'items_wrap'      => '<ul class="sub_cat" id="menu-sidebar_second_menu">%3$s</ul>',
      //'walker'          => new themeslug_walker_nav_menu
    );
    wp_nav_menu($manu_arg);
    $myvariable = ob_get_clean();
    return $myvariable;
  }
}

add_shortcode( 'sidebar-slider', 'sidebar_slider_shortcode' );
function sidebar_slider_shortcode( $atts ) {
  ob_start();
  ?>
  <div class="courses_block">
    <h4><?php $atts['title'] ?></h4>
    <div class="courses_slider">
      <div class="courses">

        <?php
        $args = array( 'post_type' => 'sidebar-add', 'posts_per_page' => -1 );
        $loop = new WP_Query( $args );
        $the_query = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
        $image_url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        ?>
        <!-- item -->
        <div class="item">
          <div class="courses_box">
            <div class="cur_img">
              <img src="<?php echo $image_url; ?>"   alt="">
            </div>
            <p><?php echo get_the_title(); ?></p>
          </div>
        </div>
        <!-- item -->
      <?php endwhile; ?>
    </div>
  </div>
</div>
<?php $myvariable = ob_get_clean();
return $myvariable;
}

function get_top_parent_page_id() {
  global $post;
  $ancestors = $post->ancestors;
  // Check if page is a child page (any level)
  if ($ancestors) {
    //  Grab the ID of top-level page from the tree
    return end($ancestors);
  } else {
    // Page is the top level, so use  it's own id
    return $post->ID;
  }
}
