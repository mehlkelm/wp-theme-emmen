	<footer class="colophon">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?></p>
		<p><a href="<?php echo esc_url( get_feed_link() ); ?>"><?php esc_html_e( 'RSS', 'emmen' ); ?></a></p>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
