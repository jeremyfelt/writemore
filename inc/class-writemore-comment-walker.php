<?php

class Writemore_Comment_Walker extends Walker_Comment {
	/**
	 * Starts the element output.
	 *
	 * This was forked from WordPress 5.3.2.
	 *
	 * @since 1.1.0
	 * @since WordPress 2.7.0
	 *
	 * @see Walker::start_el()
	 * @see wp_list_comments()
	 * @global int        $comment_depth
	 * @global WP_Comment $comment       Global comment object.
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment Comment data object.
	 * @param int        $depth   Optional. Depth of the current comment in reference to parents. Default 0.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 * @param int        $id      Optional. ID of the current comment. Default 0 (unused).
	 */
	public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;
		$GLOBALS['comment']       = $comment;

		if ( ! empty( $args['callback'] ) ) {
			ob_start();
			call_user_func( $args['callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		if ( ( 'pingback' == $comment->comment_type || 'trackback' == $comment->comment_type ) && $args['short_ping'] ) {
			ob_start();
			$this->ping( $comment, $depth, $args );
			$output .= ob_get_clean();
		} elseif ( 'html5' === $args['format'] ) {
			ob_start();
			$this->html5_comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		} else {
			ob_start();
			$this->comment( $comment, $depth, $args );
			$output .= ob_get_clean();
		}
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * This was forked from WordPress 5.3.2.
	 *
	 * @since 1.1.0
	 * @since WordPress 2.7.0
	 *
	 * @see Walker::end_el()
	 * @see wp_list_comments()
	 *
	 * @param string     $output  Used to append additional content. Passed by reference.
	 * @param WP_Comment $comment The current comment object. Default current comment.
	 * @param int        $depth   Optional. Depth of the current comment. Default 0.
	 * @param array      $args    Optional. An array of arguments. Default empty array.
	 */
	public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
		if ( ! empty( $args['end-callback'] ) ) {
			ob_start();
			call_user_func( $args['end-callback'], $comment, $args, $depth );
			$output .= ob_get_clean();
			return;
		}

		$output .= "</li><!-- #comment-## -->\n";
	}

	/**
	 * Outputs a comment in the HTML5 format.
	 *
	 * This was forked from WordPress 5.3.2.
	 *
	 * @since 1.1.0
	 * @since WordPress 3.6.0
	 *
	 * @see wp_list_comments()
	 *
	 * @param WP_Comment $comment Comment to display.
	 * @param int        $depth   Depth of the current comment.
	 * @param array      $args    An array of arguments.
	 */
	protected function html5_comment( $comment, $depth, $args ) {
		$commenter = wp_get_current_commenter();
		if ( $commenter['comment_author_email'] ) {
			$moderation_note = __( 'Your comment is awaiting moderation.' );
		} else {
			$moderation_note = __( 'Your comment is awaiting moderation. This is a preview, your comment will be visible after it has been approved.' );
		}

		$url = get_comment_meta( $comment->comment_ID, 'webmention_source_url', true );

		if ( '' === $url ) {
			$url = $comment->comment_author_url;
		}

		$author_url = get_comment_meta( $comment->comment_ID, 'semantic_linkbacks_author_url', true );

		if ( '' === $author_url ) {
			$author_url = $url;
		}

		// An avatar URL is stored with a Webmention, even if an email is not provided. Look
		// there before trying to build an avatar based on a comment's email.
		$avatar = get_comment_meta( $comment->comment_ID, 'avatar', true );

		// If there is no stored avatar URL, use WordPress to make default assumptions.
		if ( '' === $avatar ) {
			$avatar = get_avatar_url( $comment );
		}

		// And if there is still nothing, use the theme's mystery person.
		if ( '' === $avatar ) {
			$avatar = get_template_directory_uri() . '/images/mystery-person.png';
		}

		?>
		<li id="comment-<?php comment_ID(); ?>" <?php comment_class( $this->has_children ? 'parent' : '', $comment ); ?>>
			<article id="div-comment-<?php comment_ID(); ?>" class="comment-body">
				<footer class="comment-meta">
					<!-- This span is my lazy way of enabling a vertically aligned flex display on the article element. -->
					<div class="comment-author vcard">
						<?php
						/*
						if ( false !== $avatar ) {
							?>
							<img class="avatar" src="<?php echo esc_url( $avatar ); ?>" width=40 alt="" loading="lazy" />
							<?php
						}
						*/

						if ( 0 != $args['avatar_size'] ) {
							echo get_avatar( $comment, $args['avatar_size'] );
						}
						?>
						<a class="u-author h-card fn" href="<?php echo esc_url( $author_url ); ?>"><?php echo esc_html( $comment->comment_author ); ?></a>
							<span class="says">replied:</span>
					</div>

					<div class="comment-metadata">
						<?php
						printf(
							'<a class="u-url" href="%s"><time class="dt-published" datetime="%s">%s</time></a>',
							esc_url( $url ),
							get_comment_time( 'c' ),
							sprintf(
								/* translators: 1: Comment date, 2: Comment time. */
								__( '%1$s at %2$s' ),
								get_comment_date( 'F j, Y', $comment ),
								get_comment_time()
							)
						);

						edit_comment_link( __( 'Edit' ), ' <span class="edit-link">', '</span>' );
						?>
					</div><!-- .comment-metadata -->

					<?php if ( '0' == $comment->comment_approved ) : ?>
					<em class="comment-awaiting-moderation"><?php echo $moderation_note; ?></em>
					<?php endif; ?>

				</footer><!-- .comment-meta -->

				<div class="comment-content e-content">
					<?php
						// This is hilarious, but I'm feeling lazy. Replace all single line breaks in a
						// comment with a double linke break so that wpautop() uses paragraph tags instead
						// of <br> tags.
						$comment_text = str_replace( "\n", "\n\n", get_comment_text( $comment, $args ) );
						echo wpautop( $comment_text, false );
					?>
				</div><!-- .comment-content -->

				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'add_below' => 'div-comment',
							'depth'     => $depth,
							'max_depth' => $args['max_depth'],
							'before'    => '<div class="reply">',
							'after'     => '</div>',
							'reply_text' => 'Reply',
						)
					)
				);
				?>
			</article>
		<?php
	}
}
