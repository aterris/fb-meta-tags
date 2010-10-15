<?php
/*
Plugin Name: FB Meta Tags
Plugin URI: http://blueprintds.com
Description: Ensure your posts are shared correctly on Facebook by setting these meta tags
Version: 0.1
Author: Andrew Terris and Eric Marden
Author URI: http://blueprintds.com
*/

//Setup Inital Settings
register_activation_hook(__FILE__,fbmeta_init);
function fbmeta_init()
{
	add_option('facebook_image',WP_PLUGIN_URL . '/fbmetatags/default.png');
}

//Output Facebook Meta
add_action('wp_head', 'fbmeta_output_tags');
function fbmeta_output_tags()
{
	if ( is_single() )
	{
		global $post;
		
		//Get Options
	    $facebook_id = get_option('facebook_id');
		$facebook_image = get_option('facebook_image');
		
		
		//Set General Meta Data
		?>
		<meta property="og:title" content="<?php echo $post->post_title; ?> " />
		<meta property="og:type" content="article" />
		<meta property="og:url" content="<?php echo get_permalink($post->ID) ?>" />
		<meta property="og:site_name" content="<?php echo get_bloginfo('name') ?>" />
		<meta property="og:fb:admins" content="<?php echo $facebook_id ?>" />
		<?php 
		
		
		//Set Description
		$excerpt = ( $post->post_excerpt ) ? $post->post_excerpt : substr($post->post_content,0,250) ; 
		?>		
		<meta property="og:description" content="<?php echo $excerpt; ?>" />
		<?php
		
			
		//Set Facebook Image
		if(has_post_thumbnail($post->ID))
		{
			$thumbnail = get_the_post_thumbnail($post->ID);
			preg_match("/(?<=src=['|\"])[^'|\"]*?(?=['|\"])/i",$thumbnail,$thumbnail_path);
			
			?>
			<meta property="og:image" content="<?php echo $thumbnail_path[0] ?>" /> 
			<?php
		}
		else //Use Default
		{
			?>
			<meta property="og:image" content="<?php echo $facebook_image ?>" /> 
			<?php
			
		}
		
	}
}

//Create Options Panel
add_action('admin_menu', 'fbmeta_options_setup');
function fbmeta_options_setup()
{
	add_options_page("Facebook Meta Options", "Facebook Meta", 1, "facebook_meta", "fbmeta_options_create");
} 

function fbmeta_options_create()
{
	?>
	
	<div class="wrap">
		<h2>Facebook Meta</h2>
		
		<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		
		<table class="form-table">
			
			<tr valign="top">
			<th scope="row">Facebook ID</th>
			<td><input type="text" style="width: 60%;" name="facebook_id" value="<?php echo get_option('facebook_id'); ?>" /></td>
			</tr>
			
			<tr valign="top">
			<th scope="row">Default Image</th>
			<td><input type="text" style="width: 60%;" name="facebook_image" value="<?php echo get_option('facebook_image'); ?>" /></td>
			</tr>
			
		</table>
		
		<input type="hidden" name="action" value="update" />
		
		<input type="hidden" name="page_options" value="facebook_id,facebook_image," />
		
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
		</form>
	</div>
	
	<?php
}
?>