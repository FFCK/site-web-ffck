/*========== Animation On Scroll start ================*/

(function () {
	var Util, __bind = function (fn, me) {
		return function () {
			return fn.apply(me, arguments);
		};
	};
	Util = (function () {
		function Util() {}
		Util.prototype.extend = function (custom, defaults) {
			var key, value;
			for (key in custom) {
				value = custom[key];
				if (value != null) {
					defaults[key] = value;
				}
			}
			return defaults;
		};
		Util.prototype.isMobile = function (agent) {
			return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(agent);
		};
		return Util;
	})();
	this.WOW = (function () {
		WOW.prototype.defaults = {
			boxClass: 'wow',
			animateClass: 'animated',
			offset: 0,
			mobile: true
		};
		function WOW(options) {
			if (options == null) {
				options = {};
			}
			this.scrollCallback = __bind(this.scrollCallback, this);
			this.scrollHandler = __bind(this.scrollHandler, this);
			this.start = __bind(this.start, this);
			this.scrolled = true;
			this.config = this.util().extend(options, this.defaults);
		}
		WOW.prototype.init = function () {
			var _ref;
			this.element = window.document.documentElement;
			if ((_ref = document.readyState) === "interactive" || _ref === "complete") {
				return this.start();
			} else {
				return document.addEventListener('DOMContentLoaded', this.start);
			}
		};
		WOW.prototype.start = function () {
			var box, _i, _len, _ref;
			this.boxes = this.element.getElementsByClassName(this.config.boxClass);
			if (this.boxes.length) {
				if (this.disabled()) {
					return this.resetStyle();
				} else {
					_ref = this.boxes;
					for (_i = 0, _len = _ref.length; _i < _len; _i++) {
						box = _ref[_i];
						this.applyStyle(box, true);
					}
					window.addEventListener('scroll', this.scrollHandler, false);
					window.addEventListener('resize', this.scrollHandler, false);
					return this.interval = setInterval(this.scrollCallback, 50);
				}
			}
		};
		WOW.prototype.stop = function () {
			window.removeEventListener('scroll', this.scrollHandler, false);
			window.removeEventListener('resize', this.scrollHandler, false);
			if (this.interval != null) {
				return clearInterval(this.interval);
			}
		};
		WOW.prototype.show = function (box) {
			this.applyStyle(box);
			return box.className = "" + box.className + " " + this.config.animateClass;
		};
		WOW.prototype.applyStyle = function (box, hidden) {
			var delay, duration, iteration;
			duration = box.getAttribute('data-wow-duration');
			delay = box.getAttribute('data-wow-delay');
			iteration = box.getAttribute('data-wow-iteration');
			return box.setAttribute('style', this.customStyle(hidden, duration, delay, iteration));
		};
		WOW.prototype.resetStyle = function () {
			var box, _i, _len, _ref, _results;
			_ref = this.boxes;
			_results = [];
			for (_i = 0, _len = _ref.length; _i < _len; _i++) {
				box = _ref[_i];
				_results.push(box.setAttribute('style', 'visibility: visible;'));
			}
			return _results;
		};
		WOW.prototype.customStyle = function (hidden, duration, delay, iteration) {
			var style;
			style = hidden ? "visibility: hidden; -webkit-animation-name: none; -moz-animation-name: none; animation-name: none;" : "visibility: visible;";
			if (duration) {
				style += "-webkit-animation-duration: " + duration + "; -moz-animation-duration: " + duration + "; animation-duration: " + duration + ";";
			}
			if (delay) {
				style += "-webkit-animation-delay: " + delay + "; -moz-animation-delay: " + delay + "; animation-delay: " + delay + ";";
			}
			if (iteration) {
				style += "-webkit-animation-iteration-count: " + iteration + "; -moz-animation-iteration-count: " + iteration + "; animation-iteration-count: " + iteration + ";";
			}
			return style;
		};
		WOW.prototype.scrollHandler = function () {
			return this.scrolled = true;
		};
		WOW.prototype.scrollCallback = function () {
			var box;
			if (this.scrolled) {
				this.scrolled = false;
				this.boxes = (function () {
					var _i, _len, _ref, _results;
					_ref = this.boxes;
					_results = [];
					for (_i = 0, _len = _ref.length; _i < _len; _i++) {
						box = _ref[_i];
						if (!(box)) {
							continue;
						}
						if (this.isVisible(box)) {
							this.show(box);
							continue;
						}
						_results.push(box);
					}
					return _results;
				}).call(this);
				if (!this.boxes.length) {
					return this.stop();
				}
			}
		};
		WOW.prototype.offsetTop = function (element) {
			var top;
			top = element.offsetTop;
			while (element = element.offsetParent) {
				top += element.offsetTop;
			}
			return top;
		};
		WOW.prototype.isVisible = function (box) {
			var bottom, offset, top, viewBottom, viewTop;
			offset = box.getAttribute('data-wow-offset') || this.config.offset;
			viewTop = window.pageYOffset;
			viewBottom = viewTop + this.element.clientHeight - offset;
			top = this.offsetTop(box);
			bottom = top + box.clientHeight;
			return top <= viewBottom && bottom >= viewTop;
		};
		WOW.prototype.util = function () {
			return this._util || (this._util = new Util());
		};
		WOW.prototype.disabled = function () {
			return !this.config.mobile && this.util().isMobile(navigator.userAgent);
		};
		return WOW;
	})();
}).call(this);

wow = new WOW({
	animateClass: 'animated',
	offset: 100
});

wow.init();

/*========== Animation On Scroll end ================*/

function initSlider($el){
	$el.find('#slider-right').click(function(e){
		e.preventDefault();
		if ($el.find('.slide.active').nextAll(".slide:first").length > 0) {
			$el.find('.slide.active').fadeOut(400, function(){
				jQuery(this).removeClass('active');
				jQuery(this).nextAll(".slide:first").fadeIn(400).addClass('active');
			});
		}
	});

	$el.find('#slider-left').click(function(e){
		e.preventDefault();
		if ($el.find('.slide.active').prevAll(".slide:first").length > 0) {
			$el.find('.slide.active').fadeOut(400, function(){
				jQuery(this).removeClass('active');
				jQuery(this).prevAll(".slide:first").fadeIn(400).addClass('active');
			});
		}
	});
}


/*================ document ready =================*/

jQuery(document).ready( function() {
	
	if ( jQuery(".tablesorter").length > 0 ) {
		jQuery(".tablesorter").tablesorter();
	}	


	jQuery('.opengallery').featherlight({
		namespace:      'featherlight',
		targetAttr:     'data-gallery',
		variant:        'video',
		afterOpen:      function(event){
			initSlider(jQuery('.featherlight-content .open-gallery'));
		}
	});

	jQuery('.selectpicker').selectpicker();

	/* JWC */
	jQuery('.footer_right .widget form input[type="email"]').wrap('<div class="col-xs-8"></div>').wrap('<div class="inputbox"></div>');
	jQuery('.footer_right .widget form input[type="button"]').wrap('<div class="col-xs-4"></div>').wrap('<div class="submitbox"></div>');
	jQuery( ".footer_right .widget form p:nth-child(2)" ).hide();
	jQuery('.footer_right .widget form').wrap('<div class="row"></div>').wrap('<div class="formbox"></div>');

	jQuery('.big_title h2').each(function(){
		jQuery(this).html(function(index, curHTML) {
			var text = curHTML.split(/[\s-]/),
			newtext = '<span>' + text.pop() + '</span>';
			return text.join(' ').concat(' ' + newtext);
		});
	});

	jQuery('#button-annuaire').click(function(e){
		e.preventDefault();
		var valVille = jQuery('#form-annuaire input[name="ville"]').val();
		var urlSearch = "trouver-un-club/?search_keywords=&search_location=" + valVille + "&search_categories=&use_search_radius=on&search_radius=20&search_lat=&search_lng=&search_region=&search_context=6&filter_job_type=";
		window.location.href = urlSearch;
	});
	jQuery('#button-annuaire-footer').click(function(e){
		e.preventDefault();
		var valVille = jQuery('#form-annuaire-footer input[name="villefooter"]').val();
		var urlSearch = "trouver-un-club/?search_keywords=&search_location=" + valVille + "&search_categories%5B%5D=&use_search_radius=on&search_radius=20&search_lat=0&search_lng=0&search_region=&search_context=6&filter_job_type%5B%5D=";
		window.location.href = urlSearch;
	});

	jQuery("img.alignleft").each(function(){
		jQuery(this).parent().css('min-height',jQuery(this).height());
	});

	jQuery("img.alignright").each(function(){
		jQuery(this).parent().css('min-height',jQuery(this).height());
	});

	jQuery('select').each(function(){
		var $this = jQuery(this), numberOfOptions = jQuery(this).children('option').length;

		$this.addClass('select-hidden');
		$this.wrap('<div class="select"></div>');
		$this.after('<div class="select-styled"></div>');

		var $styledSelect = $this.next('div.select-styled');
		$styledSelect.text($this.children('option').eq(0).text());

		var $list = jQuery('<ul />', {
			'class': 'select-options'
		}).insertAfter($styledSelect);

		for (var i = 0; i < numberOfOptions; i++) {
			jQuery('<li />', {
				text: $this.children('option').eq(i).text(),
				rel: $this.children('option').eq(i).val()
			}).appendTo($list);
		}

		var $listItems = $list.children('li');

		$styledSelect.click(function(e) {
			e.stopPropagation();
			jQuery('div.select-styled.active').each(function(){
				jQuery(this).removeClass('active').next('ul.select-options').hide();
			});
			jQuery(this).toggleClass('active').next('ul.select-options').toggle();
		});

		$listItems.click(function(e) {
			e.stopPropagation();
			$styledSelect.text(jQuery(this).text()).removeClass('active');
			$this.val(jQuery(this).attr('rel'));
			$list.hide();
			// console.log($this.val());


			// select filter
			/* 
			
			CSS A RESPECTER : 	le bouton du filtre doit avpoir la classe filter-button
					            le conteneur général des éléments à filtrer doit avoir la classe filter-wrapper
								chaque ligne de résultat doit avoir une double classe filter-elmt et filter-elmt-XX ou XX est numéro associé au filtre
								*/
								
			if ( $this.hasClass('filter-button') ) { // si l'élément à la classe filter button
				jQuery('.filter-wrapper').fadeOut(0); // cacher le conteneur
				jQuery('.filter-elmt').fadeOut(0); // cacher chaque ligne
				if ( $this.val() == '00' ) { // si le bouton a la valeur 00
					setTimeout(function(){ // timeout 500 ms
						jQuery('.filter-elmt').fadeIn(0); // on fait réapparaitre les elements
						jQuery('.filter-wrapper').fadeIn(300); // on fait réapparaitre le conteneur en opacité durant 300 ms
					}, 500);
				}
				else {
					setTimeout(function(){
						jQuery('.filter-elmt-' + $this.val()).fadeIn(0); // on affiche les elements associés au filtre
						jQuery('.filter-wrapper').fadeIn(300); // on affiche le conteneur
					}, 500);
				}
				
			}




			// select month
			if ($this.attr('id') == "month") {
				jQuery('#accordion').fadeOut(0);
				jQuery('.month').fadeOut(0);
				if ( $this.val() == '00' ) {
					setTimeout(function(){
						jQuery('.month').fadeIn(0);
						jQuery('#accordion').fadeIn(300);
					}, 500);
				}
				setTimeout(function(){
					jQuery('.month-' + $this.val()).fadeIn(0);
					jQuery('#accordion').fadeIn(300);
				}, 500);
			}

			// select niveau
			if ($this.attr('id') == "niveau") {
				jQuery('#accordion').fadeOut(0);
				jQuery('.panel-event').fadeOut(0);
				if ( $this.val() == '00' ) {
					setTimeout(function(){
						jQuery('.panel-event').fadeIn(0);
						jQuery('#accordion').fadeIn(300);
					}, 500);
				}
				setTimeout(function(){
					jQuery('.panel-niveau-' + $this.val()).fadeIn(0);
					jQuery('#accordion').fadeIn(300);
				}, 500);
			}

			// select activite
			if ($this.attr('id') == "activite") {
				jQuery('#accordion').fadeOut(0);
				jQuery('.panel-event').fadeOut(0);
				if ( $this.val() == '00' ) {
					setTimeout(function(){
						jQuery('.panel-event').fadeIn(0);
						jQuery('#accordion').fadeIn(300);
					}, 500);
				}
				setTimeout(function(){
					jQuery('.panel-activite-' + $this.val()).fadeIn(0);
					jQuery('#accordion').fadeIn(300);
				}, 500);
			}

			// select familleformation
			if ($this.attr('id') == "familleformation") {
				jQuery('#accordion').fadeOut(0);
				jQuery('.panel-event').fadeOut(0);
				if ( $this.val() == '00' ) {
					setTimeout(function(){
						jQuery('.panel-event').fadeIn(0);
						jQuery('#accordion').fadeIn(300);
					}, 500);
				}
				setTimeout(function(){
					jQuery('.panel-' + $this.val()).fadeIn(0);
					jQuery('#accordion').fadeIn(300);
				}, 500);
			}

			// select typequalification
			if ($this.attr('id') == "typequalification") {
				jQuery('#accordion').fadeOut(0);
				jQuery('.panel-event').fadeOut(0);
				if ( $this.val() == '00' ) {
					setTimeout(function(){
						jQuery('.panel-event').fadeIn(0);
						jQuery('#accordion').fadeIn(300);
					}, 500);
				}
				setTimeout(function(){
					jQuery('.panel-' + $this.val()).fadeIn(0);
					jQuery('#accordion').fadeIn(300);
				}, 500);
			}

			// select region
			if ($this.attr('id') == "region") {
				jQuery('#accordion').fadeOut(0);
				jQuery('.panel-event').fadeOut(0);
				if ( $this.val() == '00' ) {
					setTimeout(function(){
						jQuery('.panel-event').fadeIn(0);
						jQuery('#accordion').fadeIn(300);
					}, 500);
				}
				setTimeout(function(){
					jQuery('.panel-region-' + $this.val()).fadeIn(0);
					jQuery('#accordion').fadeIn(300);
				}, 500);
			}
		});

		jQuery(document).click(function() {
			$styledSelect.removeClass('active');
			$list.hide();
		});

	});

var actag = jQuery('.vc_tta.vc_tta-accordion .vc_tta-panel .vc_tta-panel-title a');
if ( actag.parent().is('strong') ) {
	actag.unwrap();
}

})


$('.owl-carousel').owlCarousel({
	loop:true,
	margin:0,
	dots:false,
	nav:true,
	center: true,
	autoplay:true,
	autoplayTimeout:3000,
	autoplayHoverPause:true,
	responsive:{
		0:{
			items:1
		},
		600:{
			items:3
		},
		1000:{
			items:5
		}
	}
})

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
})

if ( $('.actus-mobile').length ) {
	$('.actus-mobile').owlCarousel({
		loop:false,
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
				items:2
			},
			1200:{
				items:1
			}

		}
	});
}

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

$('.courses').owlCarousel({
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
			items:1
		},
		1000:{
			items:1
		},
		1200:{
			items:1
		}

	}
})

/*

$(window).scroll(function() {

var scroll = $(window).scrollTop();
var wht = $( window ).height();
if (scroll >= wht) {
$("#header").addClass("darkHeader");
} else {
$("#header").removeClass("darkHeader");
}

});
*/
/*================ select end =================*/

/* JWC */
function demoFromHTML(divid) {

	var doc = new jsPDF();

	var y = 20;
	var title = jQuery(divid).find('h2').text();
	var nom = jQuery(divid).find('h2 .nom').text();
	var discipline = jQuery(divid).find('.discipline').text();
	var infos = jQuery(divid).find('.athlete-infos').text();
	var quoting = jQuery(divid).find('.quoting').text();
	var entraineur1 = jQuery(divid).find('.entraineur1').text();
	var entraineur2 = jQuery(divid).find('.entraineur2').text();
	var structure = jQuery(divid).find('.structure').text();
	var club = jQuery(divid).find('.club').text();
	var licence = jQuery(divid).find('.licence').text();
	var palmares = jQuery(divid).find('.palmares').text();

	discipline = discipline.trim();
	infos = infos.replace(/^ +/gm, '');
	quoting = quoting.replace(/^ +/gm, '');
  // cut every 16 words
  // quoting = quoting.split(/((?:\w+ ){16})/g).filter(Boolean).join("\n");
  quoting = quoting.split(" ");
  var sstr = '';
  var currentlinecar = 0, currentline = 0;
  for ( var i = 0; i < quoting.length; i++ ) {
  	currentlinecar = currentlinecar + quoting[i].length;
  	if ( quoting[i].indexOf("\n") !== -1 ) {
  		currentlinecar = 0;
  		currentline = 0;
  	}
  	if ( (currentline + 1) % 16 == 0 && currentlinecar < 70 ) {
  		sstr += '\n';
  		currentlinecar = 0;
  		currentline = 0;
  	}
  	else if ( currentlinecar >= 70 ) {
  		sstr += '\n';
  		currentlinecar = 0;
  		currentline = 0;
  	}
  	else {
  		currentline = currentline + 1;
  	}
  	sstr += quoting[i] + " ";
  }
  // cut every 80 chars
	// quoting = quoting.replace(/(.{80})/g, "$1\n");
  // cut every 16 words
  // quoting = quoting.replace(/((?:\w+ ){16})/g, "$1\n");
  var lines = sstr.split("\n");
  var countLines = lines.length;
  entraineur1 = entraineur1.trim();
  entraineur2 = entraineur2.trim();
  structure = structure.trim();
  club = club.trim();
  licence = licence.trim();
  palmares = palmares.replace(/^ +/gm, '');

  doc.setFontSize(22);
  doc.text(15, y, title);
  doc.setFontSize(12);
  y = y + 8;
  doc.text(15, y, discipline);
  doc.setFontSize(20);
  y = y + 14;
  doc.text(15, y, "L'athlète");
  doc.setFontSize(12);
  y = y + 4;
  doc.text(15, y, infos);
  if (quoting != "") {
  	y = y + 22;
  	doc.text(15, y, sstr);
  }
  doc.setFontSize(20);
  if (countLines < 30) {
  	y = y + (5 * countLines);
  }
  else {
  	doc.addPage();
  	y = 20;
  }
  doc.text(15, y, "L'encadrement");
  doc.setFontSize(12);
  y = y + 1;
  doc.text(15, y, entraineur1);
  y = y + 8;
  doc.text(15, y, entraineur2);
  y = y + 8;
  doc.text(15, y, structure);
  y = y + 8;
  doc.text(15, y, club);
  y = y + 8;
  doc.text(15, y, licence);
  doc.setFontSize(20);
  y = y + 14;
  doc.text(15, y, "Le palmarès");
  doc.setFontSize(12);
  y = y + 4;
  doc.text(15, y, palmares);

  doc.save('athlete-' + nom + '.pdf');





	// var pdf = new jsPDF('p', 'pt', 'letter')
	//
	// // source can be HTML-formatted string, or a reference
	// // to an actual DOM element from which the text will be scraped.
	// , source = jQuery(divid)[0]
	//
	// // we support special element handlers. Register them with jQuery-style
	// // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
	// // There is no support for any other type of selectors
	// // (class, of compound) at this time.
	// , specialElementHandlers = {
	// 	// element with id of "bypass" - jQuery style selector
	// 	'#bypassme': function(element, renderer){
	// 		// true = "handled elsewhere, bypass text extraction"
	// 		return true
	// 	}
	// }
	//
	// margins = {
	//     top: 80,
	//     bottom: 60,
	//     left: 40,
	//     width: 522
	//   };
	//   // all coords and widths are in jsPDF instance's declared units
	//   // 'inches' in this case
	//   pdf.fromHTML(
	//   	source // HTML string or DOM elem ref.
	//   	, margins.left // x coord
	//   	, margins.top // y coord
	//   	, {
	//   		'width': margins.width // max width of content on PDF
	//   		, 'elementHandlers': specialElementHandlers
	//   	},
	//   	function (dispose) {
	//   	  // dispose: object with X, Y of the last line add to the PDF
	//   	  //          this allow the insertion of new lines after html
	//         pdf.save('Test.pdf');
	//       },
	//   	margins
	//   )
}
