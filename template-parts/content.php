<?php
/**
 * The default template for displaying content
 *
 * @package Radical
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope="itemscope" itemtype="http://schema.org/BlogPosting" itemprop="blogPost">

	<?php if ( radical_has_excerpt() ) : ?>
	<div class="entry-header-wrapper">
		<?php if ( 'post' == get_post_type() ) : // For Posts ?>
		<div class="entry-meta entry-meta-header-before">
			<ul>
				<li><?php radical_posted_on(); ?></li>
				<li><?php radical_posted_by(); ?></li>
				<?php radical_post_format( '<li>', '</li>' ); ?>
				<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<li>
					<span class="post-label post-label-featured">
						<span class="screen-reader-text"><?php esc_html_e( 'Featured', 'radical' ); ?></span>
					</span>
				</li>
				<?php endif; ?>
			</ul>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<header class="entry-header">
			<?php the_title( '<h1 class="entry-title" itemprop="headline"><a href="' . esc_url( radical_get_link_url() ) . '" rel="bookmark">', '</a></h1>' ); ?>
		</header><!-- .entry-header -->
	</div><!-- .entry-header-wrapper -->
	<?php endif; ?>

	<div class="entry-wrapper">

		<?php if ( radical_has_post_thumbnail() ) : ?>
		<div class="entry-image-wrapper">
			<?php radical_post_thumbnail(); ?>
		</div><!-- .entry-image-wrapper -->
		<?php endif; ?>

		<div class="entry-content-wrapper">

			<?php if ( ! radical_has_excerpt() ) : ?>
			<div class="entry-header-wrapper">
				<?php if ( 'post' == get_post_type() ) : // For Posts ?>
				<div class="entry-meta entry-meta-header-before">
					<ul>
						<li><?php radical_posted_by(); ?></li>
						<li><?php radical_posted_on(); ?></li>
					</ul>
				</div><!-- .entry-meta -->
				<?php endif; ?>

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title" itemprop="headline"><a href="' . esc_url( radical_get_link_url() ) . '" rel="bookmark">', '</a></h1>' ); ?>
				</header><!-- .entry-header -->
			</div><!-- .entry-header-wrapper -->
			<?php endif; ?>

			<?php if ( radical_has_excerpt() ) : ?>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-summary -->
			<?php endif; ?>

			<div class="more-link-wrapper">
				<a href="<?php echo esc_url( get_permalink() ); ?>" class="more-link"><?php esc_html_e( 'Read More', 'radical' ); ?></a>
			</div><!-- .more-link-wrapper -->

		</div><!-- .entry-content-wrapper -->

	</div><!-- .entry-wrapper -->

</article><!-- #post-## -->
