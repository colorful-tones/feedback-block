<?php
/**
 * Plugin Name:       Feedback Block
 * Description:       Feedback block for single posts
 * Version:           0.1.0
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       feedback-block
 *
 * @package           create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_feedback_block_block_init() {
	register_block_type_from_metadata( __DIR__ . '/build' );
}
add_action( 'init', 'create_block_feedback_block_block_init' );

/**
 * Handles the submission of feedback block.
 *
 * This function is responsible for processing the feedback submission from the user.
 * It verifies the nonce, retrieves the necessary data, sends an email to the admin,
 * and returns a success or fail message.
 *
 * @return void
 */
function feedback_block_submission_handler() {
	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'feedback_block_nonce' ) ) {
		die( 'Security check failed' );
	}

	$post_id        = isset( $_POST['postId'] ) ? intval( $_POST['postId'] ) : 0;
	$post_title     = get_the_title( $post_id );
	$post_url       = get_permalink( $post_id );
	$feedback_text  = sanitize_textarea_field( $_POST['feedback'] );
	$feedback_emote = sanitize_text_field( $_POST['feedback-form-selected-sentiment'] );

	$to      = get_option( 'admin_email' );
	$subject = 'Feedback on: ' . $post_title;
	$message = "Feedback: {$feedback_text}<br> The user's sentiment was: <em>{$feedback_emote}</em> for the post titled <b><a href={$post_url}>{$post_title}</a></b>";
	$headers = array( 'Content-Type: text/html; charset=UTF-8' );

	if ( wp_mail( $to, $subject, $message, $headers ) ) {
		echo 'Success';
	} else {
		echo 'Fail';
	}

	wp_die();
}
add_action( 'wp_ajax_submit_feedback', 'feedback_block_submission_handler' );
add_action( 'wp_ajax_nopriv_submit_feedback', 'feedback_block_submission_handler' );

