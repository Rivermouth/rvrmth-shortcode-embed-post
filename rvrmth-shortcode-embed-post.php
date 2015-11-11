<?php
/*
Plugin Name: Shortcode: Embed post
Plugin URI:  http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Embed post in content
Version:     0.1
Author:      Rivermouth Ltd
Author URI:  http://rivermouth.fi
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: rvrmth-shortcode-embed-post
*/

/**
 * Used in carousel.
 *
 * [embed-post id="1234"]
 */

function rvrmth_shortcode_embed_post($atts) 
{
	$a = shortcode_atts(array(
		'id' => 0,
	), $atts);
	global $post;
	$post_object = get_post($a['id']);
	$post = $post_object;
	setup_postdata($post);
	$html = __rvrmth_shortcode_embed_post_html();
	wp_reset_postdata();
	return $html;
}
add_shortcode('embed-post', 'rvrmth_shortcode_embed_post');

function __rvrmth_shortcode_embed_post_html() 
{
	if (function_exists('rvrmth_shortcode_embed_post_html')) {
		return rvrmth_shortcode_embed_post_html();
	}
	$fn = function($func) {
		return $func;
	};
	return <<<EOT
<article>
	<h1>{$fn(get_the_title())}</h1>
	{$fn(get_the_content())}
</article>
EOT;
}

?>
