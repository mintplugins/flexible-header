<?php
/*
Plugin Name: Flexible Header
Plugin URI: http://mintplugins.com
Description: This plugin changes the normal header image options to allow it to be any width or height. Theme must use get_header_image(); in the header.php file for this to work
Version: 1.0
Author: Phil Johnston
Author URI: http://mintplugins.com
License: GPL2
*/

/*  Copyright 2012  Phil Johnston  (email : phil@mintplugins.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* To use this function put the following your header file
<?php $header_image = get_header_image();
	if ( ! empty( $header_image ) ) { ?>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
		</a>
<?php } // if ( ! empty( $header_image ) ) ?>
*/

function mintthemes_flexible_header_custom_header_setup() {
	
	$args = array(
		'default-image'          => '',
		'default-text-color'     => '000',
		'height'            => '100',
		'width'            => '200',
		'flex-height'            => true,
		'flex-width'            => true,
		'admin-preview-callback' => 'mintthemes_flexible_header_admin_header_image',
	);
	

	$args = apply_filters( 'mintthemes_flexible_header_custom_header_args', $args );

	if ( function_exists( 'wp_get_theme' ) ) {
		add_theme_support( 'custom-header', $args );
	} else {
		// Compat: Versions of WordPress prior to 3.4.
		define( 'HEADER_TEXTCOLOR',    $args['default-text-color'] );
		define( 'HEADER_IMAGE',        $args['default-image'] );
		define( 'HEADER_IMAGE_WIDTH',  $args['width'] );
		define( 'HEADER_IMAGE_HEIGHT', $args['height'] );
		add_custom_image_header( $args['wp-head-callback'], $args['admin-head-callback'], $args['admin-preview-callback'] );
	}
}
add_action( 'after_setup_theme', 'mintthemes_flexible_header_custom_header_setup' );

/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see mintthemes_flexible_header_custom_header_setup().
 *
 * @since mintthemes_flexible_header 1.0
 */
if ( ! function_exists( 'mintthemes_flexible_header_admin_header_image' ) ) :
	function mintthemes_flexible_header_admin_header_image() { ?>
		<div id="headimg">
			<?php
			if ( 'blank' == get_header_textcolor() || '' == get_header_textcolor() )
				$style = ' style="display:none;"';
			else
				$style = ' style="color:#' . get_header_textcolor() . ';"';
			?>
			<h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
			<div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
			<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) ) : ?>
				<img src="<?php echo esc_url( $header_image ); ?>" alt="" />
			<?php endif; ?>
		</div>
	<?php }
endif; // mintthemes_flexible_header_admin_header_image
