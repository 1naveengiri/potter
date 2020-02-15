<?php
/**
 * Options.
 *
 * @package Potter
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Load metaboxes.
 */
function potter_metabox_setup() {

	add_action( 'add_meta_boxes', 'potter_metaboxes' );
	add_action( 'save_post', 'potter_save_metadata', 10, 2 );

}
add_action( 'load-post.php', 'potter_metabox_setup' );
add_action( 'load-post-new.php', 'potter_metabox_setup' );

/**
 * Metaboxes.
 */
function potter_metaboxes() {

	// Get public post types.
	$post_types = get_post_types( array( 'public' => true ) );

	// Remove post types from array.
	unset( $post_types['potter_hooks'], $post_types['elementor_library'], $post_types['fl-builder-template'] );

	// Add options metabox.
	add_meta_box( 'potter', __( 'Template Settings', 'potter' ), 'potter_options_metabox_callback', $post_types, 'side', 'default' );

	// Add sidebar metabox.
	add_meta_box( 'potter_sidebar', __( 'Sidebar', 'potter' ), 'potter_sidebar_metabox_callback', $post_types, 'side', 'default' );

}

/**
 * Options metabox callback.
 *
 * @param object $post The post oject.
 */
function potter_options_metabox_callback( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'potter_options_nonce' );

	$potter_stored_meta = get_post_meta( $post->ID );

	if ( ! isset( $potter_stored_meta['potter_options'][0] ) ) {
		$potter_stored_meta['potter_options'][0] = false;
	}

	$mydata = $potter_stored_meta['potter_options'];

	if ( strpos( $mydata[0], 'remove-title' ) !== false ) {
		$remove_title = 'remove-title';
	} else {
		$remove_title = false;
	}

	if ( strpos( $mydata[0], 'full-width' ) !== false ) {
		$full_width = 'full-width';
	} elseif ( strpos( $mydata[0], 'contained' ) !== false ) {
		$full_width = 'contained';
	} else {
		$full_width = 'layout-global';
	}

	if ( strpos( $mydata[0], 'remove-featured' ) !== false ) {
		$remove_featured = 'remove-featured';
	} else {
		$remove_featured = false;
	}

	if ( strpos( $mydata[0], 'remove-header' ) !== false ) {
		$remove_header = 'remove-header';
	} else {
		$remove_header = false;
	}

	if ( strpos( $mydata[0], 'remove-transparent-header' ) !== false ) {
		$remove_transparent_header = 'remove-transparent-header';
	} else {
		$remove_transparent_header = false;
	}

	if ( strpos( $mydata[0], 'remove-footer' ) !== false ) {
		$remove_footer = 'remove-footer';
	} else {
		$remove_footer = false;
	}

	?>

	<h4><?php _e( 'Layout', 'potter' ); ?></h4>

	<div>
		<input id="layout-global" type="radio" name="potter_options[]" value="layout-global" <?php checked( $full_width, 'layout-global' ); ?> />
		<label for="layout-global"><?php _e( 'Inherit Global Settings', 'potter' ); ?></label>
	</div>

	<div>
		<input id="layout-full-width" type="radio" name="potter_options[]" value="full-width" <?php checked( $full_width, 'full-width' ); ?> />
		<label for="layout-full-width"><?php _e( 'Full Width', 'potter' ); ?></label>
	</div>

	<div>
		<input id="layout-contained" type="radio" name="potter_options[]" value="contained" <?php checked( $full_width, 'contained' ); ?> />
		<label for="layout-contained"><?php _e( 'Contained', 'potter' ); ?></label>
	</div>

	<h4><?php _e( 'Disable Elements', 'potter' ); ?></h4>

	<div>
		<input id="remove-title" type="checkbox" name="potter_options[]" value="remove-title" <?php checked( $remove_title, 'remove-title' ); ?> />
		<label for="remove-title"><?php _e( 'Page Title', 'potter' ); ?></label>
	</div>

	<div>
		<input id="remove-featured" type="checkbox" name="potter_options[]" value="remove-featured" <?php checked( $remove_featured, 'remove-featured' ); ?> />
		<label for="remove-featured"><?php _e( 'Featured Image', 'potter' ); ?></label>
	</div>

	<div>
		<input id="remove-header" type="checkbox" name="potter_options[]" value="remove-header" <?php checked( $remove_header, 'remove-header' ); ?> />
		<label for="remove-header"><?php _e( 'Header', 'potter' ); ?></label>
	</div>

	<div>
		<input id="remove-footer" type="checkbox" name="potter_options[]" value="remove-footer" <?php checked( $remove_footer, 'remove-footer' ); ?> />
		<label for="remove-footer"><?php _e( 'Footer', 'potter' ); ?></label>
	</div>

	<h4><?php _e( 'Transparent Header Option', 'potter' ); ?></h4>
	<p><?php _e( 'This only applicable when transparent header is active (Customizer -> Header -> Transparent Header)', 'potter' ); ?></p>

	<div>
		<input id="remove-transparent-header" type="checkbox" name="potter_options[]" value="remove-transparent-header" <?php checked( $remove_transparent_header, 'remove-transparent-header' ); ?> />
		<label for="remove-transparent-header"><?php _e( 'Remove Transparent Header', 'potter' ); ?></label>
	</div>

<?php

}

/**
 * Sidebar metabox callback.
 *
 * @param object $post The post object.
 */
function potter_sidebar_metabox_callback( $post ) {

	wp_nonce_field( basename( __FILE__ ), 'potter_sidebar_nonce' );

	$potter_stored_meta = get_post_meta( $post->ID );

	$potter_sidebar_position = isset( $potter_stored_meta['potter_sidebar_position'][0] ) ? $potter_stored_meta['potter_sidebar_position'][0] : 'global';
	?>
	<div>
		<input id="sidebar-global" type="radio" name="potter_sidebar_position" value="global" <?php checked( $potter_sidebar_position, 'global' ); ?> />
		<label for="sidebar-global"><?php _e( 'Inherit Global Settings', 'potter' ); ?></label>
	</div>

	<div>
		<input id="sidebar-right" type="radio" name="potter_sidebar_position" value="right" <?php checked( $potter_sidebar_position, 'right' ); ?> />
		<label for="sidebar-right"><?php _e( 'Right Sidebar', 'potter' ); ?></label>
	</div>

	<div>
		<input id="sidebar-left" type="radio" name="potter_sidebar_position" value="left" <?php checked( $potter_sidebar_position, 'left' ); ?> />
		<label for="sidebar-left"><?php _e( 'Left Sidebar', 'potter' ); ?></label>
	</div>

	<div>
		<input id="no-sidebar" type="radio" name="potter_sidebar_position" value="none" <?php checked( $potter_sidebar_position, 'none' ); ?> />
		<label for="no-sidebar"><?php _e( 'No Sidebar', 'potter' ); ?></label>
	</div>

<?php

}

/**
 * Save metadata.
 *
 * @param integer $post_id The post ID.
 */
function potter_save_metadata( $post_id ) {

	$is_autosave            = wp_is_post_autosave( $post_id );
	$is_revision            = wp_is_post_revision( $post_id );
	$is_valid_nonce         = ( isset( $_POST['potter_options_nonce'] ) && wp_verify_nonce( $_POST['potter_options_nonce'], basename( __FILE__ ) ) ) ? true : false;
	$is_valid_sidebar_nonce = ( isset( $_POST['potter_sidebar_nonce'] ) && wp_verify_nonce( $_POST['potter_sidebar_nonce'], basename( __FILE__ ) ) ) ? true : false;

	// Stop here if autosave, revision or nonce is invalid.
	if ( $is_autosave || $is_revision || ! $is_valid_nonce || ! $is_valid_sidebar_nonce ) {
		return;
	}

	// Stop if current user can't edit posts.
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}

	// Save options metadata.
	$checked = array();

	if ( isset( $_POST['potter_options'] ) ) {

		if ( in_array( 'remove-title', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'remove-title';
		}

		if ( in_array( 'full-width', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'full-width';
		}

		if ( in_array( 'contained', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'contained';
		}

		if ( in_array( 'layout-global', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'layout-global';
		}

		if ( in_array( 'remove-featured', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'remove-featured';
		}

		if ( in_array( 'remove-header', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'remove-header';
		}
		if ( in_array( 'remove-transparent-header', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'remove-transparent-header';
		}

		if ( in_array( 'remove-footer', $_POST['potter_options'] ) !== false ) {
			$checked[] .= 'remove-footer';
		}

	}

	update_post_meta( $post_id, 'potter_options', $checked );

	// Save sidebar metadata.
	$potter_sidebar_position = isset( $_POST['potter_sidebar_position'] ) ? $_POST['potter_sidebar_position'] : '';

	update_post_meta( $post_id, 'potter_sidebar_position', $potter_sidebar_position );

}
