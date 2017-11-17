<?php
/**
* Template Name: Précalendrier
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/

$saison = get_field( "precal_saison" );
$activite = get_field( "precal_activite" );
$niveau = null;
if (isset($_GET['niveau'])) $niveau= $_GET['niveau'];


$precalendrier = getPreCalendrier($saison, $activite, $niveau);
//echo "<pre>" . print_r($precalendrier) . "</pre>";

get_header(); ?>

<!--Main Banner-->
<div class="banner_wapper master-slider">
	<div class="slider_image">
		<?php
		$slidershortcode=get_field('shortcode');
		echo do_shortcode($slidershortcode); ?>
	</div>
</div>
<!--End Main Banner-->

<?php get_sidebar(); ?>

<div class="col-md-8 col-lg-9" >

	<div class="category_right masterpage">

		<div class="inner_image">
			<?php while ( have_posts() ) : the_post();
			$image_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_id()) );
			?>
		</div>

		<div class="vc_row wpb_row vc_row-fluid vc_custom_1455897898249">
			<div class="wpb_column vc_column_container vc_col-sm-12">
				<div class="vc_column-inner vc_custom_1455897905691">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element  vc_custom_1455897913967">
							<div class="wpb_wrapper">
								<h2><?php the_title(); ?></h2>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php the_content(); ?>

		<!-- DEBUT CONTENU SPECIFIQUE -->

		<!-- LES POINTS A VOIR 

			- Quelles div doit-on mettre pour englober le tableau ? 
			- Ajouter un sélecteur de niveau en JS
			- Ajouter les tri par colonne en JS
			- Au chargement initialiser le tri sur la date
			- Ajouter un Etat permettant de télecharger le résultat en PDF (programme à développer sur compet.ffck.org)

		-->

		<!-- Formulaire de filtrage par niveau -->
		<div class="tab-filters">
			<div class="select">
				<form action="" method="get" role="form">
					<select id="niveau" class="filter-button">
						<option value="hide">Niveau</option>
						<option value="00">Tous</option>
						<option value="INR">Interrégional</option>
						<option value="NAT">National</option>
						<option value="INT">International</option>
					</select>
				</form>
			</div>
		</div>

		<!-- Tableau des résultats -->
		<div class="wpb_column vc_column_container vc_col-sm-12">
			<div class="vc_column-inner ">
				<div class="wpb_wrapper">
					<div class="wpb_text_column wpb_content_element ">
						<div class="wpb_wrapper">
							<table class="tabel_defult filter-wrapper tablesorter" cellspacing="0" cellpadding="0">
								<thead>
									<tr class="title">
										<th style="width:24%;">Niveau</th>
										<th style="width:50%;">Evènement</th>
										<th style="width:25%;">Dates</th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($precalendrier as $evenement): ?>


										<?php

										$arrEvenement = array();
										$arrEvenement['niveau'] = $evenement['libelleNiveau'];
										$arrEvenement['codeNiveau'] = $evenement['codeNiveau'];
										$arrEvenement['codeEvenement'] = $evenement['codeEvenement'];
										$arrEvenement['evenementLibelle'] = $evenement['libelleEvenement'];
										$arrEvenement['dateDebut'] = DateTime::createFromFormat('d/m/Y', $evenement['dateDebut']);
										$arrEvenement['dateFin'] = DateTime::createFromFormat('d/m/Y', $evenement['dateFin']);
										$arrEvenement['dateDebut'] = new DateTimeFrench($arrEvenement['dateDebut']->format('d-m-Y'), $DTZ);
										$arrEvenement['dateFin'] = new DateTimeFrench($arrEvenement['dateFin']->format('d-m-Y'), $DTZ);

											// chargement du tableau
										$GLOBALS['precalendrier'] = $arrEvenement;

											//utilisation du tableau dans le script de récupération
											// $arrEvt = array();
											// $arrEvt = $GLOBALS['precalendrier'];
											// $arrEvt['niveau'];

										?>


										<tr class="filter-elmt filter-elmt-<?php echo $arrEvenement['codeNiveau']; ?>">
											<td style="width:24%;"><?php echo $arrEvenement['niveau']; ?></td>
											<td style="width:50%;"><?php echo $arrEvenement['evenementLibelle']; ?></td>
											<td style="width:25%;">
												<?php 

												if($arrEvenement['dateDebut'] == $arrEvenement['dateFin'])
												{
													echo $arrEvenement['dateFin']->format('j F Y');
												}
												elseif($arrEvenement['dateDebut']->format('m') == $arrEvenement['dateFin']->format('m'))
												{
													echo $arrEvenement['dateDebut']->format('j') . " au " . $arrEvenement['dateFin']->format('j F Y');
												}
												else
												{
													echo $arrEvenement['dateDebut']->format('j F') . " au " . $arrEvenement['dateFin']->format('j F Y');
												}


												?>

											</td>  
										</tr>

									<?php endforeach; ?>


								</tbody>
							</table>

						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- FIN CONTENU SPECIFIQUE -->

	<?php endwhile; ?>

</div>

</div>

</div>
</div>
</div>
</div>
</div>
</section>


<?php get_footer();