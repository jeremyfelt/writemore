<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package writemore
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

<section id="comments">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h2>Responses and reactions</h2>

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

		$skip_actions = array(
			'repost',
			'tag',
			'rsvp:yes',
			'rsvp:no',
			'rsvp:maybe',
			'rsvp:interested',
			'invited',
			'listen',
			'read',
			'watch',
			'follow',
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

			// Skip the actions that aren't handled.
			if ( in_array( $type, $skip_actions, true ) ) {
				continue;
			}

			$typed_comments[ $type ][] = $comment_id;
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
			$type = get_comment_meta( $comment_id, 'semantic_linkbacks_type', true );

			if ( '' === $author_url ) {
				$author_url = $url;
			}

			if ( '' === $avatar ) {
				$avatar = get_template_directory_uri() . '/images/mystery-person.png';
			}

			$u_class = 'u-like';

			// Even though favorites are classified as likes, use the correct markup.
			if ( 'favorite' === $type ) {
				$u_class = 'u-favorite';
			}

			?>

			<!-- Markup inspired by https://indieweb.org/like -->
			<article class="reaction <?php echo $u_class; ?> h-cite">
				<!-- The loading attribute is only supported by Chrome right now, but I'd like to not use JavaScript for this. -->
				<img src="<?php echo esc_url( $avatar ); ?>" width="40" alt="" loading="lazy" />

				<!-- This span is my lazy way of enabling a vertically aligned flex display on the article element. -->
				<span>
					<a class="u-author h-card" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $like->comment_author ); ?></a>
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
			<article class="reaction u-bookmark h-cite">
				<!-- The loading attribute is only supported by Chrome right now, but I'd like to not use JavaScript for this. -->
				<img src="<?php echo esc_url( $avatar ); ?>" width="40" alt="" loading="lazy" />

				<!-- This span is my lazy way of enabling a vertically aligned flex display on the article element. -->
				<span>
					<a class="u-author h-card" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $like->comment_author ); ?></a>
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

			<article class="reaction u-mention h-cite">
				<img src="<?php echo esc_url( $avatar ); ?>" width="40" alt="" loading="lazy" />

				<!-- This span is my lazy way of enabling a vertically aligned flex display on the article element. -->
				<span>
					<a class="u-author h-card" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $mention->comment_author ); ?></a>
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
			'avatar_size' => 60,
			'walker' => new Writemore_Comment_Walker(),
			'style' => '',
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
