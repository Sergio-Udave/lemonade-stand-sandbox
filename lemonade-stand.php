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
 * Update URI: false
 */

// Define the root directory path for quick reference
define('LS_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * Hook into the admin_menu action to add menu and sub-menu
 * 
 * This menu will appear on the left-hand side of the WordPress admin dashboard
 * where you would normally see others like "Posts", "Media", "Pages", etc. 
 * This function also adds sub-menus to the top-level menu in case it is better
 * to separate the plugin's functionality into different sections.
 */
add_action('admin_menu', 'lemonade_stand_create_menu');

function lemonade_stand_create_menu()
{
    add_menu_page(
        'Lemonade Stand Settings Page',
        'Lemonade Stand',
        'manage_options',
        'lemonade-stand',
        'lemonade_stand_settings_page',
        'dashicons-admin-generic',
        99
    );

    add_submenu_page(
        'lemonade-stand',
        'About the Lemonade Stand Inc. Plugin',
        'About',
        'manage_options',
        'lemonade-stand-about',
        'lemonade_stand_about_page'
    );
}

// Create the settings page
function lemonade_stand_settings_page()
{
?>
    <div class="wrap">
        <h2>Form Settings Header</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('lemonade_stand_options');
            do_settings_sections('lemonade-stand');
            submit_button('Save Changes', 'primary');
            ?>
        </form>
    </div>
<?php
}

// Register the settings
add_action('admin_init', 'lemonade_stand_admin_init');

function lemonade_stand_admin_init()
{
    $args = array(
        'type' => 'string',
        'sanitize_callback' => 'lemonade_stand_validate_text',
        'default' => NULL
    );

    // Register settings
    register_setting('lemonade_stand_options', 'lemonade_stand_options', $args);

    // Add a new section to group related fields together
    add_settings_section(
        'lemonade_stand_settings_page_section',
        'This is a group of related fields',
        'lemonade_stand_settings_page_section_text',
        'lemonade-stand'
    );

    // Add a new field to the section
    add_settings_field(
        'lemonade_stand_name_field',
        'This is a field label',
        'lemonade_stand_setting_name',
        'lemonade-stand',
        'lemonade_stand_settings_page_section'
    );
}

// Display additional section text
function lemonade_stand_settings_page_section_text()
{
    echo '<p>This is descriptive text.</p>';
}

// Display and fill the 'Name' form field
function lemonade_stand_setting_name() {

    // Get the option from the database
    $options = get_option('lemonade_stand_options');
    
    // 'Trying to access array offset on value of type null' error is thrown when $options['name'] is not set
    $name = is_array($options) && isset($options['name']) ? esc_attr($options['name']) : ''; 

    // Output the field
    echo "<input id='name' name='lemonade_stand_options[name]' type='text' value='$name' />";
}

// Validate user input (we want text and spaces only)
function lemonade_stand_validate_text($input) {
    $valid = array();
    $valid['name'] = preg_replace(
        '/[^a-zA-Z\s]/',
        '',
        $input['name']
    );
    return $valid;
}
