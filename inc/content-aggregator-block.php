<?php

namespace Writemore\ContentAggregatorBlock;

add_filter( 'content_aggregator_block_item', __NAMESPACE__ . '\render_shortnote_item', 20, 3 );
add_filter( 'content_aggregator_block_item', __NAMESPACE__ . '\render_weekly_note_item', 20, 3 );

function render_shortnote_item( $html, $post, $attributes ) {
	if ( 'shortnote' !== $attributes['customPostType'] ) {
		return $html;
	}

	ob_start();
	?>
	<li class="note-item">
		<div class="note-content">
			<?php echo wp_kses_post( html_entity_decode( $post->post_content, ENT_QUOTES, get_option( 'blog_charset' ) ) ); ?>
		</div>
		<a href="<?php the_permalink(); ?>" class="note-link"><time
				class="note-date"
				datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
			><?php echo esc_html( get_the_date( 'l F j, Y, g:i a' ) ); ?></time></a>
	</li>
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

	if ( 'category,categories' !== $attributes['taxonomies'][0]['slug'] ) {
		return $html;
	}

	$category = get_term( $attributes['taxonomies'][0]['terms'][0] );

	if ( ! $category || 'a-weekly-note' !== $category->slug ) {
		return $html;
	}

	ob_start();
	?>
	<li class="weekly-preview">
		<a href="<?php the_permalink(); ?>"><time
				datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"
			><?php echo esc_html( get_the_date( 'l F j, Y' ) ); ?></time></a>:
			<?php echo wp_kses_post( html_entity_decode( $post->post_excerpt, ENT_QUOTES, get_option( 'blog_charset' ) ) ); ?>

	</li>
	<?php

	$html = ob_get_clean();

	return $html;
}
