jQuery(window).on('load', function() {
	// Reinit when all images load to make sure gallery container is correct size
	jQuery('.cycle-slideshow').cycle('reinit');
})