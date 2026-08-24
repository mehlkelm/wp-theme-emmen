<?php
/**
 * Comments and webmentions list plus reply form.
 */

if ( post_password_required() ) {
	return;
}
?>

<?php if ( have_comments() ) : ?>
	<h2 class="comments__title">
		<?php
		printf(
			/* translators: %s: comment count */
			esc_html( _n( '%s response', '%s responses', get_comments_number(), 'emmen' ) ),
			esc_html( number_format_i18n( get_comments_number() ) )
		);
		?>
	</h2>

	<ol class="comment-list">
		<?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?>
	</ol>

	<?php the_comments_navigation(); ?>
<?php endif; ?>

<?php comment_form(); ?>
