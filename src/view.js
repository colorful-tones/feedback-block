/**
 * WordPress dependencies
 */
import {
	store,
	getContext,
} from '@wordpress/interactivity';

const { state } = store( 'feedback-block', {
	state: {
		isFormHidden      : true,
		isFormProcessing  : false,
		currentlySelected : '',
		hasSuccess        : false,
		hasError          : false,
		formMessage       : '',
		get hasSuccess() {
			const { status } = getContext();
			return status === "success";
		},
		get hasError() {
			const { status } = getContext();
			return status === "error";
		},
		get formMessage() {
			const { status } = getContext();
			if ( status === "success" ) return "Success!";
			if ( status === "error" ) return "Error!";
		}
	},
	actions: {
		*submitForm( event ) {
			const context = getContext();
			const { ref } = getElement();

			event.preventDefault();

			const formData = new FormData( ref );
			formData.append( 'action', 'submit_feedback' );
			formData.append( 'nonce', context.nonce );
			formData.append( 'postId', context.postId );
			context.isFormProcessing = true;

			try {
				yield fetch(
					context.ajaxUrl,
					{
						method: 'POST',
						credentials: 'same-origin',
						body: formData
					}
				).then(
					r => r.text()
				)
				context.status = "success";
			} catch( error ) {
				console.error( 'Error:', error );
				context.status = "error";
			}
		},
		toggleForm() {
			const context = getContext();
			const element = getElement();
			context.isSelected = !context.isSelected;
			context.isFormHidden = !context.isFormHidden;

			if ( !context.isFormHidden ) {
				context.currentlySelected = element.attributes['data-checked-value'];
			} else {
				context.currentlySelected = '';
			}
		},
	},
	callbacks: {
		focusField() {
			const { isFormHidden } = getContext();
			const { ref } = getElement();
			
			if ( isFormHidden ) {
				ref.querySelector( 'textarea' ).focus();
			}
		}
	},
} );
