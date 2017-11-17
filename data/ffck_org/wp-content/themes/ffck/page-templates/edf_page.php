<?php
// error_reporting(E_ALL); ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: http://ffck-goal-prp.multimediabs.com/externe/Galerie/getPhoto');
header('Access-Control-Allow-Origin: http://ffck-goal-prp.multimediabs.com/externe/Galerie/getPhoto');


/**
 * Template Name: equipe-de-france
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */
get_header(); ?>
<!--Main Banner-->
<div class="banner_wapper master-slider">
    <div class="slider_image"><!--img src="<?php echo get_template_directory_uri(); ?>/images/slider.png" alt=""-->
        <?php
        $slidershortcode=get_field('shortcode');
        echo do_shortcode($slidershortcode); ?>
    </div>
</div>
<!--End Main Banner-->
<?php get_sidebar(); ?>
<!-- right -->
<div class="col-md-8 col-lg-9" >

 <div class="category_right masterpage">
     <div class="inner_image">
       <?php while ( have_posts() ) : the_post();
       $image_url = wp_get_attachment_url( get_post_thumbnail_id(get_the_id()) );
      ?>
  </div>
  <div class="vc_row wpb_row vc_row-fluid vc_custom_1455897898249"><div class="wpb_column vc_column_container vc_col-sm-12"><div class="vc_column-inner vc_custom_1455897905691"><div class="wpb_wrapper">
  <div class="wpb_text_column wpb_content_element  vc_custom_1455897913967">
    <div class="wpb_wrapper">
      <h2><?php the_title(); ?></h2>
    </div>
  </div>
</div></div></div></div>
  <?php

    function age($date_naissance) {
      $am = explode('/', $date_naissance);
      $an = explode('/', date('d/m/Y'));
      if(($am[1] < $an[1]) || (($am[1] == $an[1]) && ($am[0] <= $an[0])))
        return $an[2] - $am[2];
      return $an[2] - $am[2] - 1;
    }

    $saison = get_field( "edf_saison" );
    $discipline = get_field( "edf_discipline" );
    $collectif = get_field( "edf_collectif" );

    if (isset($_GET['discipline'])) { $discipline = $_GET['discipline']; }
    if (isset($_GET['collectif'])) { $collectif = $_GET['collectif']; }

    $xml = getAthletes($saison, $discipline, $collectif);
    // echo $url;

    // print_r($xml);

    echo '<div class="row">';

    foreach ($xml->athletes->athlete as $athlete) {

  ?>
    <div class="col-xs-12 col-sm-6 col-md-4">
      <div class="card hovercard">
        <div class="cardheader"></div>
        <div class="avatar" style="background-image:url('<?php if ($athlete->photo->autorisationDiffusion == "Oui") { echo str_replace('https', 'http', $athlete->photo->urlPhoto); } else { echo get_template_directory_uri() . '/images/edf-athlete-vide.png'; } ?>'); background-size:112%; background-position: center -5px; background-repeat:no-repeat;">
          <!-- <img alt="" src=""> -->
        </div>
        <div class="info">
          <div class="title">
            <a href="#" data-featherlight="#opencard-<?php echo $athlete->codeAdherent; ?>" data-featherlight-variant="fixwidth"><?php echo $athlete->prenom . ' <span class="nom">' . $athlete->nom . '</span>'; ?></a>
          </div>
          <!-- <div class="desc profession"><?php echo $athlete->profession ?></div> -->
          <div class="desc discipline"><?php echo $athlete->libelleDiscipline ?> - <span><?php echo $athlete->collectif ?></span></div>
          <!-- <div class="desc age"><?php $age = age($athlete->dateNaissance); echo $age; ?>&nbsp;ans</div> -->
          <div class="desc age"><?php $str = explode("-", $athlete->clubLicence); echo $str[1]; ?></div>
          <div class="desc collectif"></div>
        </div>
        <div class="bottom">
          <?php if($athlete->twitter != ""): ?>
            <a class="btn btn-primary btn-twitter btn-sm" href="https://twitter.com/<?php echo $athlete->twitter ?>" title="Accéder au Twitter de l'athlète" target="_blank"><i class="fa fa-twitter"></i></a>
          <?php endif; ?>
          <?php if($athlete->facebook != ""): ?>
            <a class="btn btn-primary btn-twitter btn-sm" rel="publisher" href="https://www.facebook.com/<?php echo $athlete->facebook ?>" title="Accéder au Facebook de l'athlète" target="_blank"><i class="fa fa-facebook"></i></a>
          <?php endif; ?>
          <?php if($athlete->instagram != ""): ?>
            <a class="btn btn-primary btn-twitter btn-sm" rel="publisher" href="https://www.instagram.com/<?php echo $athlete->instagram ?>" title="Accéder à l'Instagram de l'athlète" target="_blank"><i class="fa fa-instagram"></i></a>
          <?php endif; ?>
          <?php if($athlete->ffcktv != ""): ?>
            <a href="#" data-featherlight="#opencard-<?php echo $athlete->ffcktv ?>" data-featherlight-variant="video" title="Voir une vidéo de l'athlète" class="btn btn-primary btn-twitter btn-sm"><i class="fa fa-play"></i></a>
            <iframe class="popupfl" id="opencard-<?php echo $athlete->ffcktv ?>" frameborder="0" width="100%" height="480" src="//www.dailymotion.com/embed/video/<?php echo $athlete->ffcktv ?>" allowfullscreen=""></iframe>
          <?php endif; ?>
          <?php if($athlete->sitePerso != ""): ?>
            <a class="btn btn-primary btn-twitter btn-sm" href="http://<?php echo $athlete->sitePerso ?>" title="Accéder au site de l'athlète" target="_blank"><i class="fa fa-globe"></i></a>
          <?php endif; ?>
          <?php if($athlete->galerie->photo->urlPhoto != ""): ?>
            <a data-gallery="#gallery-<?php echo $athlete->codeAdherent; ?>" class="opengallery btn btn-primary btn-twitter btn-sm" href="#" title="Voir les photos de l'athlète" target="_blank"><i class="fa fa-picture-o"></i></a>
          <?php endif; ?>
        </div>
        <div class="open-gallery" id="gallery-<?php echo $athlete->codeAdherent; ?>">
          <?php $countt = 0; foreach ($athlete->galerie->photo as $photoac): ?>
            <?php $countt++; ?>
            <img class="slide <?php if($countt==1) echo 'active' ?>" src="<?php echo str_replace('https', 'http', $photoac->urlPhoto); ?>">
          <?php endforeach; ?>
          <i id="slider-left" class="fa fa-chevron-left"></i>
          <i id="slider-right" class="fa fa-chevron-right"></i>
        </div>
        <div id="opencard-<?php echo $athlete->codeAdherent; ?>" class="openedcard">
          <h2><?php echo $athlete->prenom . ' <span class="nom">' . $athlete->nom . '</span>'; ?> <small>- <?php $age = age($athlete->dateNaissance); echo $age; ?>&nbsp;ans</small><a href="#" class="athlete-pdf" onclick="javascript:demoFromHTML('#opencard-<?php echo $athlete->codeAdherent; ?>');"><i class="fa fa-file-pdf-o"></i></a></h2>
          <div class="opencard-wrapper">
            <div class="discipline">
              <?php echo $athlete->libelleDiscipline; ?> - <span><?php echo $athlete->collectif; ?> <?php echo $athlete->saison; ?></span>
            </div>

            <?php
              $xml2 = getAthleteDetail($athlete->codeAdherent);

              foreach ($xml2->selectionsEQF->selectionEQF as $selectionEqf) { ?>

              <?php
                $counter1 = 0;
                $counter2 = 0;
                $embarcations = "";
                $equipiers = "";
                if ($selectionEqf->saison == '2016' && $selectionEqf->collectif == 'Olympique') {
                  foreach ($selectionEqf->embarcations->embarcation as $emb) {
                    if($counter1 >= 1) {
                      $embarcations .= ', ' . $emb;
                    } else {
                      $embarcations .= $emb;
                    }
                    $counter1++;
                  }
                  foreach ($selectionEqf->equipiers->equipier as $equip) {
                    $str = explode("-", $equip);
                    if($counter2 >= 1) {
                      $equipiers .= ', ' . $str[1];
                    } else {
                      $equipiers .= $str[1];
                    }
                    $counter2++;
                  }
              ?>
              <div class="athlete-infos">
                <?php if ($embarcations != ""): ?>Embarcation(s) : <strong><?php echo $embarcations; ?></strong><br><?php endif; ?>
                <?php if ($equipiers != ""): ?>Equipier(s) : <strong><?php echo $equipiers; ?></strong><?php endif; ?>
              </div>
              <?php } ?>
            <?php } ?>

            <h3>
              <i class="fa fa-user"></i>&nbsp;&nbsp;L'athlète
            </h3>
            <div class="athlete-infos">
              Taille : <strong><?php echo $athlete->taille; ?> cm</strong> - Poids : <strong><?php echo $athlete->poids; ?> Kg</strong>
            </div>
            <div class="enc licence">
              Début de la pratique à <strong><?php $ddn = DateTime::createFromFormat('d/m/Y', $athlete->dateNaissance); $dpl = DateTime::createFromFormat('d/m/Y', $athlete->datePremiereLicence); $dpa = $dpl->format('Y') - $ddn->format('Y'); echo $dpa; ?> ans</strong>
            </div>
            <?php if ($athlete->portrait != ""): ?>
            <div class="quoting">
              <span class="quote quote-left">«</span><?php echo $athlete->portrait; ?><span class="quote quote-right">»</span>
            </div>
            <?php endif; ?>
            <h3>
              <i class="fa fa-home"></i>&nbsp;&nbsp;L'encadrement
            </h3>
            <?php if ($athlete->entraineur != ""): ?>
            <div class="enc entraineur1">
              Entraineur : <strong><?php $str = explode("-", $athlete->entraineur); echo $str[1]; ?></strong>
            </div>
            <?php endif; ?>
            <?php if ($athlete->entraineurNational != ""): ?>
              <div class="enc entraineur2">
                Entraineur National : <strong><?php $str = explode("-", $athlete->entraineurNational); echo $str[1]; ?></strong>
              </div>
            <?php endif; ?>
            <?php if ($athlete->structureEntrainement != ""): ?>
              <div class="enc structure">
                Structure : <strong><?php $str = explode("-", $athlete->structureEntrainement); echo $str[1]; ?></strong>
              </div>
            <?php endif; ?>
            <?php if ($athlete->clubLicence != ""): ?>
              <div class="enc club">
                Club : <strong><?php echo substr($athlete->clubLicence, 7); ?></strong>
              </div>
            <?php endif; ?>
            <h3>
              <i class="fa fa-trophy"></i>&nbsp;&nbsp;Le palmarès
            </h3>
            <div class="palmares">
              <pre><?php echo $athlete->palmares; ?></pre>
            </div>
            <!-- [embarcations] => SimpleXMLElement Object ( )
            [equipiers] => SimpleXMLElement Object ( )
            [resultat] => SimpleXMLElement Object ( )
            [situationFamille] => SimpleXMLElement Object ( )  -->
          </div>
        </div>
      </div>
    </div>

    <?php // $categories = $athlete->regions->region->categories->categorie;
    // while ($categorie = current($categories)) {
    //     echo $categorie;
    //     echo next($categories) ? ', ' : null;
    // }

    // echo '<p>' . $athlete->countries->country . '</p>'; ?>

  <?php
    }
    echo "</div>";

    the_content();
    endwhile;
  ?>
</div>
</div>
<!-- right -->
</div>
</div>
</div>
</div>
</div>
<!-- inner contain -->
<!-- actus_wapper mobile -->
</section>

<?php

get_footer();
