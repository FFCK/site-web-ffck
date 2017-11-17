<?php
/**
 * The template for displaying job listings (in a loop).
 *
 * @package Listify
 */
?>

<?php
$imageUrl = "";
if (get_post_custom_values('logo_structure')[0] != ''){
  $imageUrl = get_post_custom_values('logo_structure')[0];
}
?>

<li id="job_listing-<?php the_ID(); ?>" <?php job_listing_class(); ?> <?php echo apply_filters(
'listify_job_listing_data', '', false ); ?>>

	<div class="content-box">

		<a href="<?php the_permalink(); ?>" class="job_listing-clickbox"></a>

		<header <?php echo apply_filters( 'listify_cover', 'job_listing-entry-header listing-cover' ); ?>>
            <?php do_action( 'listify_content_job_listing_header_before' ); ?>

			<div class="job_listing-entry-header-wrapper cover-wrapper">

				<div class="job_listing-entry-thumbnail">
          <div style="background-image: url(<?php echo $imageUrl; ?>);" class="list-cover <?php if($imageUrl != "") { echo "has-image"; } else { echo "no-image"; } ?>"></div>
					<!-- <div <?php echo apply_filters( 'listify_cover', 'list-cover' ); ?>></div> -->
				</div>
				<div class="job_listing-entry-meta">
          <?php
            if (strpos(get_post_custom_values('categorie_structure')[0], 'EFCK') !== false) {
    					echo '<div style="margin-bottom:5px"><img src="' . get_template_directory_uri() . '/images/logo-efck-small.png" alt="Label EFCK" style="width:50px; height: auto;"></div>';
    				}
    			?>
					<?php do_action( 'listify_content_job_listing_meta' ); ?>
				</div>

			</div>

            <?php do_action( 'listify_content_job_listing_header_after' ); ?>
		</header><!-- .entry-header -->

		<footer class="job_listing-entry-footer">

			<?php do_action( 'listify_content_job_listing_footer' ); ?>

		</footer><!-- .entry-footer -->

	</div>
</li><!-- #post-## -->
