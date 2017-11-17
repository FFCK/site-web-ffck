jQuery(function() {
  jQuery('#adfilter').click(function(e){
    e.preventDefault();
    if ( jQuery('.job_types.too-tall').hasClass('opened') ) {
      jQuery('.filter_wide.filter_by_tag').removeClass('opened');
      jQuery('.job_types.too-tall').removeClass('opened');
      jQuery('.filter-by-type-label').removeClass('opened');
      jQuery('.filter_wide.filter_by_tag').slideUp(300);
      jQuery('.job_types.too-tall').slideUp(300);
      jQuery('.filter-by-type-label').slideUp(300);
    }
    else {
      jQuery('.filter_wide.filter_by_tag').css('height', 'auto');
      jQuery('.job_types.too-tall').css('height','auto');
      jQuery('.filter-by-type-label').css('height','auto');
      jQuery('.filter_wide.filter_by_tag').addClass('opened');
      jQuery('.job_types.too-tall').addClass('opened');
      jQuery('.filter-by-type-label').addClass('opened');
      jQuery('.filter_wide.filter_by_tag').slideDown(300);
      jQuery('.job_types.too-tall').slideDown(300);
      jQuery('.filter-by-type-label').slideDown(300);
    }
  });
});
