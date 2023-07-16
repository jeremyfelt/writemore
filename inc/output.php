<?php

namespace Writemore\Output;

/**
 * Display archive content.
 */
function archive_content() {
	if ( 'post' === get_post_type() ) {
		excerpt();
		return;
	}

	// Notes are output in full.
	if ( in_array( get_post_type(), [ 'shortnote' ] ) ) {
		note();
		return;
	}

	// A like pieces together meta.
	if ( in_array( get_post_type(), [ 'like' ] ) ) {
		like();
		return;
	}
}

/**
 * Display the excerpt for a piece of content.
 */
function excerpt() {
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
 * Display note formatted content.
 */
function note() {
	the_content();
	published();
}

/**
 * Display like formatted content.
 */
function like() {
	the_content();
	published();
}

/**
 * Display the published date.
 *
 * @param $microformat bool Whether to wrap with microformat data.
 */
function published( $microformat = true ) {
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
