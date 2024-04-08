<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */

/**
 * Checks if the 'postId' key is set in the context of the block.
 * If it is not set, returns an empty string.
 *
 * @param object $block The block object.
 * @return string The rendered content or an empty string.
 */
if ( ! isset( $block->context['postId'] ) ) {
	return '';
}

/**
 * Sets up the server context for rendering the feedback block.
 *
 * The server context includes the post ID, AJAX URL, and nonce for the feedback block.
 *
 * @param array $block The block context.
 * @return array The server context.
 */
$server_context = array(
	'postId'  => $block->context['postId'],
	'ajaxUrl' => admin_url( 'admin-ajax.php' ),
	'nonce'   => wp_create_nonce( 'feedback_block_nonce' ),
);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-watch="callbacks.logIsOpen"
	data-wp-interactive="feedback-block"
	<?php echo wp_interactivity_data_wp_context( $server_context ); ?>
>
	<button
		data-wp-on--click="actions.toggle"
		data-wp-bind--aria-expanded="context.isOpen"
	>
		<?php esc_html_e( 'Toggle', 'feedback-block' ); ?>
	</button>

	<p
		data-wp-bind--hidden="!context.isOpen"
	>
		<?php
			esc_html_e( 'Feedback Block - hello from an interactive block!', 'feedback-block' );
		?>
	</p>
</div>
