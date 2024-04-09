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
		toggle: () => {
			const context = getContext();
			context.isOpen = ! context.isOpen;
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
