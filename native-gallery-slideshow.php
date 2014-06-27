<?php
/**
* Plugin Name: Native Gallery Slideshow
* Plugin URI: http://www.cuberis.com
* Description: Adds a select box to the native WordPress gallery screen, which allows you to choose between the default grid style gallery or slideshow. Uses Cycle2 for the slideshow functionality.
* Version: 1.0
* Author: Alisa R. Herr
* Author URI: http://www.cuberis.com
* License: GPL2
*/

/**
 *	Custom shortcode for gallery
 */

include( plugin_dir_path(__FILE__) . 'custom-gallery-shortcode.php' );

/**
 *	Enqueue styles & scripts
 */

add_action('wp_enqueue_scripts', 'ngs_enqueue_scripts');

function ngs_enqueue_scripts() {
	wp_enqueue_style( 'ngs-style', plugins_url( 'css/style.css', __FILE__ ) );
	wp_enqueue_script( 'cycle2', plugins_url( 'js/jquery.cycle2.js', __FILE__ ), array( 'jquery' ), '2.1.5', true );
	wp_enqueue_script( 'cycle2-swipe', plugins_url( 'js/jquery.cycle2.swipe.min.js', __FILE__ ), array( 'jquery', 'cycle2' ), '20140128', true );
	wp_enqueue_script( 'ngs-scripts', plugins_url( 'js/custom.js', __FILE__ ), array( 'jquery', 'cycle2' ), '1.0', true );
}

/** 
 *	Add the options to the gallery screen in the WordPress media manager
 *	Code courtesy onetrickpony: http://wordpress.stackexchange.com/a/90443/35628
 */

add_action( 'print_media_templates', 'ngs_add_gallery_options' );

function ngs_add_gallery_options() {

	// define your backbone template
	?>
	<script type="text/html" id="tmpl-ngs-custom-gallery-options">
		<label class="setting">
		<span><?php _e('Size'); ?></span>
		<select data-setting="size">
		<option value="thumbnail">Thumbnail</option>
		<option value="medium">Medium</option>
		<option value="large">Large</option>
		<option value="full">Full</option>
		</select>
		</label>
		<label class="setting">
		<span><?php _e('Type'); ?></span>
		<select data-setting="type">
		<option value="grid">Grid</option>
		<option value="slideshow">Slideshow</option>
		</select>
		</label>
	</script>

	<script>
		jQuery(document).ready(function(){

			// add your shortcode attribute and its default value to the gallery settings list;
			_.extend(wp.media.gallery.defaults, {
				size: 'thumbnail',
				type: 'grid',
				link: 'file'
			});

			// merge default gallery settings template with yours
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend({
				template: function(view){
					return wp.media.template('gallery-settings')(view)
						+ wp.media.template('ngs-custom-gallery-options')(view);
				}
			});

		});
	</script>
	<?php

}