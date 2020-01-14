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
					esc_html_e( 'One reaction on &ldquo;%1$s&rdquo;', 'writemore' ),
					'<span>' . get_the_title() . '</span>'
				);
			} else {
				printf( // WPCS: XSS OK.
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s reactions on &ldquo;%2$s&rdquo;', '%1$s reactions on &ldquo;%2$s&rdquo;', $comment_count, 'comments title', 'writemore' ) ),
					number_format_i18n( $comment_count ),
					'<span>' . get_the_title() . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php

		$comments = get_comments( array(
			'post_id' => get_the_ID(),
			'status' => 1,
			'fields' => 'ids',
		) );

		$typed_comments = array(
			'reply' => array(),
			'bookmark' => array(),
			'like'  => array(),
			'mention' => array(),
			'other' => array(),
		);

		foreach ( $comments as $comment_id ) {
			$type = get_comment_meta( $comment_id, 'semantic_linkbacks_type', true );

			if ( '' === $type ) {
				$type = 'reply';
			}

			// Mirror "favorite" to the "like" type.
			if ( 'favorite' === $type ) {
				$type = 'like';
			}

			// Leave "read" actions as private for now.
			if ( 'read' === $type ) {
				continue;
			}

			if ( isset( $typed_comments[ $type ] ) ) {
				$typed_comments[ $type ][] = $comment_id;
			} else {
				$typed_comments['other'][] = $comment_id;
			}

		}

		if ( 0 < count( $typed_comments['like'] ) ) :

		?>

		<!-- Is there a semantic way to group a collection of reactions? -->
		<h3>Likes</h3>
		<?php

		foreach ( $typed_comments['like'] as $like_id ) {
			$like = get_comment( $like_id );
			$url = get_comment_meta( $like_id, 'webmention_source_url', true );
			$avatar = get_comment_meta( $like_id, 'avatar', true );
			$author_url = get_comment_meta( $like_id, 'semantic_linkbacks_author_url', true );

			if ( '' === $author_url ) {
				$author_url = $url;
			}

			if ( '' === $avatar ) {
				$avatar = get_template_directory_uri() . '/images/mystery-person.png';
			}

			?>

			<!-- Markup inspired by https://indieweb.org/like -->
			<article class="p-like h-cite">
				<!-- The loading attribute is only supported by Chrome right now, but I'd like to not use JavaScript for this. -->
				<img src="<?php echo esc_url( $avatar ); ?>" width=40 alt="" loading="lazy" />

				<!-- This span is my lazy way of enabling a vertically aligned flex display on the article element. -->
				<span>
					<a class="p-author h-card" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $like->comment_author ); ?></a>
					liked this on
					<a class="u-url" href="<?php echo esc_url( $url ); ?>">
						<time class="dt-published"><?php echo get_comment_date( 'F j, Y \a\t g:i a', $like ); ?></time>
					</a>
				</span>
			</article>

			<?php
		}

		endif;

		if ( 0 < count( $typed_comments['bookmark'] ) ) :
		?>

		<h3>Bookmarks</h3>
		<?php

		foreach ( $typed_comments['bookmark'] as $bookmark_id ) {
			$like = get_comment( $bookmark_id );
			$url = get_comment_meta( $bookmark_id, 'webmention_source_url', true );
			$avatar = get_comment_meta( $bookmark_id, 'avatar', true );
			$author_url = get_comment_meta( $bookmark_id, 'semantic_linkbacks_author_url', true );

			if ( '' === $author_url ) {
				$author_url = $url;
			}

			if ( '' === $avatar ) {
				$avatar = get_template_directory_uri() . '/images/mystery-person.png';
			}

			?>

			<!-- Markup inspired by https://indieweb.org/like -->
			<article class="p-bookmark h-cite">
				<!-- The loading attribute is only supported by Chrome right now, but I'd like to not use JavaScript for this. -->
				<img src="<?php echo esc_url( $avatar ); ?>" width=40 alt="" loading="lazy" />

				<!-- This span is my lazy way of enabling a vertically aligned flex display on the article element. -->
				<span>
					<a class="p-author h-card" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $like->comment_author ); ?></a>
					bookmarked this on
					<a class="u-url" href="<?php echo esc_url( $url ); ?>">
						<time class="dt-published"><?php echo get_comment_date( 'F j, Y \a\t g:i a', $like ); ?></time>
					</a>
				</span>
			</article>

			<?php
		}

		endif;

		if ( 0 < count( $typed_comments['mention'] ) ) :
		?>

		<h3>Mentions</h3>
		<?php
		foreach ( $typed_comments['mention'] as $mention_id ) {
			$mention = get_comment( $mention_id );
			$url = get_comment_meta( $mention_id, 'webmention_source_url', true );
			$avatar = get_comment_meta( $mention_id, 'avatar', true );
			$author_url = get_comment_meta( $mention_id, 'semantic_linkbacks_author_url', true );

			if ( '' === $author_url ) {
				$author_url = $url;
			}

			if ( '' === $avatar ) {
				$avatar = get_template_directory_uri() . '/images/mystery-person.png';
			}
			?>

			<article class="p-mention h-cite">
				<!-- The loading attribute is only supported by Chrome right now, but I'd like to not use JavaScript for this. -->
				<img src="<?php echo esc_url( $avatar ); ?>" width=40 alt="" loading="lazy" />

				<!-- This span is my lazy way of enabling a vertically aligned flex display on the article element. -->
				<span>
					<a class="p-author h-card" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $mention->comment_author ); ?></a>
					mentioned this on
					<a class="u-url" href="<?php echo esc_url( $url ); ?>">
						<time class="dt-published"><?php echo get_comment_date( 'F j, Y \a\t g:i a', $mention ); ?></time>
					</a>
				</span>
			</article>
			<?php
		}

		endif;

		if ( 0 < count( $typed_comments['reply'] ) ) :
		?>

		<h3>Replies</h3>

		<?php

		// Retrieve only the comments classified as replies.
		$comments = get_comments( array(
			'comment__in' => $typed_comments['reply'],
		) );

		wp_list_comments( array(
			'walker' => new Writemore_Comment_Walker(),
			'style' => 'div',
			'format' => 'html5',
		), $comments );

		endif;

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) {
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'writemore' ); ?></p>
			<?php
		}

	endif; // Check for have_comments().

	comment_form();
	?>

</div><!-- #comments -->
