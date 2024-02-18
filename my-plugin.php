<?php
/**
 * Plugin Name:     Rubber Duck Mailer
 * Plugin URI:      https://www.marino-studio.com
 * Description:     Send users an email that contains a PDF document download link.
 * Author:          Marin Detchev
 * Author URI:      https://www.marino-studio.com
 * Text Domain:     rubber-duck-mailer
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Rubber_Duck_Mailer
 */

 // My code starts here.

 // declare variables
 $saved_page_id = "";

/**
 * Create a page named "Form Mailer Page", add a shortcode that will show the saved items
 * and remember page id in our database.
 *
 * @since    1.0.0
 */
function run_at_activation() {
    // create_table();
    // get_all_post_images();
    // send_image();
    create_new_page("Form Mailer Page");
}

function run_at_deactivation() {
    // create_table();
    // get_all_post_images();
    // send_image();
}

function create_new_page($page_name) {
    // get root path
    if ( !defined('ABSPATH') )
    $root = define('ABSPATH', dirname(__FILE__) . '/');

    // form HTML
    $post_content = '
        <form method="post" action="' . $root . '/wp-content/plugins/rubber-duck-mailer/process-form.php">
            <label for="email">E-mail: </label>
            <input type="email" id="email" name="email" />
            
            <label for="fName">First Name: </label>
            <input type="text" id="fName" name="fName" />
            
            <label for="lName">Last Name: </label>
            <input type="text" id="lName" name="lName" />
            
            <label for="dob">Date of birth: </label>
            <input type="date" id="dob" name="dob" />
            
            <label for="phone">Phone number: </label>
            <input type="text" id="phone" name="phone" />

            <input type="submit" value="Send" />
        </form>
    ';

    add_action( 'plugins_loaded', 'create_new_page', 100 );

    // Page Arguments
    $saved_page_args = array(
        'post_title'   => __( $page_name, 'rubber-duck-mailer' ),
        'post_content' => $post_content,
        'post_status'  => 'publish',
        'post_type'    => 'page'
    );
    // Insert the page and get its id.
    $saved_page_id = wp_insert_post( $saved_page_args );
    // Save page id to the database.
    add_option( 'rd_mailer_page_id', $saved_page_id );
}

register_activation_hook( __FILE__, 'run_at_activation' );
// register_deactivation_hook( __FILE__, 'run_at_deactivation' );