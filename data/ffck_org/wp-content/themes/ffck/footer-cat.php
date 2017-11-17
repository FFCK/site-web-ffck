<?php
/**
* The template for displaying the footer
*
* Contains footer content and the closing of the #main and #page div elements.
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
?>

<!--Main Footer-->
<footer id="footer">

  <div class="logo_wapper" >
    <div class="back-to-top">
      <a href="#"><span><i class="fa fa-chevron-up"></i>Retour en haut de page</span></a>
    </div>
    <div class="container">
      <div class="logo_wapper_sub">
        <div class="logo_div"><img src="<?php echo get_template_directory_uri(); ?>/images/footer_logo.png"   alt=""></div>
        <div class="logo_slider">
          <div class="flexslider carousel">
            <ul class="slides">
              <?php
                if ($post->post_parent)	{
                	$ancestors=get_post_ancestors($post->ID);
                	$root=count($ancestors)-1;
                	$parent = $ancestors[$root];
                } else {
                	$parent = $post->ID;
                }
                if( have_rows('Partner_Image',$parent) ):
                  while ( have_rows('Partner_Image',$parent) ) : the_row();
                    echo '<li><a href="' . get_sub_field('lien') . '" target="_blank"><img src="' . get_sub_field('logo') . '"></a></li>';
                  endwhile;
                endif;
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="image_1"><img src="<?php echo get_template_directory_uri(); ?>/images/f_image_1.jpg" alt=""></div>

  <div class="f_bg"></div>

  <?php
    $fb=ot_get_option('facebook_link');
    $tw=ot_get_option('twitter_link');
    $in=ot_get_option('instagram_link');
    $pl=ot_get_option('social_play');
    if($fb!='') { $fb_link=ot_get_option('facebook_link'); }
    if($tw!='') { $tw_link=ot_get_option('twitter_link'); }
    if($fb!='') { $in_link=ot_get_option('instagram_link'); }
    if($fb!='') { $pl_link=ot_get_option('social_play'); }
  ?>

  <div class="footer_wapper">
    <div class="container desktop_footer">
      <div class="row">
        <div class="col-md-7">
          <div class="footer_left">
            <div class="row">
              <div class="col-sm-4">
                <h3>Sports olympique</h3>
                <ul>
                  <?php
                    $args = array(
                      'menu'            => 'Sports olympique',
                      'items_wrap'      => '<ul class="">%3$s</ul>',
                      'before'          => '',
                    );
                    wp_nav_menu($args);
                  ?>
                </ul>
              </div>
              <div class="col-sm-4">
                <h3>Sports de compétiton</h3>
                <ul>
                  <?php $args = array(
                    'menu'            => 'Sports de compétiton',
                    'items_wrap'      => '<ul class="">%3$s</ul>',
                    'before'          => '',
                  );
                  wp_nav_menu($args);  ?>
                </ul>
              </div>
              <div class="col-sm-4">
                <h3>Liens utiles</h3>
                <ul>
                  <?php $args = array(
                    'menu'            => 'Liens utiles',
                    'items_wrap'      => '<ul class="">%3$s</ul>',
                    'before'          => '',
                  );
                  wp_nav_menu($args);  ?>
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-4">
                <h3>randonnées nautiques</h3>
                <ul>
                  <?php $args = array(
                    'menu'            => 'randonnées nautiques',
                    'items_wrap'      => '<ul class="">%3$s</ul>',
                    'before'          => '',
                  );
                  wp_nav_menu($args);  ?>
                </ul>
              </div>
              <div class="col-sm-4">
                <h3>FFCK</h3>
                <ul>
                  <?php $args = array(
                    'menu'            => 'ffck',
                    'items_wrap'      => '<ul class="">%3$s</ul>',
                    'before'          => '',
                  );
                  wp_nav_menu($args);  ?>
                </ul>
              </div>
              <div class="col-sm-4">
                <h3>Clubs</h3>
                <ul>
                  <?php
                    $args = array(
                      'menu'            => 'Clubs',
                      'items_wrap'      => '<ul class="">%3$s</ul>',
                      'before'          => '',
                    );
                    wp_nav_menu($args);
                  ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <div class="footer_right">
            <div class="f_social">
              <h3>Nous suivre</h3>
              <ul>
                <li><a href="<?php echo $fb_link; ?>" target="_blank"><span class="fa fa-facebook-f"></span></a></li>
                <li><a href="<?php echo $tw_link; ?>" target="_blank"><span class="fa fa-twitter"></span></a></li>
                <li><a href="<?php echo $in_link; ?>" target="_blank"><span class="fa fa-instagram"></span></a></li>
                <li><a href="<?php echo $pl_link; ?>" target="_blank"><span class="fa fa-play"></span>FFCK TV</a></li>
              </ul>
            </div>

            <?php  dynamic_sidebar( 'footer_newslatter_block' ); ?>

            <h3>Trouver un club</h3>
            <p>Renseigner votre localisation ou choisissez la géolocalisation</p>
            <form>
              <div class="formbox newslatter">
                <div class="row">
                  <div class="col-sm-8">
                    <div class="inputbox"><input type="text" placeholder="Ville ou code postal"></div>
                  </div>
                  <div class="col-sm-4">
                    <div class="submitbox"><input type="submit" value="Rechercher"></div>
                  </div>
                </div>
              </div>
            </form>
            <div class="toolbox"><a href="#">Boite à outils</a></div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="footer_bootom">
            <div class="topline"></div>
            <div class="copyright"><span>FFCK</span> © 2016</div>
            <ul>
              <?php
                $args = array(
                  'menu'            => 'Footer_bottom',
                  'items_wrap'      => '<ul class="">%3$s</ul>',
                  'before'          => '',
                );
                wp_nav_menu($args);
              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- mobile footer start -->
    <div class="mobile_footer">
      <div class="container">
        <div class="f_social">
          <h3>Nous suivre</h3>
          <ul>
            <li><a href="<?php echo $fb_link; ?>"><span class="fa fa-facebook-f"></span></a></li>
            <li><a href="<?php echo $tw_link; ?>"><span class="fa fa-twitter"></span></a></li>
            <li><a href="<?php echo $in_link; ?>"><span class="fa fa-instagram"></span></a></li>
            <li><a href="<?php echo $pl_link; ?>"><span class="fa fa-play"></span>FFCK TV</a></li>
          </ul>
        </div>

        <div class="footer_news">
          <h3>Trouver un club</h3>
          <p>Renseigner votre localisation ou choisissez la géolocalisation</p>
          <form>
            <div class="formbox newslatter">
              <div class="row">
                <div class="col-sm-8">
                  <div class="inputbox"><input type="text" placeholder="Ville ou code postal"></div>
                </div>
                <div class="col-sm-4">
                  <div class="submitbox"><input type="submit" value="Rechercher"></div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="footer_nav">
          <h3>Liens utiles</h3>
          <ul>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Dolor sit amet</a></li>
            <li><a href="#">Eras deus</a></li>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Dolor sit amet</a></li>
          </ul>
        </div>

        <div class="footer_nav">
          <h3>Clubs</h3>
          <ul>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Dolor sit amet</a></li>
            <li><a href="#">Eras deus</a></li>
            <li><a href="#">Lorem ipsum</a></li>
            <li><a href="#">Dolor sit amet</a></li>
          </ul>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <div class="footer_bootom">
              <div class="topline"></div>
              <div class="copyright"><span>FFCK</span> © 2016</div>
              <ul>
                <li><a href="http://stargraf.com/" target="_blank">Réalisation Stargraf</a></li>
                <li><a href="#">Mentions légales</a></li>
                <li><a href="#">Plan du site</a></li>
                <li><a href="#">Contactez nous</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- mobile footer start -->
  </div>
</footer>
<!--End Main Footer-->

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/AnimOnScroll.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script>
<script defer src="<?php echo get_template_directory_uri(); ?>/js/jquery.flexslider.js"></script>

<script type="text/javascript">

  jQuery(function(){
    SyntaxHighlighter.all();
    jQuery( ".search_block a" ).click(function() {
      jQuery( ".search_block" ).toggleClass( "active" );
      jQuery( "#search_form" ).toggleClass( "show" );
    });

    jQuery( "li.have-sub" ).click(function() {
      jQuery(this).children('ul').slideToggle();
    });
  });
  jQuery(window).load(function(){
    jQuery(".vc_tta-panel").removeClass("vc_active");
    if(jQuery( window ).width()<768){
      jQuery("li.have-sub").children('ul').hide();
      jQuery( jQuery("li.have-sub").children('ul') ).hide();
    }
    jQuery('.flexslider').flexslider({
      animation: "slide",
      animationLoop: false,
      itemWidth: 210,
      itemMargin: 5,
      minItems: 2,
      maxItems: 5,
      start: function(slider){
        jQuery('body').removeClass('loading');
      }
    });
  });

</script>

<!--Custom JS-->
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-select.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/browser_selector.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
<?php wp_footer(); ?>
</body>
</html>
