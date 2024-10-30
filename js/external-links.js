document.addEventListener("DOMContentLoaded", function () {

	// Select all links in the document
	var links = document.querySelectorAll('a');
	
	// Iterate over each link
	for (var i = 0; i < links.length; i++) {
	    var a = links[i];
	
	    // Check if the link is external
	    if (a.hostname !== window.location.hostname) {
	        // Add the target and rel attributes
	        a.target = '_blank';
	        a.rel = 'noopener noreferrer nofollow';
	    }
	}

});