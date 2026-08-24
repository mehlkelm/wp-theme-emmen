<?php get_header(); ?>

<?php if ( is_archive() || is_search() ) : ?>
	<div class="page-header">
		<?php if ( is_search() ) : ?>
			<p class="page-header__label"><?php esc_html_e( 'Search', 'emmen' ); ?></p>
			<h1 class="page-header__title"><?php echo esc_html( get_search_query() ); ?></h1>
		<?php else : ?>
			<h1 class="page-header__title"><?php echo wp_kses_post( get_the_archive_title() ); ?></h1>
		<?php endif; ?>
	</div>
<?php endif; ?>

<div class="layout">
<main>
<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); ?>
		<article <?php post_class( 'entry' ); ?>>
			<?php emmen_entry_meta(); ?>
			<div class="entry__body">
				<?php if ( get_the_title() ) : ?>
					<h2 class="entry__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php endif; ?>
				<div class="entry__content">
					<?php the_content( esc_html__( 'Read more', 'emmen' ) ); ?>
				</div>
			</div>
		</article>
	<?php endwhile; ?>

	<nav class="pagination" aria-label="<?php esc_attr_e( 'Posts', 'emmen' ); ?>">
		<div><?php previous_posts_link( esc_html__( '&larr; Newer', 'emmen' ) ); ?></div>
		<div><?php next_posts_link( esc_html__( 'Older &rarr;', 'emmen' ) ); ?></div>
	</nav>
<?php else : ?>
	<article class="entry">
		<div></div>
		<div class="entry__content"><p><?php esc_html_e( 'Nothing found.', 'emmen' ); ?></p></div>
	</article>
<?php endif; ?>
</main>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
