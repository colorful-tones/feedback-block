# Feedback Block

This block was created to demonstrate how developers can utilize the [Create Block](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-create-block/) package to scaffold a new block with the Interactivity API.

> Create Block is an **officially supported tool for scaffolding a WordPress plugin that registers a block**. It generates PHP, JS, CSS code, and everything you need to start the project. It also integrates a modern build setup with no configuration.

This repository is organized so that each branch represents sequential changes to the codebase. Hopefully this helps developers review and learn how to create similar blocks.

Each branch should be name like this `step-1`, `step-2`, `step-3`, etc.

Each branch's `README` will provide the new changes made in that step.

## `step-0` - Generate block with Create Block

As stated in the Wordpress Developer Resources -> Block Editor Handbook -> Reference Guides -> Package Reference -> `@wordpress/interactivity` - [Scaffold an interactive block](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-interactivity/#scaffold-an-interactive-block)

```bash
npx @wordpress/create-block@latest feedback-block --short-description "Feedback block for single posts" --template @wordpress/create-block-interactive-template
```

Running this command will create a new WordPress plugin with the necessary and helpful `@wordpress/scripts` package installed as developer dependencies and the `@wordpress/interactivity` as a dependency. It also creates a new custom block with the slug `feedback-block`, and the `--short-description "Feedback block for single posts"` for the plugin and the block.

## `step-1` - Include postId and begin establishing local state

1. Update our block's `block.json` definitions to include `"usesContext": [ "postId" ]`. Since we'll be placing our block on a single post type and we want to reference the postId for that post type then we'll need to pass it down in our block definitions.
2. Update the `render.php` for our block to do an early check for `if ( ! isset( $block->context['postId'] ) )`
3. Add `$server_context` array to establish server side context that we can pass into and also establish local state (`context`) for the Interactivity API's store.
4. Pass the `$server_context` into `wp_interactivity_data_wp_context()` to establish client side local state.
5. Update the block's Interactivity API slug to align with our block's intent and custom functionality. This slug is a [critical piece for initializing the Interactivity API on our DOM node](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-interactivity/packages-interactivity-api-reference/#wp-interactive).
6. Remove the Create Block scaffold's use of `$unique_id`, as we will not need it here.
7. Update the Create Block's example `logIsOpen` callback to `logPostId` so we can simply verify that everything is working in the console.

## `step-2` - Add toggle bar markup, styling and user sentiments

1. Add a `$user_sentiments` array, which contains our feedback options (`id`, `label`, `icon`).
2. Add in HTML markup with Interactivity API directives for the top area: `.feedback-block__trigger-bar`. These include buttons to toggle the form open and closed.
3. Add in CSS to start styling our `.feedback-block__trigger-bar` along with some CSS custom properties that we can reference.
