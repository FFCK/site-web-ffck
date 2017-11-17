<?php

class Listify_Navigation {

    public function __construct() {
        add_filter( 'wp_page_menu_args', array( $this, 'always_show_home' ) );

        add_filter( 'nav_menu_css_class', array( $this, 'popup_trigger_class' ), 10, 3 );

        // tertiary
        add_action( 'listify_page_before', array( $this, 'tertiary_menu' ) );

        // avatar
        add_filter( 'walker_nav_menu_start_el', array( $this, 'avatar_item' ), 10, 4 );
        add_filter( 'nav_menu_css_class', array( $this, 'avatar_item_class' ), 10, 3 );

        // search
        add_filter( 'wp_nav_menu_items', array( $this, 'search_icon' ), 1, 2 );

        // megamenu
        add_filter( 'wp_nav_menu_items', array( $this, 'taxonomy_mega_menu' ), 0, 2 );
    }

    /**
     * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
     */
    public function always_show_home( $args ) {
        $args['show_home'] = true;

        return $args;
    }

    /**
     * Custom Account menu item.
     *
     * Look for a menu item with a title of `{{account}}` and replace the
     * content with information about the current account.
     *
     * @since Listify 1.0.0
     *
     * @param string $item_output
     * @param object $item
     * @param int $depth
     * @param array $args
     * @return string $item_output
     */
    public function avatar_item( $item_output, $item, $depth, $args ) {
        if ( '{{account}}' != $item->title ) {
            return $item_output;
        }

        $user = wp_get_current_user();

        if ( ! is_user_logged_in() ) {
            $display_name = apply_filters( 'listify_account_menu_guest_label', __( 'Guest', 'listify' ) );

            $avatar = '';
        } else {
            if ( $user->first_name ) {
                $display_name = $user->first_name;
            } else {
                $display_name = $user->display_name;
            }

            $display_name = apply_filters( 'listify_acount_menu_user_label', $display_name, $user );

            $avatar =
            '<div class="current-account-avatar" data-href="' . esc_url( apply_filters( 'listify_avatar_menu_link', get_author_posts_url( $user->ID, $user->user_nicename ) ) ) .
            '">' .
                    get_avatar( $user->ID, 90 )
            . '</div>';
        }

        $item_output = str_replace( '{{account}}', $avatar . $display_name, $item_output );

        return $item_output;
    }

    /**
     * If the menu item has the `{{account}}` tag add a custom class to the item.
     *
     * @see listify_account_walker_nav_menu_start_el()
     *
     * @since Listify 1.0.0
     *
     * @param array $classes
     * @param object $item
     * @param array $args
     * @return array $classes
     */
    public function avatar_item_class( $classes, $item, $args ) {
        if ( 'primary' != $args->theme_location ) {
            return $classes;
        }

        if ( '{{account}}' != $item->title || ! is_user_logged_in() ) {
            return $classes;
        }

        $classes[] = 'account-avatar';

        return $classes;
    }

    public function popup_trigger_class( $classes, $item, $args ) {
        $popup = array_search( 'popup', $classes );

        if ( false === $popup ) {
            remove_filter( 'nav_menu_link_attributes', array( $this, 'popup_trigger_attributes' ), 10, 3 );

            return $classes;
        } else {
            unset( $classes[ $popup ] );

            add_filter( 'nav_menu_link_attributes', array( $this, 'popup_trigger_attributes' ), 10, 3 );
        }

        return $classes;
    }

    public function popup_trigger_attributes( $atts, $item, $args ) {
        $atts[ 'class' ] = 'popup-trigger-ajax';

        if ( in_array( 'popup-wide', $item->classes ) ) {
            $atts[ 'class' ] .= ' popup-wide';
        }

        return $atts;
    }

    public function search_icon( $items, $args ) {
        if ( 'primary' != $args->theme_location || ! listify_theme_mod( 'nav-search' ) ) {
            return $items;
        }

        if ( listify_has_integration( 'facetwp' ) ) {
            return '<li class="menu-item menu-type-link"><a href="' . get_post_type_archive_link( 'job_listing' ) . '" class="search-overlay-toggle"></a></li>' . $items;
        } else {
            return '<li class="menu-item menu-type-link"><a href="#search-header" data-toggle="#search-header" class="search-overlay-toggle"></a></li>' . $items;
        }
    }

    function tertiary_menu() {
        global $post, $wp_query;

        $enabled = get_post_meta( $post->ID, 'enable_tertiary_navigation', true );

        if ( 1 != $enabled ) {
            return;
        }

        // hack based on where our page titles fall
        $wp_query->in_the_loop = false;

        ob_start();

        wp_nav_menu( array(
            'theme_location' => 'tertiary',
            'container_class' => 'navigation-bar nav-menu',
            'menu_class' => 'tertiary nav-menu'
        ) );

        $menu = ob_get_clean();

        if ( '' == $menu ) {
            return;
        }

        remove_filter( 'the_title', 'wc_page_endpoint_title' );
    ?>
        <nav class="tertiary-navigation" role="navigation">
            <div class="container">
                <a href="#" class="navigation-bar-toggle">
                    <i class="ion-navicon-round"></i>
                    <?php echo listify_get_theme_menu_name( 'tertiary' ); ?>
                </a>
                <div class="navigation-bar-wrapper">
                    <?php echo $menu; ?>
                </div>
            </div>
        </nav><!-- #site-navigation -->
    <?php
        add_filter( 'the_title', 'wc_page_endpoint_title' );
    }

    public function taxonomy_mega_menu( $items, $args ) {
        if ( 'none' == listify_theme_mod( 'nav-megamenu' ) ) {
            return $items;
        }

        if ( 'secondary' != $args->theme_location ) {
            return $items;
        }

        $taxonomy = get_taxonomy( listify_theme_mod( 'nav-megamenu' ) );

        if ( is_wp_error( $taxonomy ) ) {
            return $items;
        }

        global $listify_strings;

        $link = sprintf( 
            '<a href="%s">' . __( 'Browse %s', 'listify' ) . '</a>',
            get_post_type_archive_link( 'job_listing' ), 
            str_replace( $listify_strings->label( 'singular' ) . ' ', '', $taxonomy->labels->name )
        );

        $submenu = wp_list_categories( apply_filters( 'listify_mega_menu_list', array(
            'taxonomy' => $taxonomy->name,
            'hide_empty' => 0,
            'pad_counts' => true,
            'show_count' => true,
            'echo' => false,
            'title_li' => false,
            'depth' => 1,
            'orderby' => 'title',
            'walker' => new Listify_Walker_Category
        ) ) );

        $dropdown = wp_dropdown_categories( apply_filters( 'listify_mega_menu_dropdown', array(
            'show_option_all' => sprintf( __( 'Select a %s', 'listify' ), str_replace( $listify_strings->label( 'singular' ) . ' ', '', $taxonomy->labels->singular_name ) ),
            'taxonomy' => $taxonomy->name,
            'hide_empty' => 0,
            'pad_counts' => true,
            'show_count' => true,
            'echo' => false,
            'title_li' => false,
            'depth' => 1,
            'hierarchical' => true,
            'orderby' => 'title',
            'name' => $taxonomy->name,
            'walker' => new Listify_Walker_Category_Dropdown
        ) ) );

        $submenu =
            '<ul class="sub-menu category-list">' .
                '<form id="job_listing_tax_mobile" action="' . home_url() . '" method="get">' . $dropdown . '</form>
                <div class="container">
                    <div class="mega-category-list-wrapper">' . $submenu . '</div>
                    <!--<a href="' . get_post_type_archive_link( 'job_listing' ) . '">' . __( 'View All', 'listify' ) . '</a>-->
                </div>
            </ul>';

        return '<li id="categories-mega-menu" class="ion-navicon-round menu-item menu-type-link">'. $link . $submenu . '</li>' . $items;
    }
}

$GLOBALS[ 'listify_navigation' ] = new Listify_Navigation();
