<?php get_header(); ?>

<div class="layout">
<main>
<?php while ( have_posts() ) : the_post(); ?>
	<article <?php post_class( 'entry entry--single' ); ?>>
		<div class="entry__meta"></div>
		<div class="entry__body">
			<h1 class="entry__title"><?php the_title(); ?></h1>
			<div class="entry__content">
				<?php the_content(); ?>
			</div>
		</div>
	</article>
<?php endwhile; ?>
</main>
<?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
