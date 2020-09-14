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

/**BINDINGS**/
} )( jQuery );