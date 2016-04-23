<?php
/**
 * Template part for displaying single posts.
 *
 * @package Radical
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

	<div class="entry-header-wrapper">
		<div class="entry-meta entry-meta-header-before">
			<ul>
				<li><?php radical_posted_on(); ?></li>
				<li><?php radical_posted_by(); ?></li>
				<?php radical_post_format( '<li>', '</li>' ); ?>
			</ul>
		</div><!-- .entry-meta -->

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

	<footer class="entry-meta entry-meta-footer">
		<?php radical_entry_footer(); ?>
	</footer><!-- .entry-meta -->

</article><!-- #post-## -->
