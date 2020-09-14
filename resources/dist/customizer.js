String.prototype.nl2br = function()
{
	return this.replace(/\n/g, "<br />");
};


/**
 * Extract language slug from lang attribute
 */
function get_current_lang() {
  let langAttr = $( 'html' ).attr( 'lang' );
  let slug = 'en';

  if ( langAttr.length > 0 ) {
    slug = langAttr.substr(0,1);
  }

  return slug;
}


/**
 * Live replacement
 */
( function( $ ) {

	wp.customize( 'idkomm_contact_info_address', function( value ) {
		value.bind( function( new_value ) {
			$('.contact-info-address').html(new_value.nl2br());
		} );
	} );
	wp.customize( 'idkomm_selector', function( value ) {
		value.bind( function( new_value ) {
			$('.contact-info-selector').html(new_value.nl2br());
		} );
	} );
	wp.customize( 'idkomm_footer_text_colour', function( value ) {
		value.bind( function( new_value ) {
			$('#site-footer').css('color', new_value);
		} );
	} );
	wp.customize( 'idkomm_footer_background_colour', function( value ) {
		value.bind( function( new_value ) {
			$('#site-footer').css('background-color', new_value);
		} );
	} );

} )( jQuery );