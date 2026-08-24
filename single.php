<?php get_header(); ?>

<div class="layout">
<main>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'entry entry--single' ); ?>>
		<?php emmen_entry_meta(); ?>
		<div class="entry__body">
			<?php if ( get_the_title() ) : ?>
				<h1 class="entry__title"><?php the_title(); ?></h1>
			<?php endif; ?>
			<div class="entry__content">
				<?php the_content(); ?>
			</div>
		</div>
	</article>

	<?php if ( comments_open() || get_comments_number() ) : ?>
		<div class="comments">
			<?php comments_template(); ?>
		</div>
	<?php endif; ?>

	<nav class="pagination" aria-label="<?php esc_attr_e( 'Post', 'emmen' ); ?>">
		<div><?php previous_post_link( '%link', esc_html__( '&larr; %title', 'emmen' ) ); ?></div>
		<div><?php next_post_link( '%link', esc_html__( '%title &rarr;', 'emmen' ) ); ?></div>
	</nav>
<?php endwhile; ?>
</main>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
