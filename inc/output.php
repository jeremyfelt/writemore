<?php

namespace Writemore\Output;

function archive_content() {
	if ( 'post' === get_post_type() ) {
		excerpt();
		return;
	}

	// Notes and likes are output in full.
	if ( in_array( get_post_type(), [ 'shortnote', 'like' ] ) ) {
		note();
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

	return;
}

/**
 * Display note formatted content.
 */
function note() {
	the_content();
	published();
}

/**
 * Display the published date.
 */
function published() {
	$date = new \DateTime( get_the_time( 'c' ) );
	?>
	<p><a href="<?php the_permalink(); ?>" class="u-url"><span class="screen-reader-text">Published </span>
		<time class="dt-published" datetime="<?php echo esc_attr( $date->format( \DateTimeInterface::ATOM ) ); ?>"><?php echo esc_attr( $date->format( 'l, M n \a\t H:i' ) ); ?></time>
	</a></p>
	<?php
}
