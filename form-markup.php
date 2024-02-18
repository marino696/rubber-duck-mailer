<?php
private function define_public_hooks() {
    $plugin_public = new Toptal_Save_Public( $this->get_plugin_name(), $this->get_version() );

    // Append our button
    $this->loader->add_action( 'the_content', $plugin_public, 'append_the_button', 45 );

    // Add our Shortcodes
    $this->loader->add_shortcode( 'toptal-save', $plugin_public, 'register_save_unsave_shortcode' );
    $this->loader->add_shortcode( 'toptal-saved', $plugin_public, 'register_saved_shortcode' );

    // Save/unsave AJAX
    $this->loader->add_action( 'wp_ajax_save_unsave_item', $plugin_public, 'save_unsave_item' );
    $this->loader->add_action( 'wp_ajax_nopriv_save_unsave_item', $plugin_public, 'save_unsave_item' );

    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
    $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

}