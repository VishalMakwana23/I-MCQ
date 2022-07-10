jQuery(function($) {

	// QWERTY Text Input
	// The bottom of this file is where the autocomplete extension is added
	// ********************
	$('#text').keyboard({ layout: 'qwerty' });
	// International Text Area
	// ********************
	

$('#inter').keyboard({
		stayOpen : true,
		layout   : 'qwerty'
	});
});
