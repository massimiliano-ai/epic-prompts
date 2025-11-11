<?php
/**
 * Custom Taxonomies
 */

if (!defined('ABSPATH')) {
    exit;
}

class EP_Taxonomies {

    /**
     * Register all taxonomies
     */
    public static function register() {
        self::register_ai_platform();
        self::register_prompt_category();
        self::register_prompt_tags();
    }

    /**
     * Register AI Platform taxonomy
     */
    private static function register_ai_platform() {
        $labels = array(
            'name'              => __('AI Platforms', 'epic-prompts'),
            'singular_name'     => __('AI Platform', 'epic-prompts'),
            'search_items'      => __('Search Platforms', 'epic-prompts'),
            'all_items'         => __('All Platforms', 'epic-prompts'),
            'edit_item'         => __('Edit Platform', 'epic-prompts'),
            'update_item'       => __('Update Platform', 'epic-prompts'),
            'add_new_item'      => __('Add New Platform', 'epic-prompts'),
            'new_item_name'     => __('New Platform Name', 'epic-prompts'),
            'menu_name'         => __('AI Platforms', 'epic-prompts'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'platform'),
            'show_in_rest'      => true,
        );

        register_taxonomy('ai_platform', array('ai_prompt'), $args);

        // Insert default terms
        add_action('init', array(__CLASS__, 'insert_default_platforms'), 20);
    }

    /**
     * Register Prompt Category taxonomy
     */
    private static function register_prompt_category() {
        $labels = array(
            'name'              => __('Prompt Categories', 'epic-prompts'),
            'singular_name'     => __('Prompt Category', 'epic-prompts'),
            'search_items'      => __('Search Categories', 'epic-prompts'),
            'all_items'         => __('All Categories', 'epic-prompts'),
            'parent_item'       => __('Parent Category', 'epic-prompts'),
            'parent_item_colon' => __('Parent Category:', 'epic-prompts'),
            'edit_item'         => __('Edit Category', 'epic-prompts'),
            'update_item'       => __('Update Category', 'epic-prompts'),
            'add_new_item'      => __('Add New Category', 'epic-prompts'),
            'new_item_name'     => __('New Category Name', 'epic-prompts'),
            'menu_name'         => __('Categories', 'epic-prompts'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'category'),
            'show_in_rest'      => true,
        );

        register_taxonomy('prompt_category', array('ai_prompt'), $args);

        // Insert default terms
        add_action('init', array(__CLASS__, 'insert_default_categories'), 20);
    }

    /**
     * Register Prompt Tags taxonomy
     */
    private static function register_prompt_tags() {
        $labels = array(
            'name'          => __('Prompt Tags', 'epic-prompts'),
            'singular_name' => __('Prompt Tag', 'epic-prompts'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'tag'),
            'show_in_rest'      => true,
        );

        register_taxonomy('prompt_tag', array('ai_prompt'), $args);
    }

    /**
     * Insert default AI platforms
     */
    public static function insert_default_platforms() {
        $platforms = array(
            'Midjourney v5',
            'Midjourney v6',
            'Midjourney v7',
            'DALL-E 2',
            'DALL-E 3',
            'Stable Diffusion XL',
            'Stable Diffusion 3',
            'Leonardo.ai',
        );

        foreach ($platforms as $platform) {
            if (!term_exists($platform, 'ai_platform')) {
                wp_insert_term($platform, 'ai_platform');
            }
        }
    }

    /**
     * Insert default prompt categories
     */
    public static function insert_default_categories() {
        $categories = array(
            'Character Design',
            'Landscapes',
            'Product Photography',
            'Logo & Branding',
            'Fantasy Art',
            'Portraits',
            'Architecture',
            'Abstract Art',
            'Concept Art',
            'Fashion & Style',
        );

        foreach ($categories as $category) {
            if (!term_exists($category, 'prompt_category')) {
                wp_insert_term($category, 'prompt_category');
            }
        }
    }
}
