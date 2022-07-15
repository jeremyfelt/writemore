<?php

namespace Writemore\ContentAggregatorBlock;

use function Writemore\Output\published;

add_filter( 'content_aggregator_block_item', __NAMESPACE__ . '\render_shortnote_item', 20, 3 );
add_filter( 'content_aggregator_block_item', __NAMESPACE__ . '\render_weekly_note_item', 20, 3 );
add_filter( 'content_aggregator_block_wrapper', __NAMESPACE__ . '\filter_block_wrapper', 10, 2 );

function render_shortnote_item( $html, $post, $attributes ) {
	if ( 'shortnote' !== $attributes['customPostType'] ) {
		return $html;
	}

	ob_start();
	?>
	<article class="type-shortnote h-entry">
		<?php
		if ( function_exists( 'ShortNotes\PostType\Note\reply_to_markup' ) ) {
			\ShortNotes\PostType\Note\reply_to_markup();
		}
		?>
		<div class="entry-content e-content">
			<?php echo apply_filters( 'the_content', $post->post_content ); ?>
			<?php echo published(); ?>
		</div>
	</article>
	<?php

	$html = ob_get_clean();

	return $html;
}

function render_weekly_note_item( $html, $post, $attributes ) {
	if ( 'post' !== $post->post_type ) {
		return $html;
	}

	if ( 1 !== count( $attributes['taxonomies'] ) ) {
		return $html;
	}

	if ( 'NOT IN' === $attributes['taxonomies'][0]['operator'] ) {
		return $html;
	}

	if ( 'category,categories' !== $attributes['taxonomies'][0]['slug'] ) {
		return $html;
	}

	$category = get_term( $attributes['taxonomies'][0]['terms'][0] );

	if ( ! $category || ! in_array( $category->slug, array( 'a-weekly-note', 'book-notes' ), true ) ) {
		return $html;
	}

	ob_start();
	?>
	<li class="weekly-preview">
		<a href="<?php the_permalink(); ?>"><time
				datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
			><?php echo esc_html( get_the_date( 'l F j, Y' ) ); ?></time></a><br />
			<?php echo wp_kses_post( html_entity_decode( $post->post_excerpt, ENT_QUOTES, get_option( 'blog_charset' ) ) ); ?>

	</li>
	<?php

	$html = ob_get_clean();

	return $html;
}

/**
 * Filter the block wrapper on a list of posts to be section
 * rather than the default of ul.
 *
 * @param string $wrapper    Wrapping HTML element.
 * @param array  $attributes Block attributes.
 */
function filter_block_wrapper( $wrapper, $attributes ) {
	if ( 'shortnote' !== $attributes['customPostType'] ) {
		return $wrapper;
	}

	return 'section';
}
