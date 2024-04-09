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
	},
	actions: {
		toggle: () => {
			const context = getContext();
			context.isOpen = ! context.isOpen;
		},
	},
	callbacks: {
		logPostId: () => {
			const { postId } = getContext();
			// Log the value of `isOpen` each time it changes.
			console.log( `Post ID: ${ postId }` );
		},
	},
} );
