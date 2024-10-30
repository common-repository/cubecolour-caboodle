jQuery(document).ready(function($){

	$( '#import-form type[type=file]::file-selector-button' ).addClass( 'button' );
	$( '#import-form input[type=submit]' ).attr( 'disabled', true );

	$('#import-form input:file').change( function(){
		if ($(this).val()){
			$('#import-form input[type=submit]').removeAttr('disabled');
		} else {
			$('#import-form input[type=submit]').attr('disabled',true);
		}
	});

	$( "#show-caboodle-settings" ).click(function() {
		$( "#caboodle-settings" ).slideDown( "slow", function() {

		});
	});

	$( "#hide-caboodle-settings" ).click(function() {
		$( "#caboodle-settings" ).slideUp( "slow", function() {

		});
	});

});