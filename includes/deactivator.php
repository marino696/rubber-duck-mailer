<?php
class RD_Mailer_Deactivator {

	/**
	 * On deactivation delete the "Saved" page.
	 *
	 * Get the "Saved" page id, check if it exists and delete the page that has that id.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {

		// Get Saved page id.
		$saved_page_id = get_option( 'rd_mailer_page_id' );

		// Check if the saved page id exists.
		if ( $saved_page_id ) {

			// Delete saved page.
			wp_delete_post( $saved_page_id, true );

			// Delete saved page id record in the database.
			delete_option( 'rd_mailer_page_id' );

		}

	}
}