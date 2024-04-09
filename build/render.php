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

/**
 * Sets up the user sentiments for the feedback block.
 *
 * The user sentiments include the ID, label, and icon for each sentiment.
 *
 * @var array $user_sentiments The user sentiments for the feedback block.
 */
$user_sentiments = array(
	array(
		'id'    => 'loveIt',
		'label' => __( 'Love it' ),
		'icon'  => '<svg height="16" stroke-linejoin="round" viewBox="0 0 16 16" width="16"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM4.5 8.97498H3.875V9.59998C3.875 11.4747 5.81046 12.8637 7.99817 12.8637C10.1879 12.8637 12.125 11.4832 12.125 9.59998V8.97498H11.5H4.5ZM7.99817 11.6137C6.59406 11.6137 5.63842 10.9482 5.28118 10.225H10.7202C10.3641 10.9504 9.40797 11.6137 7.99817 11.6137Z" fill="currentColor"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M6.15295 4.92093L5.375 3.5L4.59705 4.92093L3 5.21885L4.11625 6.39495L3.90717 8L5.375 7.30593L6.84283 8L6.63375 6.39495L7.75 5.21885L6.15295 4.92093ZM11.403 4.92093L10.625 3.5L9.84705 4.92093L8.25 5.21885L9.36625 6.39495L9.15717 8L10.625 7.30593L12.0928 8L11.8837 6.39495L13 5.21885L11.403 4.92093Z" fill="var(--feedback-block-svg-fill--love-it)"></path></svg>',
	),
	array(
		'id'    => 'itsOk',
		'label' => __( 'It is okay' ),
		'icon'  => '<svg height="16" stroke-linejoin="round" viewBox="0 0 16 16" width="16"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM11.5249 10.8478L11.8727 10.3286L10.8342 9.6329L10.4863 10.1522C9.94904 10.9543 9.0363 11.4802 8.00098 11.4802C6.96759 11.4802 6.05634 10.9563 5.51863 10.1567L5.16986 9.63804L4.13259 10.3356L4.48137 10.8542C5.2414 11.9844 6.53398 12.7302 8.00098 12.7302C9.47073 12.7302 10.7654 11.9816 11.5249 10.8478ZM6.75 6.75C6.75 7.30228 6.30228 7.75 5.75 7.75C5.19772 7.75 4.75 7.30228 4.75 6.75C4.75 6.19772 5.19772 5.75 5.75 5.75C6.30228 5.75 6.75 6.19772 6.75 6.75ZM10.25 7.75C10.8023 7.75 11.25 7.30228 11.25 6.75C11.25 6.19772 10.8023 5.75 10.25 5.75C9.69771 5.75 9.25 6.19772 9.25 6.75C9.25 7.30228 9.69771 7.75 10.25 7.75Z" fill="currentColor"></path></svg>',
	),
	array(
		'id'    => 'notGreat',
		'label' => __( 'Not great' ),
		'icon'  => '<svg height="16" stroke-linejoin="round" viewBox="0 0 16 16" width="16"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 8C14.5 11.5899 11.5899 14.5 8 14.5C4.41015 14.5 1.5 11.5899 1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8ZM16 8C16 12.4183 12.4183 16 8 16C3.58172 16 0 12.4183 0 8C0 3.58172 3.58172 0 8 0C12.4183 0 16 3.58172 16 8ZM5.75 7.75C6.30228 7.75 6.75 7.30228 6.75 6.75C6.75 6.19772 6.30228 5.75 5.75 5.75C5.19772 5.75 4.75 6.19772 4.75 6.75C4.75 7.30228 5.19772 7.75 5.75 7.75ZM11.25 6.75C11.25 7.30228 10.8023 7.75 10.25 7.75C9.69771 7.75 9.25 7.30228 9.25 6.75C9.25 6.19772 9.69771 5.75 10.25 5.75C10.8023 5.75 11.25 6.19772 11.25 6.75ZM11.5249 11.2622L11.8727 11.7814L10.8342 12.4771L10.4863 11.9578C9.94904 11.1557 9.0363 10.6298 8.00098 10.6298C6.96759 10.6298 6.05634 11.1537 5.51863 11.9533L5.16986 12.4719L4.13259 11.7744L4.48137 11.2558C5.2414 10.1256 6.53398 9.37982 8.00098 9.37982C9.47073 9.37982 10.7654 10.1284 11.5249 11.2622Z" fill="currentColor"></path></svg>',
	),
	array(
		'id'    => 'hateIt',
		'label' => __( 'Hate it' ),
		'icon'  => '<svg height="16" stroke-linejoin="round" viewBox="0 0 16 16" width="16"><path fill-rule="evenodd" clip-rule="evenodd" d="M4 9V16H5.5V9H4ZM12 9V16H10.5V9H12Z" fill="var(--feedback-block-svg-fill--hate-it)"></path><path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 8C1.5 4.41015 4.41015 1.5 8 1.5C11.5899 1.5 14.5 4.41015 14.5 8C14.5 9.57941 13.9367 11.0273 13 12.1536V14.2454C14.8289 12.7793 16 10.5264 16 8C16 3.58172 12.4183 0 8 0C3.58172 0 0 3.58172 0 8C0 10.5264 1.17107 12.7793 3 14.2454V12.1536C2.06332 11.0273 1.5 9.57941 1.5 8ZM8 14.5C8.51627 14.5 9.01848 14.4398 9.5 14.3261V15.8596C9.01412 15.9518 8.51269 16 8 16C7.48731 16 6.98588 15.9518 6.5 15.8596V14.3261C6.98152 14.4398 7.48373 14.5 8 14.5ZM3.78568 8.36533C4.15863 7.98474 4.67623 7.75 5.25 7.75C5.82377 7.75 6.34137 7.98474 6.71432 8.36533L7.78568 7.31548C7.14222 6.65884 6.24318 6.25 5.25 6.25C4.25682 6.25 3.35778 6.65884 2.71432 7.31548L3.78568 8.36533ZM10.75 7.75C10.1762 7.75 9.65863 7.98474 9.28568 8.36533L8.21432 7.31548C8.85778 6.65884 9.75682 6.25 10.75 6.25C11.7432 6.25 12.6422 6.65884 13.2857 7.31548L12.2143 8.36533C11.8414 7.98474 11.3238 7.75 10.75 7.75ZM6.25 12H9.75C9.75 11.0335 8.9665 10.25 8 10.25C7.0335 10.25 6.25 11.0335 6.25 12Z" fill="currentColor"></path></svg>',
	),
);
?>

<div
	<?php echo get_block_wrapper_attributes(); ?>
	data-wp-interactive="feedback-block"
	<?php echo wp_interactivity_data_wp_context( $server_context ); ?>
>

	<div class="feedback-block__trigger-bar">
		<p class="feedback-block__question"><?php echo esc_html_e( 'Was this helpful?', 'feedback-block' ); ?></p>

		<span class="feedback-block__sentiments">
			<?php foreach ( $user_sentiments as $sentiment ) : ?>
				<button
					aria-controls="feedback-block-drawer"
					aria-label="Select <?php echo esc_html( $sentiment['label'] ); ?> as your sentiment"
					class="feedback-block__sentiment"
					data-wp-bind--aria-checked="!context.isFormHidden"
					data-wp-class--selected="context.isSelected"
					data-wp-on--click="actions.toggleForm"
					data-wp-run--update-selected="actions.updateSelected"
					data-checked-value="<?php echo esc_html( $sentiment['label'] ); ?>"
					role="radio"
					type="button"
				>
					<?php echo $sentiment['icon']; // phpcs:ignore ?>
				</button>
			<?php endforeach; ?>
		</span>
	</div><!-- .feedback-block__trigger-bar -->

	<div
		class="feedback-block__drawer"
		data-wp-bind--hidden="context.isFormHidden"
		data-wp-class--expanded="context.isFormHidden"
		id="feedback-block-drawer"
	>

		<div
			class="feedback-block__status"
			data-wp-bind--hidden="!context.isFormProcessing"
			data-wp-class--error="state.hasError"
			data-wp-class--success="state.hasSuccess"
		>
			<p
				class="feedback-block__status-message"
				data-wp-text="state.formMessage"
			></p>
		</div>

		<form
			data-wp-on--submit="actions.submitForm"
			data-wp-watch="callback.focusField"
			id="feedback-form"
		>
			<div class="feedback-block__form-inner">
				<textarea
					class="feedback-block__textarea"
					cols="45"
					id="feedback"
					name="feedback"
					placeholder="<?php esc_html_e( 'Your feedback...', 'feedback-form' ); ?>"
					required
					rows="8"
					spellcheck="false"
				></textarea>

				<input
					data-wp-bind--value="context.currentlySelected"	
					id="feedback-form-selected-sentiment"
					name="feedback-form-selected-sentiment"
					type="hidden"
				/>
			</div>
			
			<div class="feedback-block__form-actions">
				<button
					class="feedback-block__submit-button"
					type="submit"
				>
					<?php esc_html_e( 'Send', 'feedback-form' ); ?>
				</button>
			</div>
		</form>
	</div><!-- .feedback-block__drawer -->

</div>
