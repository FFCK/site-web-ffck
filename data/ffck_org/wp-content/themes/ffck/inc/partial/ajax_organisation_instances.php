<?php
/* TODO: trouver une solution pour appeler le fichier ws-config.php */
header('Access-Control-Allow-Origin: http://ffck-goal.multimediabs.com/');
header('Access-Control-Allow-Origin: http://ffck-goal-prp.multimediabs.com/');
function simplexml_load_file_from_url($url, $timeout = 4){
  $opts = array(
    'http' => array(
      'timeout' => (int)$timeout
      )
    );
  $context = stream_context_create($opts);
  $data = file_get_contents($url, false, $context);
  // print_r($data);
  if(!$data){
    echo 'Délai d\'attente dépassé : les données n\'ont pas pu être chargées.';
    trigger_error('Cannot load data from url: ' . $url, E_USER_NOTICE);
    return false;
  }
  return simplexml_load_string($data);
}
function getInstance() {
  global $wsUrl;
  $wsEndpoint = "http://" . getenv("OBS_USER") . ":" . getenv("OBS_PASSWORD") . "@" . getenv("OBS_HOST") . "/wsprivate";
  $url = $wsEndpoint . "/structures/annuaire?codeStructure=0";
  $xml = simplexml_load_file_from_url($url);
  // echo '<p>' . $url . '</p>';
  return $xml;
}
?>
<!-- fin du contenu en provenance de ws-config -->




<div class="ffck-organisation">
  <?php
  // APPEL DU FICHIER XML DE LA STRUCTURE
  $xml = getInstance();
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
if(isset($instances["CD1I"])) $instanceCD1I = $instances["CD1I"]; //Commission de Lutte de contre le Dopage - 1ère Instance
if(isset($instances["CDA"])) $instanceCDA = $instances["CDA"]; //Commission de discipline d'appel
if(isset($instances["CDOP"])) $instanceCDOP = $instances["CDOP"]; //Commission d'appel de lutte contre le Dopage
if(isset($instances["CNCEL"]))  $instanceCNCEL = $instances["CNCEL"]; //Commission Nationale de Course en Ligne / Marathon / Paracanoë
if(isset($instances["CNDD"]))  $instanceCNDD = $instances["CNDD"]; //Commission de distinction et de discipline - 1ère instance
if(isset($instances["CNDES"]))  $instanceCNDES = $instances["CNDES"]; //Commission Nationale Descente
if(isset($instances["CNEF"]))  $instanceCNEF = $instances["CNEF"]; //Commission Nationale Enseignement Formation
if(isset($instances["CNKAP"]))  $instanceCNKAP = $instances["CNKAP"]; //Commission Nationale Kayak-Polo
if(isset($instances["CNM"]))  $instanceCNM = $instances["CNM"]; //Commission Nationale Médicale
if(isset($instances["CNMER"]))  $instanceCNMER = $instances["CNMER"]; //Commission Nationale Ocean-Racing / Va'a
if(isset($instances["CNPN"]))  $instanceCNPN = $instances["CNPN"]; //Commission Nationale Patrimoine Nautique
if(isset($instances["CNSLA"]))  $instanceCNSLA = $instances["CNSLA"]; //Commission Nationale Slalom
if(isset($instances["CNWAS"])) $instanceCNWAS = $instances["CNWAS"]; //Commission Nationale Freestyle
if(isset($instances["NW055"]))  $instanceNW055 = $instances["NW055"]; //Commission Nationale Waveski-Surfing
if(isset($instances["NW056"]))  $instanceNW056 = $instances["NW056"]; //Commission de Surveillance Electorale
if(isset($instances["NW071"])) $instanceNW071 = $instances["NW071"]; //Commission Nationale Jeunes
if(isset($instances["NW075"]))  $instanceNW075 = $instances["NW075"]; //Commission Nationale Dragon-Boat
if(isset($instances["NW077"])) $instanceNW077 = $instances["NW077"]; //Commission Nationale des Juges et des Arbitres
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
                    <?php if(isset($instances["NW056"])): ?>
                      <h4><?php echo $instanceNW056->libelle; ?></h4>
                      <p>
                        <?php foreach ($instanceNW056->fonction as $fonction){
                          echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                          if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                          echo "<br>";
                        }?>
                      </p>
                    <?php endif; ?>

                    <?php if(isset($instances["CNM"])): ?>
                      <h4><?php echo $instanceCNM->libelle; ?></h4>
                      <p>
                        <?php foreach ($instanceCNM->fonction as $fonction){
                          echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                          if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                          echo "<br>";
                        }?>
                      </p>
                    <?php endif; ?>

                    <?php if(isset($instances["CNDD"])): ?>
                      <h4><?php echo $instanceCNDD->libelle; ?></h4>
                      <p>
                        <?php foreach ($instanceCNDD->fonction as $fonction){
                          echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                          if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                          echo "<br>";
                        }?>
                      </p>
                    <?php endif; ?>

                    <?php if(isset($instances["CDA"])): ?>
                      <h4><?php echo $instanceCDA->libelle; ?></h4>
                      <p>
                        <?php foreach ($instanceCDA->fonction as $fonction){
                          echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                          if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                          echo "<br>";
                        }?>
                      </p>
                    <?php endif; ?>


                    <?php if(isset($instances["NW077"])): ?>
                      <h4><?php echo $instanceNW077->libelle; ?></h4>
                      <p>
                        <?php foreach ($instanceNW077->fonction as $fonction){
                          echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                          if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                          echo "<br>";
                        }?>
                      </p>
                    <?php endif; ?>

                    <?php if(isset($instances["CD1I"])): ?>
                      <h4><?php echo $instanceCD1I->libelle; ?></h4>
                      <p>
                        <?php foreach ($instanceCD1I->fonction as $fonction){
                          echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                          if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                          echo "<br>";
                        }?>
                      </p>
                    <?php endif; ?>

                    <?php if(isset($instances["CDOP"])): ?>
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
                  <?php if(isset($instances["NW071"])): ?>
                    <h4><?php echo $instanceNW071->libelle; ?></h4>
                    <p><?php foreach ($instanceNW071->fonction as $fonction)
                      {
                        echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                        if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                        echo "<br>";
                      }?>
                    </p>
                  <?php endif; ?>

                  <?php if(isset($instances["CNEF"])): ?>
                    <h4><?php echo $instanceCNEF->libelle; ?></h4>
                    <p><?php foreach ($instanceCNEF->fonction as $fonction)
                      {
                       echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                       if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                       echo "<br>";
                     }?>
                   </p>
                 <?php endif; ?>

                 <?php if(isset($instances["CNPN"])): ?>
                   <h4><?php echo $instanceCNPN->libelle; ?></h4>
                   <p><?php foreach ($instanceCNPN->fonction as $fonction)
                    {
                     echo $fonction->civilite." ".$fonction->prenom." ".$fonction->nom;
                     if ($fonction->typeFonction != 'Membre') echo " - ".$fonction->typeFonction;
                     echo "<br>";
                   }?>
                 </p>
               <?php endif; ?>

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
