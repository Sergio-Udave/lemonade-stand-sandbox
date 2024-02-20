<?php
/**
* Plugin Name: Lemonade Stand Inc
* Description: A Lemonade Stand Inc. plugin
* Version: 1.0
* Requires at least: 5.2
* Requires PHP: 7.2
* Author: Lemonade Stand Inc.
* Author URI: https://lemonadestand.org
* License: GPL v2 or later
* License URI: https://www.gnu.org/licenses/gpl-2.0.html
* GitHub Plugin URI: https://github.com/Sergio-Udave/lemonade-stand-sandbox
* Update URI: false
*/

/*
* Store the root directory path for quick reference
*/ 
define ( 'LS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Add Menus
 * 
 * This menu will appear on the left-hand side of the WordPress admin dashboard
 * where you would normally see others like "Posts", "Media", "Pages", etc. 
 * This function also adds sub-menus to the top-level menu in case it is better
 * to separate the plugin's functionality into different sections.
 */
add_action( 'admin_menu', 'lemonade_stand_create_menu' );

function lemonade_stand_create_menu() {

    // Create top-level menu
    add_menu_page(
        'Lemonade Stand Settings Page',
        'Lemonade Stand',
        'manage_options',
        'lemonade-stand',
        'lemonade_stand_settings_page',
        'dashicons-admin-generic',
        99
    );

    // Create About sub-menu
    add_submenu_page(
        'lemonade-stand',
        'About the Lemonade Stand Inc. Plugin',
        'About',
        'manage_options',
        'lemonade-stand-about',
        'lemonade_stand_about_page'
    );

    // Create OpenAI sub-menu
    add_submenu_page(
        'lemonade-stand',
        'OpenAI with the Lemonade Stand Inc. Plugin',
        'OpenAI',
        'manage_options',
        'lemonade-stand-openai',
        'lemonade_stand_openai_option_page'
    );

    // Create Uninstall sub-menu
    add_submenu_page(
        'lemonade-stand',
        'Uninstall the Lemonade Stand Inc. Plugin',
        'Uninstall',
        'manage_options',
        'lemonade-stand-uninstall',
        'lemonade_stand_uninstall_page'
    );
}

function lemonade_stand_openai_option_page() {
    ?>
    <div class="wrap">
        <h2>Open AI Options</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields( 'lemonade_stand_openai_options' );
            do_settings_sections( 'lemonade-stand-openai' );
            submit_button( 'Save Changes', 'primary' );
            ?>
        </form>
    </div>
    <?php
 }

// Register and define the settings
add_action( 'admin_init', 'lemonade_stand_admin_init' );

function lemonade_stand_admin_init() {
    $args = array(
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
        'default' => NULL
    );

    // Register the settings
    register_setting( 'lemonade_stand_openai_options', 'lemonade_stand_openai_options', $args );

    // Add a settings section
    add_settings_section(
        'lemonade_stand_openai_section',
        'OpenAI Settings',
        'lemonade_stand_openai_section_callback',
        'lemonade-stand-openai'
    );

    // Add OpenAI API Key field
    add_settings_field(
        'lemonade_stand_openai_api_key',
        'OpenAI API Key',
        'lemonade_stand_openai_api_key_callback',
        'lemonade-stand-openai',
        'lemonade_stand_openai_section'
    );

    // Add Frequency Penalty field
    add_settings_field(
        'lemonade_stand_openai_frequency_penalty',
        'Frequency Penalty',
        'lemonade_stand_openai_frequency_penalty_callback',
        'lemonade-stand-openai',
        'lemonade_stand_openai_section'
    );

    // Add Max Tokens field
    add_settings_field(
        'lemonade_stand_openai_max_tokens',
        'Max Tokens',
        'lemonade_stand_openai_max_tokens_callback',
        'lemonade-stand-openai',
        'lemonade_stand_openai_section'
    );

    // Add N field
    add_settings_field(
        'lemonade_stand_openai_n',
        'N',
        'lemonade_stand_openai_n_callback',
        'lemonade-stand-openai',
        'lemonade_stand_openai_section'
    );

    // Add Presence Penalty field
    add_settings_field(
        'lemonade_stand_openai_presence_penalty',
        'Presence Penalty',
        'lemonade_stand_openai_presence_penalty_callback',
        'lemonade-stand-openai',
        'lemonade_stand_openai_section'
    );

    // Add Temperature field
    add_settings_field(
        'lemonade_stand_openai_temperature',
        'Temperature',
        'lemonade_stand_openai_temperature_callback',
        'lemonade-stand-openai',
        'lemonade_stand_openai_section'
    );

    // Add Top P field
    add_settings_field(
        'lemonade_stand_openai_top_p',
        'Top P',
        'lemonade_stand_openai_top_p_callback',
        'lemonade-stand-openai',
        'lemonade_stand_openai_section'
    );
}

// Draw the section header
function lemonade_stand_openai_section_callback() {
    echo '<p>Enter your OpenAI API Settings Here:</p>';
}

function lemonade_stand_openai_frequency_penalty_callback() {
    $settings = get_option('lemonade_stand_openai_options');
    ?>
    <input type="number" step="0.01" min="0" max="1" name="lemonade_stand_openai_options[lemonade_stand_openai_frequency_penalty]" value="<?php echo isset($settings['lemonade_stand_openai_frequency_penalty']) ? esc_attr($settings['lemonade_stand_openai_frequency_penalty']) : ''; ?>">
    <?php
}

function lemonade_stand_openai_max_tokens_callback() {
    $settings = get_option('lemonade_stand_openai_options');
    ?>
    <input type="number" name="lemonade_stand_openai_options[lemonade_stand_openai_max_tokens]" value="<?php echo isset($settings['lemonade_stand_openai_max_tokens']) ? esc_attr($settings['lemonade_stand_openai_max_tokens']) : ''; ?>">
    <?php
}

function lemonade_stand_openai_n_callback() {
    $settings = get_option('lemonade_stand_openai_options');
    ?>
    <input type="number" name="lemonade_stand_openai_options[lemonade_stand_openai_n]" value="<?php echo isset($settings['lemonade_stand_openai_n']) ? esc_attr($settings['lemonade_stand_openai_n']) : ''; ?>">
    <?php
}

function lemonade_stand_openai_presence_penalty_callback() {
    $settings = get_option('lemonade_stand_openai_options');
    ?>
    <input type="number" step="0.01" min="0" max="1" name="lemonade_stand_openai_options[lemonade_stand_openai_presence_penalty]" value="<?php echo isset($settings['lemonade_stand_openai_presence_penalty']) ? esc_attr($settings['lemonade_stand_openai_presence_penalty']) : ''; ?>">
    <?php
}

function lemonade_stand_openai_temperature_callback() {
    $settings = get_option('lemonade_stand_openai_options');
    ?>
    <input type="number" step="0.01" min="0" name="lemonade_stand_openai_options[lemonade_stand_openai_temperature]" value="<?php echo isset($settings['lemonade_stand_openai_temperature']) ? esc_attr($settings['lemonade_stand_openai_temperature']) : ''; ?>">
    <?php
}

function lemonade_stand_openai_top_p_callback() {
    $settings = get_option('lemonade_stand_openai_options');
    ?>
    <input type="number" step="0.01" min="0" max="1" name="lemonade_stand_openai_options[lemonade_stand_openai_top_p]" value="<?php echo isset($settings['lemonade_stand_openai_top_p']) ? esc_attr($settings['lemonade_stand_openai_top_p']) : ''; ?>">
    <?php
}


// Display and fill the form field
function lemonade_stand_openai_api_key_callback() {
    // Get the value of the setting we've registered with register_setting()
    $setting = get_option( 'lemonade_stand_openai_options' );
    // Output the field
    ?>
    <input type="text" name="lemonade_stand_openai_options[lemonade_stand_openai_api_key]" value="<?php echo isset( $setting['lemonade_stand_openai_api_key'] ) ? $setting['lemonade_stand_openai_api_key'] : ''; ?>">
    <?php
}




