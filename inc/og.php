<?php
/**
 * Open Graph meta tags.
 *
 * @package writemore
 */

namespace Writemore\OG;

add_action( 'wp_head', __NAMESPACE__ . '\add_meta_tags' );

/**
 * Inject meta tags into HTML head.
 *
 * @return void
 */
function add_meta_tags(): void {
	// Do not output extra meta if Yoast is active.
	if ( function_exists( 'wpseo_init' ) ) {
		return;
	}

	$writemore_tagline = get_bloginfo( 'description', 'display' );
	if ( ! $writemore_tagline ) {
		$writemore_tagline = get_bloginfo( 'name' );
	}

	?>
	<meta property="og:site_name" content="<?php echo esc_attr( $writemore_tagline ); ?>"/>
	<?php

	if ( is_single() ) {

		// Silly excerpt handling.
		$excerpt = substr( get_the_excerpt( get_queried_object() ), 0, 140 );
		$excerpt = explode( '.', $excerpt );
		array_pop( $excerpt );
		$excerpt = implode( '.', $excerpt );

		?>
		<meta property="og:type" content="article"/>
		<meta property="og:title" content="<?php echo esc_attr( single_post_title( '', false ) ); ?>"/>
		<?php

		if ( '' !== $excerpt ) {
			?>
			<meta property="og:description" content="<?php echo esc_attr( $excerpt ); ?>"/>
			<?php
		}
	}
}
