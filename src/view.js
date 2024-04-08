/**
 * WordPress dependencies
 */
import { store, getContext } from '@wordpress/interactivity';

store( 'feedback-block', {
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
