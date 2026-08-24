<?php
/**
 * Emmen theme setup.
 */

function emmen_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
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

function emmen_scripts() {
	wp_enqueue_style( 'emmen-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'emmen_scripts' );

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
