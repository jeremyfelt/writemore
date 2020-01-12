<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Write_More_Things
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( 1 === $comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html_e( 'One thought on &ldquo;%1$s&rdquo;', 'writemore' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'writemore' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php

		the_comments_navigation();

		$comments = get_comments( array(
			'post_id' => get_the_ID(),
			'status' => 1,
			'fields' => 'ids',
		) );

		$typed_comments = array(
			'reply' => array(),
			'like'  => array(),
			'mention' => array(),
			'other' => array(),
		);

		foreach ( $comments as $comment_id ) {
			$type = get_comment_meta( $comment_id, 'semantic_linkbacks_type', true );

			if ( '' === $type ) {
				$type = 'reply';
			}

			if ( isset( $typed_comments[ $type ] ) ) {
				$typed_comments[ $type ][] = $comment_id;
			} else {
				$typed_comments['other'][] = $comment_id;
			}

		}

		?>

		<div class="webmention-likes">
			<h3>Liked by:</h3>
			<ul>
		<?php
		foreach ( $typed_comments['like'] as $like_id ) {
			$like = get_comment( $like_id );
			$url = get_comment_meta( $like_id, 'webmention_source_url', true );
			$avatar = get_comment_meta( $like_id, 'avatar', true );

			?>
				<li>
					<img alt="" width=50 src="<?php echo esc_url( $avatar ); ?>" />
					<a href="<?php echo esc_url( $url ); ?>" ><?php echo esc_html( $like->comment_author ); ?></a>
				</li>
			<?php
		}

		?>
			</ul>
		</div>

		<div class="webmention-mentions">
			<h3>Mentioned by:</h3>
			<ul>
		<?php
		foreach ( $typed_comments['mention'] as $mention_id ) {
			$mention = get_comment( $mention_id );
			$url = get_comment_meta( $mention_id, 'webmention_source_url', true );
			$avatar = get_comment_meta( $mention_id, 'avatar', true );

			?>
				<li>
					<img alt="" width=50 src="<?php echo esc_url( $avatar ); ?>" />
					<a href="<?php echo esc_url( $url ); ?>" ><?php echo esc_html( $mention->comment_author ); ?></a>
				</li>
			<?php
		}

		?>
			</ul>
		</div>

		<div class="webmention-replies">
			<h3>Replies</h3>

			<ol class="comment-list">
			<?php
				$comments = get_comments( array(
					'comment__in' => $typed_comments['reply'],
				) );
				wp_list_comments( array(), $comments );
			?>
			</ol><!-- .comment-list -->
		</div>

		<?php the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'writemore' ); ?></p>
		<?php
		endif;

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
