<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Radical
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork">

	<div class="entry-header-wrapper">
		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' ); ?>
		</header><!-- .entry-header -->
	</div><!-- .entry-header-wrapper -->

	<div class="entry-content" itemprop="text">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'radical' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->

	<?php if ( '' != get_edit_post_link() ) : ?>
	<footer class="entry-meta entry-meta-footer">
		<?php radical_entry_footer(); ?>
	</footer><!-- .entry-meta -->
	<?php endif; ?>

</article><!-- #post-## -->
