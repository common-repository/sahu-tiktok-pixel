<?php
/*
* Plugin Name: SAHU TikTok Pixel for E-Commerce
* Plugin URI: https://sahu.media
* Text Domain: sahu_tiktok_pixel
* @package sahu_tiktok_pixel
* @copyright Copyright (c) 2021-2022, SAHU MEDIA®
*
*/

// Registriere Menü

add_action( 'admin_menu', 'sahu_tiktok_admin_menu' );
function sahu_tiktok_admin_menu() {
    add_menu_page(
        __( 'TikTok Pixel', 'sahu_tiktok_pixel' ),
        __( 'TikTok Pixel', 'sahu_tiktok_pixel' ),
        'manage_options',
        'sahu-tiktok-pixel',
        'sahu_tiktok_pixel_admin_page_contents',
        'dashicons-schedule',
        6
    );
}

// Lade Seiteninhalt + Einstellungen

function sahu_tiktok_pixel_admin_page_contents() {
		$currentLanguage = get_bloginfo('language');
		if ($currentLanguage == 'de-DE') {
			
			$tutvideo = '<iframe width="560" height="315" src="https://www.youtube.com/embed/2NqFcvgA83Y" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
			
		}else{
					
			$tutvideo = '<iframe width="560" height="315" src="https://www.youtube.com/embed/21JCNJbUsDY" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
					
		}
    ?>
    <h1><?php esc_html_e( 'TikTok Pixel by SAHU MEDIA ®', 'sahu_tiktok_pixel' ); ?></h1>
    <form method="POST" action="options.php">
    <?php
		settings_fields( 'sahu_tiktok_pixel-options-app-page' );
		do_settings_sections( 'sahu_tiktok_pixel-options-app-page' );
		submit_button( __( 'Save', 'sahu_tiktok_pixel' ), 'primary' )
    ?>
    </form>
	<h2>Videotutorial - need help? Please write us an mail to kontakt@sahu.media</h2>
	<?php
	
		print $tutvideo;

}

// Lade Formular

add_action( 'admin_init', 'sahu_tiktok_pixel_settings_init' );
function sahu_tiktok_pixel_settings_init() {

    add_settings_section(
        'sahu_tiktok_pixel_setting_section',
        __( 'Settings', 'sahu_tiktok_pixel' ),
        'sahu_tiktok_pixel_callback_function',
        'sahu_tiktok_pixel-options-app-page'
    );
	
		add_settings_field(
		   'sahu_tiktok_pixel_id',
		   __( 'Add PIXEL', 'sahu_tiktok_pixel' ),
		   'sahu_tiktok_pixel_id',
		   'sahu_tiktok_pixel-options-app-page',
		   'sahu_tiktok_pixel_setting_section'
		);
		
		register_setting( 'sahu_tiktok_pixel-options-app-page', 'sahu_tiktok_pixel_id' );	
		
		add_settings_field(
		   'sahu_tiktok_pixel_id_options_woo',
		   __( 'Track WooCommerce Events?', 'sahu_tiktok_pixel' ),
		   'sahu_tiktok_pixel_id_options_woo',
		   'sahu_tiktok_pixel-options-app-page',
		   'sahu_tiktok_pixel_setting_section'
		);
		
		register_setting( 'sahu_tiktok_pixel-options-app-page', 'sahu_tiktok_pixel_id_options_woo' );		

}

function sahu_tiktok_pixel_callback_function() {
    echo __( '<p>For correct tracking, pls insert u\'re TikTok-Pixel.</p>', 'sahu_tiktok_pixel' );
}

function sahu_tiktok_pixel_id() {
    ?>
    <input type="text" id="sahu_tiktok_pixel_id" name="sahu_tiktok_pixel_id" value="<?php echo get_option( 'sahu_tiktok_pixel_id' ); ?>" placeholder="<?php echo __( 'TikTok Pixel', 'sahu_tiktok_pixel' );?>">
    <?php
}

function sahu_tiktok_pixel_id_options_woo() {
	$options = get_option( 'sahu_tiktok_pixel_id_options_woo' );
 ?>	
	<input type="checkbox" name="sahu_tiktok_pixel_id_options_woo" <?php if( $options  == "on" ) print 'checked'; ?> />
<?php
}
?>