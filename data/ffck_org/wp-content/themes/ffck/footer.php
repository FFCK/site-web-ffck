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

<?php
$fb=ot_get_option('facebook_link');
$tw=ot_get_option('twitter_link');
$in=ot_get_option('instagram_link');
$pl=ot_get_option('social_play');
if($fb!='') {
  $fb_link=ot_get_option('facebook_link');
}
if($tw!='') {
  $tw_link=ot_get_option('twitter_link');
}
if($fb!='') {
  $in_link=ot_get_option('instagram_link');
}
if($fb!='') {
  $pl_link=ot_get_option('social_play');
}
?>

<!--Main Footer-->
<footer id="footer">

  <div class="logo_wapper" >
    <div class="back-to-top">
      <a href="#"><span><i class="fa fa-chevron-up"></i>Retour en haut de page</span></a>
    </div>
    <div class="container">
      <div class="logo_wapper_sub">
        <div class="logo_div"><img src="<?php echo get_template_directory_uri(); ?>/images/footer_logo.png" alt=""></div>
        <div class="logo_slider">
          <div class="flexslider carousel">
            <ul class="slides">
              <?php
              if (is_category()) {
                $queried_object = get_queried_object();
                $taxonomy = $queried_object->taxonomy;
                $term_id = $queried_object->term_id;
                $parent = $taxonomy . '_' . $term_id;
                if( have_rows('Partner_Image',$parent) ):
                  while ( have_rows('Partner_Image',$parent) ) : the_row();
                echo '<li><a href="' . get_sub_field('lien') . '" target="_blank"><img src="' . get_sub_field('logo') . '"></a></li>';
                endwhile;
                endif;
              }
              else if (is_single()) {
                  // load all 'category' terms for the post
                $categories = get_the_category();
                $taxonomy = $categories[0]->taxonomy;
                $term_id = $categories[0]->term_id;
                $parent = $taxonomy . '_' . $term_id;
                if( have_rows('Partner_Image',$parent) ):
                  while ( have_rows('Partner_Image',$parent) ) : the_row();
                echo '<li><a href="' . get_sub_field('lien') . '" target="_blank"><img src="' . get_sub_field('logo') . '"></a></li>';
                endwhile;
                endif;
              }
              else {
                if ($post->post_parent) {
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
              }

              ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="image_1"><img src="<?php echo get_template_directory_uri(); ?>/images/f_image_1.jpg" alt=""></div>
  <div class="f_bg"></div>
  <div class="footer_wapper">
    <div class="container desktop_footer">
      <div class="row">
        <div class="col-md-7">
          <div class="footer_left">
            <div class="row">
              <div class="col-sm-4">
                <h3><?php $nav_menu = wp_get_nav_menu_object(5); echo $nav_menu->name; ?></h3>
                <ul>
                  <?php $args = array(
                    'menu'            => '5',
                    'items_wrap'      => '<ul class="">%3$s</ul>',
                    'before'          => '',
                    );
                    wp_nav_menu($args);  ?>
                  </ul>
                </div>
                <div class="col-sm-4">
                  <h3><?php $nav_menu = wp_get_nav_menu_object(8); echo $nav_menu->name; ?></h3>
                  <ul>
                    <?php $args = array(
                      'menu'            => '8',
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
                      <h3><?php $nav_menu = wp_get_nav_menu_object(6); echo $nav_menu->name; ?></h3>
                      <ul>
                        <?php $args = array(
                          'menu'            => '6',
                          'items_wrap'      => '<ul class="">%3$s</ul>',
                          'before'          => '',
                          );
                          wp_nav_menu($args);  ?>
                        </ul>
                      </div>
                      <div class="col-sm-4">
                        <h3><?php $nav_menu = wp_get_nav_menu_object(9); echo $nav_menu->name; ?></h3>
                        <ul>
                          <?php $args = array(
                            'menu'            => '9',
                            'items_wrap'      => '<ul class="">%3$s</ul>',
                            'before'          => '',
                            );
                            wp_nav_menu($args);  ?>
                          </ul>
                        </div>
                        <div class="col-sm-4">
                          <h3>Clubs</h3>
                          <ul>
                            <?php $args = array(
                              'menu'            => 'Clubs',
                              'items_wrap'      => '<ul class="">%3$s</ul>',
                              'before'          => '',
                              );
                              wp_nav_menu($args);  ?>
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
                        <form id="form-annuaire-footer">
                          <div class="formbox newslatter">
                            <div class="row">
                              <div class="col-sm-8">
                                <div class="inputbox"><input id="text-villefooter" name="villefooter" type="text" placeholder="Ville ou code postal"></div>
                              </div>
                              <div class="col-sm-4">
                                <div class="submitbox"><input id="button-annuaire-footer" type="submit" value="Rechercher"></div>
                              </div>
                            </div>
                          </div>
                        </form>


                        <div class="btn-group dropup toolbox">
                          <a type="button" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Boîte à outils</a>
                          <?php $args = array(
                            'menu'            => '55',
                            'container'       => '',
                            'items_wrap'      => '<ul class="dropdown-menu">%3$s</ul>',
                            );
                            wp_nav_menu($args);  ?>
                          </div>

                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="footer_bootom">
                          <div class="topline"></div>
                          <div class="copyright"><span>FFCK</span> © 2016</div>
                          <ul>
                            <?php $args = array(
                              'menu'            => 'Footer_bottom',
                              'items_wrap'      => '<ul class="">%3$s</ul>',
                              'before'          => '',
                              );
                              wp_nav_menu($args);  ?>
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
                            <li><a href="<?php echo $fb_link; ?>" target="_blank"><span class="fa fa-facebook-f"></span></a></li>
                            <li><a href="<?php echo $tw_link; ?>" target="_blank"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="<?php echo $in_link; ?>" target="_blank"><span class="fa fa-instagram"></span></a></li>
                            <li><a href="<?php echo $pl_link; ?>" target="_blank"><span class="fa fa-play"></span>FFCK TV</a></li>
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
                          <h3><?php $nav_menu = wp_get_nav_menu_object(7); echo $nav_menu->name; ?></h3>
                          <ul>
                            <?php $args = array(
                              'menu'            => '7',
                              'items_wrap'      => '<ul class="">%3$s</ul>',
                              'before'          => '',
                              );
                              wp_nav_menu($args);  ?>
                            </ul>
                          </div>
                          <div class="footer_nav">
                            <h3><?php $nav_menu = wp_get_nav_menu_object(10); echo $nav_menu->name; ?></h3>
                            <?php $args = array(
                              'menu'            => '10',
                              'items_wrap'      => '<ul class="">%3$s</ul>',
                              'before'          => '',
                              );
                              wp_nav_menu($args);  ?>
                            </div>

                            <div class="row">
                              <div class="col-sm-12">
                                <div class="footer_bootom">
                                  <div class="topline"></div>
                                  <div class="copyright"><span>FFCK</span> © 2016</div>
                                  <?php $args = array(
                                    'menu'            => 'Footer_bottom',
                                    'items_wrap'      => '<ul class="">%3$s</ul>',
                                    'before'          => '',
                                    );
                                    wp_nav_menu($args);  ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div><!-- mobile footer start -->
                        </div>
                      </footer>
                      <!--End Main Footer-->

                      <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js"></script>
                      <script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap.js"></script>
                      <script src="<?php echo get_template_directory_uri(); ?>/js/AnimOnScroll.js"></script>
                      <script src="<?php echo get_template_directory_uri(); ?>/js/owl.carousel.js"></script>
                      <script defer src="<?php echo get_template_directory_uri(); ?>/js/jquery.flexslider.js"></script>
                      <script src="<?php echo get_template_directory_uri(); ?>/js/jquery.tablesorter.min.js"></script>

                      <script type="text/javascript">

  /*jQuery(function(){
  // SyntaxHighlighter.all();
  jQuery("a[rel^='prettyPhoto']").prettyPhoto();
});*/

jQuery(window).load(function(){
  jQuery(".vc_tta-panel").removeClass("vc_active");
  jQuery('ul.vc_tta-tabs-list li:first').addClass('clickedli');
  jQuery( '.clickedli a').click();
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
  if(jQuery( window ).width() < 768){
    jQuery("li.have-sub").children('ul').hide();
    jQuery( jQuery("li.have-sub").children('ul') ).hide();
    jQuery( jQuery("li.have-sub").children('ul') ).hide();
    jQuery( "ul" ).first().addClass( "vc_v" );
    jQuery( "li.have-sub" ).click(function() {
      jQuery(this).children('ul').slideToggle();
    });
  }
});

jQuery( ".search_block a" ).click(function() {
  jQuery( ".search_block" ).toggleClass( "active" );
  jQuery( "#search_form" ).toggleClass( "show" );
});

jQuery(window).scroll(function() {
  var scroll = jQuery(window).scrollTop();
  var wht = 170;
  if (scroll >= wht) {
    jQuery("#header-spacer").show();
    jQuery("#header").addClass("darkHeader");
  } else {
    jQuery("#header-spacer").hide();
    jQuery("#header").removeClass("darkHeader");
  }
});

</script>

<!-- Custom JS -->
<script src="<?php echo get_template_directory_uri(); ?>/js/bootstrap-select.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/browser_selector.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/featherlight.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.fb.albumbrowser.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jspdf.min.js"></script>
<?php if ( is_page(12) ): ?>
  <script>
    var placeSearch, autocomplete;
    var componentForm = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      postal_code: 'short_name'
    };

    function initAutocomplete() {
      var options = {
       types: ['(cities)'],
       componentRestrictions: {country: 'fr'}
     };
     autocomplete = new google.maps.places.Autocomplete((document.getElementById('autocomplete')),options);

     autocomplete.addListener('place_changed', fillInAddress);
   }

   function fillInAddress() {
    return true;
  }
  
  function geoFindMe() {
    function do_something(city,country,lat,lng) {
      var valVille = city + ',' + country;
      var urlSearch = "trouver-un-club/?search_keywords=&search_location=" + valVille + "&search_categories=&use_search_radius=on&search_radius=20&search_lat=&search_lng=&search_region=&search_context=6&filter_job_type=";
      window.location.href = urlSearch;
    }

    jQuery.getJSON('https://ipinfo.io/geo', function(response) { 
      var city = response.city;
      var loc = response.loc.split(',');
      var lat = loc[0];
      var lng = loc[1];
      var coords = {
        latitude: lat,
        longitude: lng
      };
      var region = response.region;
      var country = response.country;
      var postal = response.postal;
      
      do_something(city,country,lat,lng);
    });
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpSecK_iwiCBzbgqlboe1SaNN3k75pWmk&signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>
<?php endif; ?>
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js"></script>
<?php wp_footer(); ?>
</body>
</html>
