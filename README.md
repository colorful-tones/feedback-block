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
