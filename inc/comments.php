<?php

namespace Writemore\Comments;

add_filter( 'comment_class', __NAMESPACE__ . '\remove_comment_classes', 999, 5 );

function remove_comment_classes( $classes, $class, $comment_id, $comment, $post_id ) {
	global $comment_depth;

	// Remove a handful of classes that are not being used by this theme to apply
	// styles or provide any kind of semantics or functionality.
	$remove_classes = array(
		'alt',
		'even',
		'odd',
		'thread-alt',
		'thread-even',
		'thread-odd',
	);

	// Remove these classes, which are added by the Semantic Linkbacks plugin, because
	// I want to ensure they survive even if the plugin is disabled in the future and
	// if I filter them myself, I'll end up with a double output.
	$remove_classes[] = 'u-comment';
	$remove_classes[] = 'h-cite';

	// Remove the comment type, for now. I may come up with a way to highlight which
	// comments were received as webmentions at some point.
	$remove_classes[] = ( empty( $comment->comment_type ) ) ? 'comment' : $comment->comment_type;

	// Remove classes added by WordPress (using this exact code) to indicate authorship
	// of a comment. If I decide to highlight my comments as different, I'll add something in
	// this section at a later time.
	$user = $comment->user_id ? get_userdata( $comment->user_id ) : false;
	if ( $user ) {
		$remove_classes[] = 'byuser';
		$remove_classes[] = 'comment-author-' . sanitize_html_class( $user->user_nicename, $comment->user_id );

		// For comment authors who are the author of the post
		$post = get_post( $post_id );
		if ( $post ) {
			if ( $comment->user_id === $post->post_author ) {
				$remove_classes[] = 'bypostauthor';
			}
		}
	}

	foreach ( $remove_classes as $class ) {
		$key = array_search( $class, $classes );
		if ( false !== $key ) {
			unset( $classes[ $key ] );
		}
	}

	// Re-add the classes that should always be there.
	$classes[] = 'u-comment';

	$protocol = get_comment_meta( $comment_id, 'protocol', true );

	// If the comment originated somewhere else, mark it as a citation. If it originated
	// on this site, mark it as an entry.
	if ( '' === $comment->comment_type && 'webmention' !== $protocol ) {
		$classes[] = 'h-entry';
	} else {
		$classes[] = 'h-cite';
	}

	return $classes;
}
