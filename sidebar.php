<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package Radical
 */

if ( ! radical_has_sidebar() ) {
	return;
}
?>
<div id="site-sidebar" class="sidebar-area <?php radical_layout_class( 'sidebar' ); ?>">
	<div id="secondary" class="sidebar widget-area" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
		<?php do_action( 'before_sidebar' ); ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div><!-- .sidebar -->
</div><!-- .col-* columns of main sidebar -->
