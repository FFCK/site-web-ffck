/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */
 ( function( $ ) {
   var body    = $( 'body' ),
   _window = $( window ),
   nav, button, menu;

   nav = $( '#primary-navigation' );
   button = nav.find( '.menu-toggle' );
   menu = nav.find( '.nav-menu' );

	// Enable menu toggle for small screens.
	( function() {
		if ( ! nav || ! button ) {
			return;
		}

		// Hide button if menu is missing or empty.
		if ( ! menu || ! menu.children().length ) {
			button.hide();
			return;
		}

		button.on( 'click.twentyfourteen', function() {
			nav.toggleClass( 'toggled-on' );
			if ( nav.hasClass( 'toggled-on' ) ) {
				$( this ).attr( 'aria-expanded', 'true' );
				menu.attr( 'aria-expanded', 'true' );
			} else {
				$( this ).attr( 'aria-expanded', 'false' );
				menu.attr( 'aria-expanded', 'false' );
			}
		} );
	} )();

	/*
	 * Makes "skip to content" link work correctly in IE9 and Chrome for better
	 * accessibility.
	 *
	 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
	 */
  _window.on( 'hashchange.twentyfourteen', function() {
    var hash = location.hash.substring( 1 ), element;

    if ( ! hash ) {
     return;
   }

   element = document.getElementById( hash );

   if ( element ) {
     if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
      element.tabIndex = -1;
    }

    element.focus();

			// Repositions the window on jump-to-anchor to account for header height.
			window.scrollBy( 0, -80 );
		}
	} );

  $( function() {
		// Search toggle.
		$( '.search-toggle' ).on( 'click.twentyfourteen', function( event ) {
			var that    = $( this ),
      wrapper = $( '#search-container' ),
      container = that.find( 'a' );

      that.toggleClass( 'active' );
      wrapper.toggleClass( 'hide' );

      if ( that.hasClass( 'active' ) ) {
        container.attr( 'aria-expanded', 'true' );
      } else {
        container.attr( 'aria-expanded', 'false' );
      }

      if ( that.is( '.active' ) || $( '.search-toggle .screen-reader-text' )[0] === event.target ) {
        wrapper.find( '.search-field' ).focus();
      }
    } );

		/*
		 * Fixed header for large screen.
		 * If the header becomes more than 48px tall, unfix the header.
		 *
		 * The callback on the scroll event is only added if there is a header
		 * image and we are not on mobile.
		 */
     if ( _window.width() > 781 ) {
       var mastheadHeight = $( '#masthead' ).height(),
       toolbarOffset, mastheadOffset;

       if ( mastheadHeight > 48 ) {
        body.removeClass( 'masthead-fixed' );
      }

      if ( body.is( '.header-image' ) ) {
        toolbarOffset  = body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
        mastheadOffset = $( '#masthead' ).offset().top - toolbarOffset;

        _window.on( 'scroll.twentyfourteen', function() {
         if ( _window.scrollTop() > mastheadOffset && mastheadHeight < 49 ) {
          body.addClass( 'masthead-fixed' );
        } else {
          body.removeClass( 'masthead-fixed' );
        }
      } );
      }
    }

		// Focus styles for menus.
		$( '.primary-navigation, .secondary-navigation' ).find( 'a' ).on( 'focus.twentyfourteen blur.twentyfourteen', function() {
			$( this ).parents().toggleClass( 'focus' );
		} );


    // JWC
    // action sur le survol d'un lien du menu latéral
    $('#menu-sidebar_second_menu > li > a').hover(function(e){
      // si le lien contient un sous-menu
      if ( ($(this).parent().find('.sub-menu').length != 0) ) {
        e.preventDefault();
        // s'il s'agit du lien de la page en cours on ne fait rien
        if ( $(this).parent().hasClass('current-menu-parent') ) {
          return false;
        }
        // sinon on déplie le sous-menu
        else {
          $(this).parent().find('.sub-menu').stop(true,true).delay(300).slideDown(200, function(){
            $(this).parent().find('a').addClass('open');
          });
          return false;
        }
      }
    }, function(){ // action lorsque l'on quitte le survol
      // si on n'est pas en survol du sous-menu et que nous sommes pas sur la page du lien en cours on replie le sous-menu
      if (  !$(this).parent().hasClass('current-menu-parent') ) {
        $(this).parent().find('.sub-menu').stop(true,true).delay(300).slideUp(200, function(){
          $(this).parent().find('a').removeClass('open');
        });
      }
    });

    // action sur le survol du sous-menu
    $('.sub-menu').hover(function(){
      $(this).stop(true,true).show(0); // on montre le sous-menu
    }, function(){ // action lorsque l'on quitte le survol
      // s'il ne s'agit pas du lien de la page en cours on replis le sous-menu
      // if( !$(this).parent().hasClass('current-menu-parent') ) {
      //   $(this).stop(true,true).delay(300).slideUp(200, function(){
      //     $(this).parent().find('a').removeClass('open');
      //   });
      // }
    });

    $('#menu-sidebar_second_menu').hover(function(){}, function(){
      $(this).find('.sub-menu').each(function(){
        $(this).stop(true,true).delay(300).slideUp(200, function(){
          $(this).parent().find('a').removeClass('open');
        });
      });
    });

    $('.social-click .vc_tta-panel-heading').click(function(){
      setTimeout(function(){
        $('a.link-all').trigger('click');
      }, 500);
    });

} );

	/**
	 * @summary Add or remove ARIA attributes.
	 * Uses jQuery's width() function to determine the size of the window and add
	 * the default ARIA attributes for the menu toggle if it's visible.
	 * @since Twenty Fourteen 1.4
	 */
  function onResizeARIA() {
    if ( 781 > _window.width() ) {
     button.attr( 'aria-expanded', 'false' );
     menu.attr( 'aria-expanded', 'false' );
     button.attr( 'aria-controls', 'primary-menu' );
   } else {
     button.removeAttr( 'aria-expanded' );
     menu.removeAttr( 'aria-expanded' );
     button.removeAttr( 'aria-controls' );
   }
 }

 _window
 .on( 'load.twentyfourteen', onResizeARIA )
 .on( 'resize.twentyfourteen', function() {
   onResizeARIA();
 } );

 _window.load( function() {
		// Arrange footer widgets vertically.
		if ( $.isFunction( $.fn.masonry ) ) {
			$( '#footer-sidebar' ).masonry( {
				itemSelector: '.widget',
				columnWidth: function( containerWidth ) {
					return containerWidth / 4;
				},
				gutterWidth: 0,
				isResizable: true,
				isRTL: $( 'body' ).is( '.rtl' )
			} );
		}

		// Initialize Featured Content slider.
		if ( body.is( '.slider' ) ) {
			$( '.featured-content' ).featuredslider( {
				selector: '.featured-content-inner > article',
				controlsContainer: '.featured-content'
			} );
		}
	} );
} )( jQuery );
