<?php
/*
Plugin Name: WP2Social Auto Publish
Description: Automatically publish WordPress posts to your Facebook page with customizable message formats, filtering by category and post type, and support for images and links.
Version: 1.0.0
Author: Your Name
*/

if (!defined('ABSPATH')) exit;

class WP2Social_Auto_Publish {
    public function __construct() {
        // Admin menu
        add_action('admin_menu', [$this, 'add_settings_page']);
        // Register settings
        add_action('admin_init', [$this, 'register_settings']);
        // Hook into post publish
        add_action('publish_post', [$this, 'maybe_publish_to_facebook'], 10, 2);
        add_action('publish_page', [$this, 'maybe_publish_to_facebook'], 10, 2);
    }

    public function add_settings_page() {
        add_options_page(
            'WP2Social Auto Publish',
            'WP2Social Auto Publish',
            'manage_options',
            'wp2social-auto-publish',
            [$this, 'settings_page_html']
        );
    }

    public function register_settings() {
        register_setting('wp2social_auto_publish', 'wp2social_facebook_app_id');
        register_setting('wp2social_auto_publish', 'wp2social_facebook_app_secret');
        register_setting('wp2social_auto_publish', 'wp2social_facebook_page_token');
        register_setting('wp2social_auto_publish', 'wp2social_publish_pages');
        register_setting('wp2social_auto_publish', 'wp2social_allowed_categories');
        register_setting('wp2social_auto_publish', 'wp2social_allowed_post_types');
        register_setting('wp2social_auto_publish', 'wp2social_message_format');
    }

    public function settings_page_html() {
        ?>
        <div class="wrap">
            <h1>WP2Social Auto Publish Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('wp2social_auto_publish');
                do_settings_sections('wp2social_auto_publish');
                ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row">Facebook App ID</th>
                        <td><input type="text" name="wp2social_facebook_app_id" value="<?php echo esc_attr(get_option('wp2social_facebook_app_id')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Facebook App Secret</th>
                        <td><input type="text" name="wp2social_facebook_app_secret" value="<?php echo esc_attr(get_option('wp2social_facebook_app_secret')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Facebook Page Access Token</th>
                        <td><input type="text" name="wp2social_facebook_page_token" value="<?php echo esc_attr(get_option('wp2social_facebook_page_token')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Enable Page Publishing</th>
                        <td><input type="checkbox" name="wp2social_publish_pages" value="1" <?php checked(1, get_option('wp2social_publish_pages'), true); ?> /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Allowed Categories (comma separated IDs)</th>
                        <td><input type="text" name="wp2social_allowed_categories" value="<?php echo esc_attr(get_option('wp2social_allowed_categories')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Allowed Post Types (comma separated)</th>
                        <td><input type="text" name="wp2social_allowed_post_types" value="<?php echo esc_attr(get_option('wp2social_allowed_post_types')); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Message Format</th>
                        <td><textarea name="wp2social_message_format" rows="4" cols="50"><?php echo esc_textarea(get_option('wp2social_message_format', '{post_title}\n{permalink}')); ?></textarea><br>
                        <small>Available tags: {post_title}, {post_description}, {post_excerpt}, {permalink}, {blog_title}, {user_nickname}, {post_id}, {post_date}, {user_display_name}</small></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }

    public function maybe_publish_to_facebook($ID, $post) {
        // Filtering logic and Facebook API integration will go here
    }
}

new WP2Social_Auto_Publish();
