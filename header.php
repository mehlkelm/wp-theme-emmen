<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div class="site">
	<header class="masthead">
		<p class="masthead__title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<button class="masthead__toggle" aria-expanded="false" aria-controls="sidecol-panel" aria-label="<?php esc_attr_e( 'About & Search', 'emmen' ); ?>">
				<svg width="22" height="22" viewBox="0 0 22 22" aria-hidden="true" focusable="false">
					<g class="icon-burger" fill="currentColor">
						<rect y="3" width="22" height="3"/><rect y="10" width="22" height="3"/><rect y="17" width="22" height="3"/>
					</g>
					<g class="icon-close" stroke="currentColor" stroke-width="3" fill="none">
						<path d="M4 4 18 18M18 4 4 18"/>
					</g>
				</svg>
			</button>
		<?php endif; ?>
		<?php if ( get_bloginfo( 'description' ) ) : ?>
			<p class="masthead__tagline"><?php bloginfo( 'description' ); ?></p>
		<?php endif; ?>
		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="masthead__nav" aria-label="<?php esc_attr_e( 'Primary', 'emmen' ); ?>">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'depth' => 1 ) ); ?>
			</nav>
		<?php endif; ?>
	</header>
