<?php
/**
 * Radical Theme Customizer
 *
 * @package Radical
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function radical_customize_register ( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'postMessage';

	// Theme Options Panel
	$wp_customize->add_panel( 'radical_theme_options', array(
	    'title'     => esc_html__( 'Theme Options', 'radical' ),
	    'priority'  => 1,
	) );

	// General Options Section
	$wp_customize->add_section( 'radical_general_options', array (
		'title'     => esc_html__( 'General Options', 'radical' ),
		'panel'     => 'radical_theme_options',
		'priority'  => 1,
	) );

	// Main Sidebar Position
	$wp_customize->add_setting ( 'radical_sidebar_position', array (
		'default'           => radical_default( 'radical_sidebar_position' ),
		'sanitize_callback' => 'radical_sanitize_sidebar_position',
	) );

	$wp_customize->add_control ( 'radical_sidebar_position', array (
		'label'    => esc_html__( 'Main Sidebar Position (if active)', 'radical' ),
		'section'  => 'radical_general_options',
		'priority' => 1,
		'type'     => 'select',
		'choices'  => array(
			'right' => esc_html__( 'Right', 'radical'),
			'left'  => esc_html__( 'Left',  'radical'),
		),
	) );

	// Theme Support Section
	$wp_customize->add_section( 'radical_support', array(
		'title'       => esc_html__( 'Theme Support', 'radical' ),
		'description' => esc_html__( 'Thanks for your interest in Radical! If you have any questions or run into any trouble, please visit us the following links. We will get you fixed up!', 'radical' ),
		'panel'       => 'radical_theme_options',
		'priority'    => 2,
	) );

	// Theme
	$wp_customize->add_setting ( 'radical_theme', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Radical_Button_Control(
			$wp_customize,
			'radical_theme',
			array(
				'label'         => esc_html__( 'Radical Theme', 'radical' ),
				'section'       => 'radical_support',
				'type'          => 'button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'https://wpflask.com/radical/',
				'button_target' => '_blank',
			)
		)
	);

	// Documentation
	$wp_customize->add_setting ( 'radical_documentation', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Radical_Button_Control(
			$wp_customize,
			'radical_documentation',
			array(
				'label'         => esc_html__( 'Documentation', 'radical' ),
				'section'       => 'radical_support',
				'type'          => 'button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'https://wpflask.com/radical-documentation/',
				'button_target' => '_blank',
			)
		)
	);

	// Support Forum
	$wp_customize->add_setting ( 'radical_forum', array(
		'default' => '',
	) );

	$wp_customize->add_control(
		new WP_Radical_Button_Control(
			$wp_customize,
			'radical_forum',
			array(
				'label'         => esc_html__( 'Support Forum', 'radical' ),
				'section'       => 'radical_support',
				'type'          => 'button',
				'button_tag'    => 'a',
				'button_class'  => 'button button-primary',
				'button_href'   => 'https://wpflask.com/forums/forum/radical/',
				'button_target' => '_blank',
			)
		)
	);
}
add_action( 'customize_register', 'radical_customize_register' );

/**
 * Button Control Class
 */
if ( class_exists( 'WP_Customize_Control' ) ) {

	class WP_Radical_Button_Control extends WP_Customize_Control {
		/**
		 * @access public
		 * @var string
		 */
		public $type = 'button';

		/**
		 * HTML tag to render button object.
		 *
		 * @var  string
		 */
		protected $button_tag = 'button';

		/**
		 * Class to render button object.
		 *
		 * @var  string
		 */
		protected $button_class = 'button button-primary';

		/**
		 * Link for <a> based button.
		 *
		 * @var  string
		 */
		protected $button_href = 'javascript:void(0)';

		/**
		 * Target for <a> based button.
		 *
		 * @var  string
		 */
		protected $button_target = '';

		/**
		 * Click event handler.
		 *
		 * @var  string
		 */
		protected $button_onclick = '';

		/**
		 * ID attribute for HTML tab.
		 *
		 * @var  string
		 */
		protected $button_tag_id = '';

		/**
		 * Render the control's content.
		 */
		public function render_content() {
		?>
			<span class="center">
				<?php
				// Print open tag
				echo '<' . esc_html( $this->button_tag );

				// button class
				if ( ! empty( $this->button_class ) ) {
					echo ' class="' . esc_attr( $this->button_class ) . '"';
				}

				// button or href
				if ( 'button' == $this->button_tag ) {
					echo ' type="button"';
				} else {
					echo ' href="' . esc_url( $this->button_href ) . '"' . ( empty( $this->button_tag ) ? '' : ' target="' . esc_attr( $this->button_target ) . '"' );
				}

				// onClick Event
				if ( ! empty( $this->button_onclick ) ) {
					echo ' onclick="' . esc_js( $this->button_onclick ) . '"';
				}

				// ID
				if ( ! empty( $this->button_tag_id ) ) {
					echo ' id="' . esc_attr( $this->button_tag_id ) . '"';
				}

				echo '>';

				// Print text inside tag
				echo esc_html( $this->label );

				// Print close tag
				echo '</' . esc_html( $this->button_tag ) . '>';
				?>
			</span>
		<?php
		}
	}

}

/**
 * Sanitize the Sidebar position value.
 *
 * @param string $sidebar_position - Sidebar position.
 * @return string Filtered sidebar position (right|left).
 */
function radical_sanitize_sidebar_position( $sidebar_position ) {
	if ( ! in_array( $sidebar_position, array( 'right', 'left' ) ) ) {
		$sidebar_position = radical_default( 'radical_sidebar_position' );
	}

	return $sidebar_position;
}

/**
 * Sanitize URL
 *
 * http://codex.wordpress.org/Function_Reference/esc_url_raw
 *
 * @param string $url - The URL to be cleaned.
 * @return Valid URL | empty string
 */
function radical_sanitize_url( $url ) {

	if( filter_var( $url, FILTER_VALIDATE_URL ) ) {
		return esc_url_raw( $url );
	}

	return '';

}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function radical_customize_preview_js() {
	wp_enqueue_script( 'radical_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20140120', true );
}
add_action( 'customize_preview_init', 'radical_customize_preview_js' );
