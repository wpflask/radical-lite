<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Radical
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses radical_header_style()
 * @uses radical_admin_header_style()
 * @uses radical_admin_header_image()
 */
function radical_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'radical_custom_header_args', array(
		'default-text-color'     => '3d3d3d',
		'width'                  => 1920,
		'height'                 => 150,
		'flex-height'            => true,
		'wp-head-callback'       => 'radical_header_style',
		'admin-head-callback'    => 'radical_admin_header_style',
		'admin-preview-callback' => 'radical_admin_header_image'
	) ) );
}
add_action( 'after_setup_theme', 'radical_custom_header_setup' );

if ( ! function_exists( 'radical_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see radical_custom_header_setup().
 */
function radical_header_style() {
?>

	<?php if ( get_header_image() ) : ?>
	<style type="text/css">
		.site-header {
			background-image: url(<?php header_image(); ?>);
			background-repeat: no-repeat;
			background-position: top center;
			-webkit-background-size: cover;
			   -moz-background-size: cover;
			     -o-background-size: cover;
			        background-size: cover;
		}
	</style>
	<?php endif; ?>

	<?php
	// Header Text Color
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
	if ( HEADER_TEXTCOLOR == $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-title a:visited {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
		.site-title a:hover,
		.site-title a:focus,
		.site-title a:active {
			opacity: 0.7;
		}
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
			opacity: 0.7;
		}
	<?php endif; ?>
	</style>

<?php
}
endif; // radical_header_style

if ( ! function_exists( 'radical_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see radical_custom_header_setup().
 */
function radical_admin_header_style() {
?>

	<style type="text/css">
		.appearance_page_custom-header #headimg {
			<?php if ( get_header_image() ) : ?>
			background-image: url(<?php header_image(); ?>);
			background-repeat: no-repeat;
			background-position: top center;
			<?php endif; ?>
			border: none;
			overflow: hidden;
			min-height: 100px;
			margin: 0;
			padding: 50px 0;
			width: 95%;
		}
		#headimg h1,
		#desc {
			margin: 0;
			padding: 30px 250px;
		}
		#headimg h1 {
			font-family: 'Source Sans Pro', sans-serif;
			font-size: 36px;
			line-height: 1.3;
			margin: 0;
			padding: 0;
			text-transform: uppercase;
		}
		#headimg h1 a,
		#headimg h1 a:visited {
			text-decoration: none;
		}
		#desc {
			font-family: 'Open Sans', sans-serif;
			font-size: 13px;
			line-height: 1.3;
			margin: 30px 0 0;
			padding: 0;
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // radical_admin_header_style

if ( ! function_exists( 'radical_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see radical_custom_header_setup().
 */
function radical_admin_header_image() {
?>
	<div id="headimg">
		<h1 class="displaying-header-text">
			<a id="name" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
		</h1>
		<div class="displaying-header-text" id="desc" style="<?php echo esc_attr( 'color: #' . get_header_textcolor() ); ?>">
			<?php bloginfo( 'description' ); ?>
		</div>
	</div>
<?php
}
endif; // radical_admin_header_image
