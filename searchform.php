<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label>
		<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'emmen' ); ?></span>
		<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search &hellip;', 'emmen' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	</label>
	<button type="submit" class="search-submit" aria-label="<?php esc_attr_e( 'Search', 'emmen' ); ?>">&#8629;</button>
</form>
