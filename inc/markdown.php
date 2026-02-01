<?php
/**
 * Markdown rendering functions.
 *
 * Uses league/commonmark with GitHub Flavored Markdown extensions.
 *
 * @package writemore
 */

namespace Writemore\Markdown;

use League\CommonMark\GithubFlavoredMarkdownConverter;
use League\CommonMark\Exception\CommonMarkException;

/**
 * Convert markdown to HTML.
 *
 * @param string $markdown The markdown content to convert.
 * @return string The converted HTML.
 */
function to_html( string $markdown ): string {
	if ( empty( trim( $markdown ) ) ) {
		return '';
	}

	$converter = new GithubFlavoredMarkdownConverter(
		[
			'html_input'         => 'strip',
			'allow_unsafe_links' => false,
		]
	);

	try {
		return $converter->convert( $markdown )->getContent();
	} catch ( CommonMarkException $e ) {
		return wpautop( esc_html( $markdown ) );
	}
}

/**
 * Get the workout content, parsing markdown if needed.
 *
 * Checks post meta for markdown content first, falls back to post content.
 *
 * @param int|null $post_id The post ID. Defaults to current post.
 * @return string The rendered HTML content.
 */
function get_workout_content( ?int $post_id = null ): string {
	$post_id = $post_id ?? get_the_ID();

	// Check for markdown in post meta first.
	$markdown_content = get_post_meta( $post_id, 'hwt_workout_markdown', true );

	if ( ! empty( $markdown_content ) ) {
		return to_html( $markdown_content );
	}

	// Fall back to post content.
	$post = get_post( $post_id );

	if ( ! $post ) {
		return '';
	}

	// If content looks like it contains markdown (no block comments), parse it.
	if ( ! str_contains( $post->post_content, '<!-- wp:' ) ) {
		return to_html( $post->post_content );
	}

	// Otherwise, return standard WordPress content.
	return apply_filters( 'the_content', $post->post_content );
}

/**
 * Display the workout content.
 *
 * @param int|null $post_id The post ID. Defaults to current post.
 * @return void
 */
function workout_content( ?int $post_id = null ): void {
	echo wp_kses_post( get_workout_content( $post_id ) );
}

/**
 * Get a workout excerpt from markdown content.
 *
 * @param int|null $post_id The post ID. Defaults to current post.
 * @return string The excerpt HTML.
 */
function get_workout_excerpt( ?int $post_id = null ): string {
	$post_id = $post_id ?? get_the_ID();
	$post    = get_post( $post_id );

	// If a manual excerpt was set, use it.
	if ( ! empty( trim( $post->post_excerpt ) ) ) {
		return wpautop( $post->post_excerpt );
	}

	// Get the full content.
	$markdown_content = get_post_meta( $post_id, 'hwt_workout_markdown', true );

	if ( empty( $markdown_content ) ) {
		$markdown_content = $post->post_content;
	}

	// If it's block content, defer to standard excerpt.
	if ( str_contains( $markdown_content, '<!-- wp:' ) ) {
		return wpautop( get_the_excerpt( $post ) );
	}

	// Get first paragraph from markdown.
	$lines      = explode( "\n", trim( $markdown_content ) );
	$first_para = '';

	foreach ( $lines as $line ) {
		$line = trim( $line );

		// Skip headers, empty lines, and list items for excerpt.
		if ( empty( $line ) || str_starts_with( $line, '#' ) || str_starts_with( $line, '-' ) || str_starts_with( $line, '*' ) ) {
			continue;
		}

		$first_para = $line;
		break;
	}

	if ( empty( $first_para ) ) {
		return wpautop( get_the_excerpt( $post ) );
	}

	return to_html( $first_para );
}

/**
 * Display the workout excerpt.
 *
 * @param int|null $post_id The post ID. Defaults to current post.
 * @return void
 */
function workout_excerpt( ?int $post_id = null ): void {
	echo wp_kses_post( get_workout_excerpt( $post_id ) );
}
