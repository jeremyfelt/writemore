<?php
/**
 * Output functions.
 *
 * @package writemore
 */

namespace Writemore\Output;

/**
 * Display the excerpt for a piece of content.
 *
 * @return void
 */
function excerpt(): void {
	$post = get_post();

	// If a manual excerpt was set, use it.
	if ( '' !== trim( $post->post_excerpt ) ) {
		echo wpautop( $post->post_excerpt );
		return;
	}

	// If blocks are available, try that first.
	$blocks = parse_blocks( $post->post_content );

	foreach ( $blocks as $block ) {
		if ( 'core/paragraph' === $block['blockName'] ) {
			echo render_block( $block );
			return;
		} elseif ( 'core/image' === $block['blockName'] ) {
			echo render_block( $block );
			return;
		}
	}

	echo wpautop( get_the_excerpt( $post ) );
}

/**
 * Display the published date.
 *
 * @param bool $microformat bool Whether to wrap with microformat data.
 * @return void
 */
function published( bool $microformat = true ): void {
	$now  = new \DateTime();
	$date = new \DateTime( get_the_time( 'c' ) );

	// Include the year for items published in previous years.
	if ( $now->format( 'Y' ) === $date->format( 'Y' ) ) {
		$format = 'l, M j \a\t H:i';
	} else {
		$format = 'l, M j, Y \a\t H:i';
	}

	if ( false === $microformat ) {
		?>
		<div class="published-wrapper"><span class="screen-reader-text">Published </span>
			<time datetime="<?php echo esc_attr( $date->format( \DateTimeInterface::ATOM ) ); ?>"><?php echo esc_attr( $date->format( $format ) ); ?></time>
		</div>
		<?php
	} else {
		?>
		<p><a href="<?php the_permalink(); ?>" class="u-url"><span class="screen-reader-text">Published </span>
			<time class="dt-published" datetime="<?php echo esc_attr( $date->format( \DateTimeInterface::ATOM ) ); ?>"><?php echo esc_attr( $date->format( $format ) ); ?></time>
		</a></p>
		<?php
	}
}
