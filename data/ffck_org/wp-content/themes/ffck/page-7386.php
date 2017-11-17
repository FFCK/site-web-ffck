<?php
//PAGE ORGANISATION FEDERALE AVEC LOADER 
//TODO : BUG

//header('Access-Control-Allow-Origin:*');
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

      <div id="content-to-load-instances">
        <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>
      </div>


      <div id="content-hide">
        <?php the_content(); ?>
      </div>

      <div id="content-to-load-comites">
       <!--  <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span> -->
     </div>

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





<?php get_template_part('footer-only'); ?>
<?php get_template_part('common-js'); ?>

<script type="text/javascript">

  jQuery('#content-hide').hide();

  function getInstances() {
    /* TODO: trouver une solution pour appeler l'url du site avec une fonction php */
    $.ajax({
      url: "http://localhost/wp-content/themes/ffck/inc/partial/ajax_organisation_instances.php",
      type: "POST",
      /* data:'id='+id, */
      success:function(data){
        jQuery('#content-to-load-instances').html(data);
        jQuery('#content-hide').show();
        jQuery('#content-to-load-comites').html( '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Loading...</span>');
      }
    });
  }

  getInstances(); 

  function getComites(){
    /* TODO: trouver une solution pour appeler l'url du site avec une fonction php */
    $.ajax({
      url: "http://localhost/wp-content/themes/ffck/inc/partial/ajax_organisation_comites.php",
      type: "POST",
      /* data:'id='+id, */
      success:function(data){
        jQuery('#content-to-load-comites').html(data);
      }
    });
  }

  getComites();

</script>
<script type="text/javascript" src="<?php echo plugins_url(); ?>/js_composer/assets/lib/vc_accordion/vc-accordion.min.js?ver=4.9"></script>

<?php get_template_part('html-end'); ?>
