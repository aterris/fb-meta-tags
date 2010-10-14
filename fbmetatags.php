<?php
/*
Plugin Name: FB Meta Tags
Plugin URI: http://blueprintds.com
Description: Ensure your posts are shared correctly on Facebook by setting these meta tags
Version: 0.1
Author: Andrew Terris and Eric Marden
Author URI: http://blueprintds.com
*/

add_action('wp_head', 'fbmeta_output_tags');
function fbmeta_output_tags()
{
	if ( is_single() ):
	global $post;
?>
	<meta property="og:title" content="<?php echo $post->post_title; ?> " />
	<meta property="og:description" content="<?php echo $post->post_exceprt; ?>" />
	<meta property="og:image" content="thumbnail_image" /> <!-- set to default if post_thumbnail doesn't exist -->
<?php

// create quick options panel that allows you to set the default thumbnail
}
?>