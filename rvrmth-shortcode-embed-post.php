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
 * [embed-post id=1234 show_featured_image=true show_title=true]
 */

function rvrmth_shortcode_embed_post($atts)
{
	$a = shortcode_atts(array(
		'id' => 0,
		'show_featured_image' => true,
		'show_title' => true,
	), $atts, 'rvrmth_shortcode_embed_post');
	global $post;

	$post_object = get_post($a['id']);
	$curr_lang_post_object_ID = apply_filters( 'wpml_object_id', $post_object->ID, $post_object->post_type, false, NULL);
	if (isset($curr_lang_post_object_ID)) {
		$post_object = get_post($curr_lang_post_object_ID);
	}

	$post = $post_object;
	setup_postdata($post);
	$html = __rvrmth_shortcode_embed_post_html($a);
	wp_reset_postdata();
	return $html;
}
add_shortcode('embed-post', 'rvrmth_shortcode_embed_post');

function __rvrmth_shortcode_embed_post_html(&$attrs)
{
	if (function_exists('rvrmth_shortcode_embed_post_html')) {
		return rvrmth_shortcode_embed_post_html($attrs);
	}
	$fn = function($func) {
		return $func;
	};
	$html = '<article>';
	if ($attrs['show_featured_image']) {
		$html .= get_the_post_thumbnail();
	}
	if ($attrs['show_title']) {
		$html .= '<h1>' . get_the_title() . '</h1>';
	}
	$html .= get_the_content() . '</article>';
	return $html;
}

?>
