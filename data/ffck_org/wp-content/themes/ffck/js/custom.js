( function( $ ) {

	function getEventList($elm,scActivite){
		$.ajax({
        type: "GET",
        url: "wp-content/themes/ffck/ajax/ajax-event-list.php",
        data : 'scActivite=' + scActivite,
        dataType : 'html',
        success : function(code_html, statut){
          $elm.html(code_html);
				},
				error : function(resultat, statut, erreur){
					$elm.html('Erreur lors du chargement.');
				},
				complete : function(resultat, statut){
          if ( $( ".event_slider" ).length ) {
  					$('.event_slider').owlCarousel({
  						loop:true,
  						margin:0,
  						dots:true,
  						nav:true,
  						autoplay:false,
  						autoplayTimeout:3000,
  						autoplayHoverPause:true,
  						responsive:{
  							0:{
  								items:1
  							},
  							600:{
  								items:2
  							},
  							1000:{
  								items:3
  							},
  							1200:{
  								items:4
  							}

  						}
  					});
          }
          if ( $( ".venir_slider" ).length ) {
            $('.venir_slider').owlCarousel({
              loop:true,
              margin:0,
              dots:true,
              nav:true,
              autoHeight: true,
              autoplay:false,
              autoplayTimeout:3000,
              autoplayHoverPause:true,
              responsive:{
                0:{
                  items:1
                },
                767:{
                  items:2
                },
                1000:{
                  items:3
                },
                1200:{
                  items:4
                }

              }
            })
          }
				}
    });

    return false;
  }

  function getVideoGallery($elm){
		$.ajax({
        type: "GET",
        url: "wp-content/themes/ffck/ajax/ajax-video-gallery.php",
        // data : 'scActivite=' + scActivite,
        dataType : 'html',
        success : function(code_html, statut){
          $elm.html(code_html);
				},
				error : function(resultat, statut, erreur){
					$elm.html('Erreur lors du chargement.');
				},
				complete : function(resultat, statut){
					$('.tv-mobile').owlCarousel({
						loop:true,
						margin:0,
						dots:true,
						nav:false,
						autoHeight: true,
						autoplay:true,
						autoplayTimeout:3000,
						autoplayHoverPause:true,
						responsive:{
							0:{
								items:1
							},
							767:{
								items:2
							},
							1000:{
								items:3
							},
							1200:{
								items:4
							}

						}
					})
				}
    });

    return false;
  }

	$( function() {

		if ( $("#sc-list-event").length ) {
			var scActivite = $("#sc-list-event").data('activite');
			getEventList($("#sc-list-event"),scActivite);
		}

		if ( $("#sc-video-gallery").length ) {
			getVideoGallery($("#sc-video-gallery"));
		}

	} );
} )( jQuery );