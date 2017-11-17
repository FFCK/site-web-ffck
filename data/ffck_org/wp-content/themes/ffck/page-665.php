<?php
//PAGE ORGANISATION FEDERALE

// APPEL DU FICHIER XML DE LA STRUCTURE
$xml = getInstance();

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





    <!-- DEBUT CODE SPECIFIQUE -->
    <div class="category_right_singal">
      <div class="ffck-organisation">
        <?php
        $instances = array();
        foreach ($xml->structures->structure->instances->instance as $instance){
        // constrution d'un tableau key value
          $key = $instance->type;
        // print_r($instance);
          $key = (string)$key;
          $instances[$key] = $instance;
        }
        ?>

        <!-- Affichage du BEx-->

        <?php $instanceBUX = $instances["BUX"]; ?>

        <h4><?php echo $instanceBUX->libelle; ?></h4>
        <p>Le Bureau exécutif administre et gère la Fédération et met en œuvre la politique fédérale validée par l’assemblée générale et contrôlée par le Conseil Fédéral.</p>
        <br>

        <div class="vc_row wpb_row vc_row-fluid">
          <?php foreach ($instanceBUX->fonction as $fonction) : ?>

            <div class="wpb_column vc_column_container vc_col-sm-3">
              <div class="vc_column-inner ">
                <div class="wpb_wrapper">
                  <div class="wpb_single_image wpb_content_element vc_align_center">

                    <figure class="wpb_wrapper vc_figure">
                      <div class="vc_single_image-wrapper vc_box_border_circle  vc_box_border_grey"><img width="150" height="150" src="<?php if($fonction->photo->urlPhoto != "") echo $fonction->photo->urlPhoto;else echo "http://www.ffck.org/wp-content/themes/ffck/images/edf-athlete-vide.png"; ?>" class="vc_single_image-img attachment-thumbnail"></div>
                    </figure>
                  </div>

                  <div class="wpb_text_column wpb_content_element ">
                    <div class="wpb_wrapper">
                      <p style="text-align: center; "><?php echo $fonction->prenom." ".$fonction->nom; ?><br>
                        <b>
                         <?php 
                         if ($fonction->civilite == 'Mme'){
                          switch ($fonction->codeFonction) {
                            case "PR": echo "Présidente"; break;
                            case "TR": echo "Trésorière"; break;
                            case "VP": echo "Vice Présidente"; break;
                            default: echo $fonction->typeFonction;
                          }
                        }
                        else { echo $fonction->typeFonction;}
                        ?>
                      </b>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

        <?php endforeach; ?>
      </div>
      <!-- Fin Affichage du BEx-->

      <!-- Affichage du conseil fédéral-->

      <?php $instanceCF = $instances["NW028"]; ?>
      <h4><?php echo $instanceCF->libelle; ?></h4>
      <p>Le Conseil Fédéral est un organe de surveillance et de contrôle de la bonne gestion de la Fédération.</p>
      <br>

      <div class="vc_row wpb_row vc_row-fluid">
        <?php foreach ($instanceCF->fonction as $fonction) : ?>

          <div class="wpb_column vc_column_container vc_col-sm-3">
            <div class="vc_column-inner ">
              <div class="wpb_wrapper">
                <div class="wpb_single_image wpb_content_element vc_align_center">
                  <figure class="wpb_wrapper vc_figure">
                    <div class="vc_single_image-wrapper vc_box_border_circle  vc_box_border_grey"><img width="150" height="150" src="<?php if($fonction->photo->urlPhoto != "") echo $fonction->photo->urlPhoto;else echo "http://www.ffck.org/wp-content/themes/ffck/images/edf-athlete-vide.png"; ?>" class="vc_single_image-img attachment-thumbnail"></div>
                  </figure>
                </div>

                <div class="wpb_text_column wpb_content_element ">
                  <div class="wpb_wrapper">
                    <p style="text-align: center; min-height: 70px;"><?php echo $fonction->prenom." ".$fonction->nom; ?><br><b>
                      <?php  if ($fonction->typeFonction != 'Membre') echo $fonction->typeFonction; ?></b></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          <?php endforeach; ?>
        </div>
      </div><!-- fin class ffck-organisation -->
      <!-- Fin Affichage du conseil fédéral-->


      <!-- affichage des commissions -->

      <?php 
      $instanceCD1I = $instances["CD1I"]; //Commission de Lutte de contre le Dopage - 1ère Instance
      $instanceCDA = $instances["CDA"]; //Commission de discipline d'appel
      $instanceCDOP = $instances["CDOP"]; //Commission d'appel de lutte contre le Dopage
      $instanceCNCEL = $instances["CNCEL"]; //Commission Nationale de Course en Ligne / Marathon / Paracanoë
      $instanceCNDD = $instances["CNDD"]; //Commission de distinction et de discipline - 1ère instance
      $instanceCNDES = $instances["CNDES"]; //Commission Nationale Descente
      $instanceCNEF = $instances["CNEF"]; //Commission Nationale Enseignement Formation
      $instanceCNKAP = $instances["CNKAP"]; //Commission Nationale Kayak-Polo
      $instanceCNM = $instances["CNM"]; //Commission Nationale Médicale
      $instanceCNMER = $instances["CNMER"]; //Commission Nationale Ocean-Racing / Va'a
      $instanceCNPN = $instances["CNPN"]; //Commission Nationale Patrimoine Nautique
      $instanceCNSLA = $instances["CNSLA"]; //Commission Nationale Slalom
      $instanceCNWAS = $instances["CNWAS"]; //Commission Nationale Freestyle
      $instanceNW055 = $instances["NW055"]; //Commission Nationale Waveski-Surfing
      $instanceNW056 = $instances["NW056"]; //Commission de Surveillance Electorale
      $instanceNW071 = $instances["NW071"]; //Commission Nationale Jeunes
      $instanceNW075 = $instances["NW075"]; //Commission Nationale Dragon-Boat
      $instanceNW077 = $instances["NW077"]; //Commission Nationale des Juges et des Arbitres
      $instanceCOMLOI = $instances["COMLOI"]; //Commission Nationale loisirs

      ?>

      

      <div class="vc_row wpb_row vc_row-fluid">
        <div class="wpb_column vc_column_container vc_col-sm-12">
          <div class="vc_column-inner ">
            <div class="wpb_wrapper">
              <div class="wpb_text_column wpb_content_element ">
                <div class="wpb_wrapper">
                  <h4>Commissions</h4>
                </div>
              </div>
              <div class="vc_tta-container" data-vc-action="collapseAll">
                <div class="vc_general vc_tta vc_tta-accordion vc_tta-color-grey vc_tta-style-modern vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-o-all-clickable">
                  <div class="vc_tta-panels-container">
                    <div class="vc_tta-panels">
                      <div class="vc_tta-panel vc_active" id="1457519498740-4c956b6b-d6a0" data-vc-content=".vc_tta-panel-body">
                        <div class="vc_tta-panel-heading">
                          <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
                            <a href="#1457519498740-4c956b6b-d6a0" data-vc-accordion="" data-vc-container=".vc_tta-container">
                              <span class="vc_tta-title-text">Commissions statutaires</span>
                              <i class="vc_tta-controls-icon vc_tta-controls-icon-chevron"></i>
                            </a>
                          </h4>
                        </div>
                        <div class="vc_tta-panel-body">
                          <?php if($instanceNW056 !=''): ?>
                            <h4><?php echo $instanceNW056->libelle; ?></h4>
                            <p>
                              <?php foreach ($instanceNW056->fonction as $fonction){
                                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                                echo "<br>";
                              }?>
                            </p>
                          <?php endif; ?>

                          <?php if($instanceCNM !=''): ?>
                            <h4><?php echo $instanceCNM->libelle; ?></h4>
                            <p>
                              <?php foreach ($instanceCNM->fonction as $fonction){
                                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                                echo "<br>"; 
                              }?>
                            </p>
                          <?php endif; ?>

                          <?php if($instanceCNDD !=''): ?>
                            <h4><?php echo $instanceCNDD->libelle; ?></h4>
                            <p>
                              <?php foreach ($instanceCNDD->fonction as $fonction){
                                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                                echo "<br>"; 
                              }?>
                            </p>
                          <?php endif; ?>

                          <?php if($instanceCDA !=''): ?>
                            <h4><?php echo $instanceCDA->libelle; ?></h4>
                            <p>
                              <?php foreach ($instanceCDA->fonction as $fonction){
                                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                                echo "<br>"; 
                              }?>
                            </p>
                          <?php endif; ?>


                          <?php if($instanceNW077 !=''): ?>
                            <h4><?php echo $instanceNW077->libelle; ?></h4>
                            <p>
                              <?php foreach ($instanceNW077->fonction as $fonction){
                                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                                echo "<br>"; 
                              }?>
                            </p>
                          <?php endif; ?>

                          <?php if($instanceCD1I !=''): ?>
                            <h4><?php echo $instanceCD1I->libelle; ?></h4>
                            <p>
                              <?php foreach ($instanceCD1I->fonction as $fonction){
                                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                                echo "<br>"; 
                              }?>
                            </p>
                          <?php endif; ?>

                          <?php if($instanceCDOP !=''): ?>
                            <h4><?php echo $instanceCDOP->libelle; ?></h4>
                            <p>
                              <?php foreach ($instanceCDOP->fonction as $fonction){
                                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                                echo "<br>"; 
                              }?>
                            </p>
                          <?php endif; ?>

                        </div>
                      </div>
                      <div class="vc_tta-panel" id="1456133280414-73089b62-1b9f" data-vc-content=".vc_tta-panel-body">
                        <div class="vc_tta-panel-heading">
                          <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
                            <a href="#1456133280414-73089b62-1b9f" data-vc-accordion="" data-vc-container=".vc_tta-container">
                              <span class="vc_tta-title-text">Commissions nationales d'activité</span>
                              <i class="vc_tta-controls-icon vc_tta-controls-icon-chevron"></i>
                            </a>
                          </h4>
                        </div>
                        <div class="vc_tta-panel-body">
                          <h4><?php echo $instanceCNCEL->libelle; ?></h4>
                          <p><?php foreach ($instanceCNCEL->fonction as $fonction)
                          {
                            echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                            if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                            echo "<br>";
                          }?>
                        </p>

                        <h4><?php echo $instanceNW075->libelle; ?></h4>
                        <p><?php foreach ($instanceNW075->fonction as $fonction)
                        {
                         echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                         if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                         echo "<br>";
                       }?>
                     </p>

                     <h4><?php echo $instanceCNKAP->libelle; ?></h4>
                     <p><?php foreach ($instanceCNKAP->fonction as $fonction)
                     {
                      echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                      if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                      echo "<br>";
                    }?>
                  </p>

                  <h4><?php echo $instanceCNDES->libelle; ?></h4>
                  <p><?php foreach ($instanceCNDES->fonction as $fonction)
                  {
                    echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                    if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                    echo "<br>";
                  }?>
                </p>

                <h4><?php echo $instanceCNMER->libelle; ?></h4>
                <p><?php foreach ($instanceCNMER->fonction as $fonction)
                {
                  echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                  if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                  echo "<br>";
                }?>
              </p>

              <h4><?php echo $instanceCNSLA->libelle; ?></h4>
              <p><?php foreach ($instanceCNSLA->fonction as $fonction)
              {
                echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
                if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
                echo "<br>";
              }?>
            </p>

            <h4><?php echo $instanceCNWAS->libelle; ?></h4>
            <p><?php foreach ($instanceCNWAS->fonction as $fonction)
            {
              echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
              if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
              echo "<br>";
            }?>
          </p>

          <h4><?php echo $instanceNW055->libelle; ?></h4>
          <p><?php foreach ($instanceNW055->fonction as $fonction)
          {
            echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
            if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
            echo "<br>";
          }?>
        </p>

      </div>
    </div>
    <div class="vc_tta-panel" id="1456133280492-64844a51-6b5c" data-vc-content=".vc_tta-panel-body">
      <div class="vc_tta-panel-heading">
        <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
          <a href="#1456133280492-64844a51-6b5c" data-vc-accordion="" data-vc-container=".vc_tta-container">
            <span class="vc_tta-title-text">Autres commissions nationales</span>
            <i class="vc_tta-controls-icon vc_tta-controls-icon-chevron"></i>
          </a>
        </h4>
      </div>

      <div class="vc_tta-panel-body">

        <?php if($instanceCOMLOI !=''): ?>
          <h4><?php echo $instanceCOMLOI->libelle; ?></h4>
          <p>
            <?php foreach ($instanceCOMLOI->fonction as $fonction){
              echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
              if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
              echo "<br>"; 
            }?>
          </p>
        <?php endif; ?>

        <h4><?php echo $instanceNW071->libelle; ?></h4>
        <p><?php foreach ($instanceNW071->fonction as $fonction)
        {
          echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
          if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
          echo "<br>";
        }?>
      </p>

      <h4><?php echo $instanceCNEF->libelle; ?></h4>
      <p><?php foreach ($instanceCNEF->fonction as $fonction)
      {
       echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
       if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
       echo "<br>";
     }?>
   </p>

   <h4><?php echo $instanceCNPN->libelle; ?></h4>
   <p><?php foreach ($instanceCNPN->fonction as $fonction)
   {
     echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom; 
     if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction; 
     echo "<br>";
   }?>
 </p>

</div>

</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- fin affichage commissions -->
<?php the_content(); ?>

<!-- affichage des Comités -->



<?php $comitesRegionaux =  getStructures(0); ?>



<div class="vc_row wpb_row vc_row-fluid">
  <div class="wpb_column vc_column_container vc_col-sm-12">
    <div class="vc_column-inner ">
      <div class="wpb_wrapper">
        <div class="wpb_text_column wpb_content_element ">
          <div class="wpb_wrapper">
            <h4>Comités régionaux et départementaux</h4>
          </div>
        </div>
        <div class="vc_tta-container" data-vc-action="collapseAll">
          <div class="vc_general vc_tta vc_tta-accordion vc_tta-color-grey vc_tta-style-modern vc_tta-shape-rounded vc_tta-o-shape-group vc_tta-controls-align-left vc_tta-o-all-clickable">
            <div class="vc_tta-panels-container">
              <div class="vc_tta-panels">
                <?php foreach ($comitesRegionaux->structures->structure as $crck):  ?> 


                  <?php if($crck->etat == 'Actif' && $crck->code != 99) : ?>

                   <?php 
                   $etat = $crck->etat;
                   $code = $crck->code;
                   $nom = $crck->nom;
                   $urlSiteWeb = $crck->siteWeb;
           $siteWeb = substr($urlSiteWeb,7); //explode(" / ", )[1];
           $adresseComplete = "";
           if ($crck->adresseCorrespondance->numero != '') $adresseComplete .= $crck->adresseCorrespondance->numero . ' ';
           if ($crck->adresseCorrespondance->typeVoie != '') $adresseComplete .= $crck->adresseCorrespondance->typeVoie . ' ';
           if ($crck->adresseCorrespondance->nomVoie != '') $adresseComplete .= $crck->adresseCorrespondance->nomVoie . '<br>';
           if ($crck->adresseCorrespondance->lieuDit != '') $adresseComplete .= $crck->adresseCorrespondance->lieuDit . '<br>';
           if ($crck->adresseCorrespondance->codePostal != '') $adresseComplete .= $crck->adresseCorrespondance->codePostal . ', ' . $crck->adresseCorrespondance->ville . '<br>';
           $telephone1 = $crck->adresseCorrespondance->telephone1;
           $mobile1 = $crck->adresseCorrespondance->mobile1;
           $email = $crck->adresseCorrespondance->email;
           $longitude = $crck->adresseCorrespondance->longitude;
           $latitude = $crck->adresseCorrespondance->latitude;
           $comitesDepartementaux = getStructures($code);
           ?>

           <div class="vc_tta-panel" id="<?php echo $code; ?>" data-vc-content=".vc_tta-panel-body">
            <div class="vc_tta-panel-heading">
              <h4 class="vc_tta-panel-title vc_tta-controls-icon-position-left">
                <a href="#<?php echo $code; ?>" data-vc-accordion="" data-vc-container=".vc_tta-container">
                  <span class="vc_tta-title-text"><?php echo $nom; ?></span>
                  <i class="vc_tta-controls-icon vc_tta-controls-icon-chevron">
                  </i>
                </a>
              </h4>
            </div>
            <div class="vc_tta-panel-body">

              <div class="wpb_text_column wpb_content_element ">
                <div class="wpb_wrapper">
                  <div class="row">
                    <div class="col-md-6">
                      <h5>Contact</h5>
                      <?php if($telephone1 != ''): ?><p><i class="material-icons small">phone</i> <?php echo $telephone1; ?></p> <?php endif; ?>
                      <?php if($mobile1 != ''): ?><p><i class="material-icons small">phone</i> <?php echo $mobile1; ?></p> <?php endif; ?>
                      <?php if($email != ''): ?><p><i class="material-icons small">mail</i><a href="mailto:<?php  echo $email ?>"> <?php echo $email; ?></a></p> <?php endif; ?>
                      <?php if($urlSiteWeb != ''): ?><p><a href="<?php echo $urlSiteWeb; ?>"><?php echo $siteWeb; ?></a></p><?php endif; ?>
                      
                    </div>
                    <div class="col-md-6">
                      <h5>Adresse</h5>
                      <p><?php echo $adresseComplete; ?></p>
                    </div>
                  </div>



                </div>
              </div>
              <h5>Comités départementaux</h5>
              <?php foreach ($comitesDepartementaux->structures->structure as $cdck):  ?>
                <?php if($cdck->etat == 'Actif') : ?>
                  <?php  
                  $etatCdck = $cdck->etat;
                  $codeCdck = $cdck->code;
                  $nomCdck = $cdck->nom;
                  $urlSiteWebCdck = $cdck->siteWeb;
                  $siteWebCdck = substr($urlSiteWebCdck,7);
                  $adresseCompleteCdck = "";
                  if ($cdck->adresseCorrespondance->numero != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->numero . ' ';
                  if ($cdck->adresseCorrespondance->typeVoie != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->typeVoie . ' ';
                  if ($cdck->adresseCorrespondance->nomVoie != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->nomVoie . '<br>';
                  if ($cdck->adresseCorrespondance->lieuDit != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->lieuDit . '<br>';
                  if ($cdck->adresseCorrespondance->codePostal != '') $adresseCompleteCdck .= $cdck->adresseCorrespondance->codePostal . ', ' . $cdck->adresseCorrespondance->ville . '<br>';
                  $telephone1Cdck = $cdck->adresseCorrespondance->telephone1;
                  $mobile1Cdck = $cdck->adresseCorrespondance->mobile1;
                  $emailCdck = $cdck->adresseCorrespondance->email;
                  $longitudeCdck = $cdck->adresseCorrespondance->longitude;
                  $latitudeCdck = $cdck->adresseCorrespondance->latitude;
                  ?>

                  <div id="<?php echo $codeCdck; ?>" class="vc_toggle vc_toggle_default vc_toggle_color_default  vc_toggle_size_md">
                    <div class="vc_toggle_title">
                      <h4><?php echo $nomCdck; ?></h4>
                      <i class="vc_toggle_icon">
                      </i>
                    </div>
                    <div class="vc_toggle_content">
                      <div class="row">
                        <div class="col-md-6">
                          <h5>Contact</h5>
                          <?php if($telephone1Cdck != ''): ?><p><i class="material-icons small">phone</i> <?php echo $telephone1Cdck; ?></p> <?php endif; ?>
                          <?php if($mobile1Cdck != ''): ?><p><i class="material-icons small">phone</i> <?php echo $mobile1Cdck; ?></p> <?php endif; ?>
                          <?php if($emailCdck != ''): ?><p><i class="material-icons small">mail</i><a href="mailto:<?php  echo $emailCdck ?>"> <?php echo $emailCdck; ?></a></p> <?php endif; ?>
                          <?php if($urlSiteWebCdck != ''): ?><p><a href="<?php echo $urlSiteWebCdck; ?>"><?php echo $siteWebCdck; ?></a></p><?php endif; ?>

                        </div>
                        <div class="col-md-6">
                          <h5>Adresse</h5>
                          <p><?php echo $adresseCompleteCdck; ?></p>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php endif ?>
              <?php endforeach; ?>
            </div>
          </div>


        <?php endif ?>

      <?php endforeach; ?>
    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
</div>

<!-- fin affichage des comités -->


</div>

<?php endwhile; ?>

</div>

</div>

</div>
</div>
</div>
</div>
</div>
</section>

<script type="text/javascript" src="<?php echo plugins_url(); ?>/js_composer/assets/lib/vc_accordion/vc-accordion.min.js?ver=4.9"></script>

<?php get_footer();