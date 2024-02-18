<?php
 /**
	 * Create a page named "Form Mailer Page", add a shortcode that will show the saved items
	 * and remember page id in our database.
	 *
	 * @since    1.0.0
	 */
    class RD_Mailer_Activator {
        public static function activate() {
            // Saved Page Arguments
            $saved_page_args = array(
                'post_title'   => __( 'Form Mailer Page', 'rubber-duck-mailer' ),
                'post_content' => '[rubber-duck-mailer]',
                'post_status'  => 'publish',
                'post_type'    => 'page'
            );
            // Insert the page and get its id.
            $saved_page_id = wp_insert_post( $saved_page_args );
            // Save page id to the database.
            add_option( 'rd_mailer_page_id', $saved_page_id );
        }
    }