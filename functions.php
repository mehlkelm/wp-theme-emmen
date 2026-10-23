<?php
/**
 * Emmen theme setup.
 */

function emmen_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'editor-style.css', 'product-pages-editor.css' ) );
	add_theme_support( 'post-formats', array( 'aside', 'status', 'link' ) );
	register_nav_menus( array( 'primary' => __( 'Primary Menu', 'emmen' ) ) );
}
add_action( 'after_setup_theme', 'emmen_setup' );

function emmen_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Sidebar', 'emmen' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Right column, shown on every page.', 'emmen' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget__title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'emmen_widgets_init' );

function emmen_sidecol_toggle_script() {
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		return;
	}
	?>
	<script>
	( function () {
		var toggle = document.querySelector( '.masthead__toggle' );
		var panel  = document.getElementById( 'sidecol-panel' );
		if ( ! toggle || ! panel ) return;
		toggle.addEventListener( 'click', function () {
			var open = toggle.getAttribute( 'aria-expanded' ) === 'true';
			toggle.setAttribute( 'aria-expanded', String( ! open ) );
			panel.classList.toggle( 'is-open', ! open );
		} );
	} )();
	</script>
	<?php
}
add_action( 'wp_footer', 'emmen_sidecol_toggle_script' );

/**
 * Core's lightbox sizes its container to the cropped gallery ratio and
 * clips the full image. Re-fit the container vars to the image's own
 * ratio whenever the lightbox opens or navigates; core's centering and
 * zoom math then use the corrected size.
 */
function emmen_lightbox_ratio_script() {
	?>
	<script>
	( function () {
		var overlay = null;
		function refit() {
			var cs = getComputedStyle( overlay );
			var iw = parseFloat( cs.getPropertyValue( '--wp--lightbox-image-width' ) );
			var ih = parseFloat( cs.getPropertyValue( '--wp--lightbox-image-height' ) );
			if ( ! iw || ! ih ) return;
			var fit = Math.min( 0.92 * innerWidth / iw, 0.92 * innerHeight / ih );
			var w = Math.round( iw * fit ), h = Math.round( ih * fit );
			if ( parseFloat( cs.getPropertyValue( '--wp--lightbox-container-width' ) ) !== w ) {
				overlay.style.setProperty( '--wp--lightbox-container-width', w + 'px' );
				overlay.style.setProperty( '--wp--lightbox-container-height', h + 'px' );
			}
		}
		function init() {
			overlay = document.querySelector( '.wp-lightbox-overlay' );
			if ( ! overlay ) return;
			new MutationObserver( function () {
				if ( overlay.classList.contains( 'active' ) ) refit();
			} ).observe( overlay, { attributes: true, attributeFilter: [ 'class', 'style' ] } );
		}
		if ( document.readyState === 'loading' ) {
			document.addEventListener( 'DOMContentLoaded', init );
		} else {
			init();
		}
	} )();
	</script>
	<?php
}
add_action( 'wp_footer', 'emmen_lightbox_ratio_script' );

function emmen_get_accent_color( $setting, $default ) {
	$color = sanitize_hex_color( get_theme_mod( $setting, $default ) );
	return $color ? $color : $default;
}

/**
 * Site-specific accent colors. Theme mods live in each site's database, so
 * the same theme files can be shared by sites with different branding.
 */
function emmen_accent_css() {
	$accent      = emmen_get_accent_color( 'accent_color', '#00874a' );
	$accent_dark = emmen_get_accent_color( 'accent_color_dark', '#2fbf71' );

	return sprintf(
		':root{--accent:%1$s}@media (prefers-color-scheme:dark){:root{--accent:%2$s}}',
		$accent,
		$accent_dark
	);
}

function emmen_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'emmen_accent_colors',
		array(
			'title'    => __( 'Accent Colors', 'emmen' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'accent_color',
		array(
			'default'           => '#00874a',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'accent_color',
			array(
				'label'   => __( 'Accent color', 'emmen' ),
				'section' => 'emmen_accent_colors',
			)
		)
	);

	$wp_customize->add_setting(
		'accent_color_dark',
		array(
			'default'           => '#2fbf71',
			'sanitize_callback' => 'sanitize_hex_color',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'accent_color_dark',
			array(
				'label'       => __( 'Accent color in dark mode', 'emmen' ),
				'description' => __( 'Choose a lighter color with good contrast on the dark background.', 'emmen' ),
				'section'     => 'emmen_accent_colors',
			)
		)
	);
}
add_action( 'customize_register', 'emmen_customize_register' );

function emmen_scripts() {
	$version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'emmen-style', get_stylesheet_uri(), array(), $version );
	wp_add_inline_style( 'emmen-style', emmen_accent_css() );
	wp_enqueue_style( 'emmen-product-pages', get_theme_file_uri( 'product-pages.css' ), array( 'emmen-style' ), $version );
}
add_action( 'wp_enqueue_scripts', 'emmen_scripts' );

/** Keep the block editor's accent in sync with the site setting. */
function emmen_block_editor_accent( $editor_settings ) {
	$editor_settings['styles'][] = array( 'css' => emmen_accent_css() );
	return $editor_settings;
}
add_filter( 'block_editor_settings_all', 'emmen_block_editor_accent' );

/**
 * Theme updates from GitHub releases. The Update URI header in style.css
 * routes WordPress' update check to this filter instead of wordpress.org.
 * Each release carries an emmen.zip asset built by the release workflow.
 */
function emmen_github_update( $update, $theme_data, $theme_stylesheet ) {
	if ( 'emmen' !== $theme_stylesheet ) {
		return $update;
	}

	$release = get_site_transient( 'emmen_github_release' );
	if ( false === $release ) {
		$response = wp_remote_get(
			'https://api.github.com/repos/mehlkelm/wp-theme-emmen/releases/latest',
			array( 'headers' => array( 'Accept' => 'application/vnd.github+json' ), 'timeout' => 10 )
		);
		$release = array();
		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			foreach ( isset( $body['assets'] ) ? $body['assets'] : array() as $asset ) {
				if ( 'emmen.zip' === $asset['name'] ) {
					$release = array(
						'version' => ltrim( $body['tag_name'], 'v' ),
						'url'     => $body['html_url'],
						'package' => $asset['browser_download_url'],
					);
				}
			}
		}
		set_site_transient( 'emmen_github_release', $release, 6 * HOUR_IN_SECONDS );
	}

	if ( empty( $release['version'] ) ) {
		return $update;
	}

	return array(
		'theme'        => $theme_stylesheet,
		'version'      => $release['version'],
		'url'          => $release['url'],
		'package'      => $release['package'],
		'requires_php' => wp_get_theme( $theme_stylesheet )->get( 'RequiresPHP' ),
	);
}
add_filter( 'update_themes_github.com', 'emmen_github_update', 10, 3 );

/**
 * Meta column shown beside every entry: accent date plus categories.
 */
function emmen_entry_meta() {
	?>
	<aside class="entry__meta">
		<a href="<?php the_permalink(); ?>" class="entry__date">
			<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		</a>
	</aside>
	<?php
}
