//jQuery( document ).ready( function() {
jQuery(function($){
	$( '.controls#caboodle-img-container li img' ).click( function() {
		$( '.controls#caboodle-img-container li' ).each( function() {
			$( this ).find( 'img' ).removeClass( 'caboodle-radio-img-selected' );
		});
		$( this ).addClass( 'caboodle-radio-img-selected' );
	});
});