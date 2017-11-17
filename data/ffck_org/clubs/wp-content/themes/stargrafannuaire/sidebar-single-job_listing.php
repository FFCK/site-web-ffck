<?php
/**
 * The Sidebar for single listing items.
 *
 * @package Listify
 */

$defaults = array(
	'before_widget' => '<aside class="widget widget-job_listing">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h3 class="widget-title widget-title-job_listing %s">',
	'after_title'   => '</h3>',
	'widget_id'     => ''
);
?>
	<div id="secondary" class="widget-area col-md-4 col-sm-5 col-xs-12" role="complementary">

    <div class="ecole-label">
      <?php
        if (strpos(get_post_custom_values('categorie_structure')[0], 'EFCK') !== false) {
          echo '<img src="' . get_template_directory_uri() . '/images/logo-efck-medium.png" alt="Label EFCK" >';
        }
        if (strpos(get_post_custom_values('categorie_structure')[0], 'PES1') !== false) {
          echo '<a href="#" class="tagg">Performance sportive</a>';
        }
      ?>
    </div>

    <div class="social-network">
      <?php
        if (get_post_custom_values('facebook_url')[0] != '') {
          echo '<a href="' . get_post_custom_values('facebook_url')[0] . '" title="Facebook" target="_blank"><span class="social-fb"><span class="ion-social-facebook"></span></span> Voir notre page Facebook</a>';
        }
      ?>
    </div>

    <?php

      the_widget(
        'Listify_Widget_Listing_Tags',
        array(
          'title' => __( 'Accueil des personnes en situation de handicap', 'listify' ),
          'icon'  => ''
        ),
        wp_parse_args( array(
          'before_widget' => '<aside class="widget widget-job_listing listify_widget_panel_listing_tags">',
        ), $defaults )
      );

    ?>
		<?php // if ( ! dynamic_sidebar( 'single-job_listing' ) ) : ?>

			<?php
				global $listify_strings;

				the_widget(
					'Listify_Widget_Listing_Gallery',
					array(
						'title' => __( 'Photo Gallery', 'listify' ),
						'icon'  => 'android-camera',
						'limit' => 8
					),
					wp_parse_args( array(
						'before_widget' => '<aside class="widget widget-job_listing listify_widget_panel_listing_gallery">',
					), $defaults )
				);

			?>

		<?php // endif; ?>

		<aside id="listify_widget_panel_listing_gallery-1" class="widget widget-job_listing listify_widget_panel_listing_gallery">
			<h1 class="widget-title widget-title-job_listing ion-android-time"><a class="image-gallery-link">Horaires</a></h1>
			<?php
				if (get_post_custom_values('informations_horaires')[0] != '') {
					echo get_post_custom_values('informations_horaires')[0];
				}
				else {
					echo "Aucun horaire trouvé pour ce club.";
				}
			?>
		</aside>

    <aside id="listify_widget_panel_listing_gallery-1" class="widget widget-job_listing listify_widget_panel_listing_gallery">
      <h1 class="widget-title widget-title-nop widget-title-job_listing"><a class="image-gallery-link">Prestations</a></h1>
      <?php
        if (get_post_custom_values('prestations_structure')[0] != '') {
          $html = get_post_custom_values('prestations_structure')[0];
          $html = str_replace("ECOLE_PJ", "- Ecole de pagaie jeune<br>", $html);
          $html = str_replace("ECOLE_PA", "- Ecole de pagaie adulte<br>", $html);
          $html = str_replace("ECOLE_COMPET", "- Ecole de compétition<br>", $html);
          $html = str_replace("SORTIE", "- Sorties encadrées<br>", $html);
          $html = str_replace("LOCATION", "- Location<br>", $html);
          $html = str_replace("ACCUEIL", "- Accueil de groupes<br>", $html);
          $html = str_replace(",", " ", $html);
          echo $html;
        }
        else {
          echo "Aucune prestation trouvée pour ce club.";
        }
      ?>
    </aside>

		<aside id="listify_widget_panel_listing_gallery-1" class="widget widget-job_listing listify_widget_panel_listing_gallery">
			<!-- <h1 class="widget-title widget-title-job_listing ion-android-folder-open"><a class="image-gallery-link">Documents</a></h1> -->
			<?php
				if (get_post_custom_values('plaquette_promotionnelle_structure')[0] != '') {
					echo '<a class="button" href="' . get_post_custom_values('plaquette_promotionnelle_structure')[0] . '" title="Télécharger la plaquette promotionnelle">Plaquette promotionnelle</a>';
				}
			?>
		</aside>

	</div><!-- #secondary -->
