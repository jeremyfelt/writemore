<?php
/**
 * Output functions.
 *
 * @package writemore
 */

namespace Writemore\Output;

use ShortNotes\PostType\Note;

/**
 * Display the excerpt for a piece of content.
 *
 * @return void
 */
function excerpt(): void {
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
 * Display the published date.
 *
 * @param string $version The version of the output to use. Microformat, full, or basic.
 * @return void
 */
function published( string $version = 'microformat' ): void {
	$now  = new \DateTime();
	$date = new \DateTime( get_the_time( 'c' ) );

	// Include the year for items published in previous years.
	if ( $now->format( 'Y' ) === $date->format( 'Y' ) ) {
		$format = 'M j';
	} else {
		$format = 'M j, Y ';
	}

	$post    = get_post();
	$content = strtolower( $post->post_content );
	$weather = '';
	if ( str_contains( $content, ' snow' ) ) {
		$weather .= '❄️';
	}

	if ( str_contains( $content, ' rain' ) ) {
		$weather .= '🌧';
	}

	if ( str_contains( $content, ' sunny' ) ) {
		$weather .= '☀️';
	}

	// Determine if the date is morning, midday, afternoon, evening, or night
	$hour = $date->format( 'G' );
	if ( $hour < 6 ) {
		$day_part = 'early morning';
	} elseif ( $hour < 10 ) {
		$day_part = 'morning';
	} elseif ( $hour < 12 ) {
		$day_part = 'late morning';
	} elseif ( $hour < 16 ) {
		$day_part = 'afternoon';
	} elseif ( $hour < 18 ) {
		$day_part = 'late afternoon';
	} elseif ( $hour < 22 ) {
		$day_part = 'evening';
	} else {
		$day_part = 'night';
	}

	if ( 'full' === $version ) {
		?>
		<div class="published-wrapper"><span class="screen-reader-text">Published </span>
			<span class="day"><?php echo esc_attr( $date->format( 'l' ) ); ?> <?php echo $day_part; ?></span>
			<time datetime="<?php echo esc_attr( $date->format( \DateTimeInterface::ATOM ) ); ?>"><?php echo esc_attr( $date->format( $format ) ); ?></time>
			<span class="moon-phase"><?php echo moon_phase( $date->getTimestamp() ); ?></span>
			<span class="weather"><?php echo $weather; ?></span>
		</div>
		<?php
	} elseif ( 'basic' === $version ) {
		$format .= ' g:ia';
		?>
		<a href="<?php the_permalink(); ?>">
			<span class="screen-reader-text">Published </span>
			<time datetime="<?php echo esc_attr( $date->format( \DateTimeInterface::ATOM ) ); ?>"><?php echo esc_attr( $date->format( $format ) ); ?></time></a>
		<?php
	} elseif ( 'microformat' === $version ) {
		$format .= ' g:ia';
		?>
		<p><a href="<?php the_permalink(); ?>" class="u-url"><span class="screen-reader-text">Published </span>
			<time class="dt-published" datetime="<?php echo esc_attr( $date->format( \DateTimeInterface::ATOM ) ); ?>"><?php echo esc_attr( $date->format( $format ) ); ?></time>
		</a></p>
		<?php
	}
}

/**
 * Display the current moon phase as an emoji.
 *
 * @see https://web.archive.org/web/20090218203728/http://home.att.net/~srschmitt/lunarphasecalc.html
 *
 * @param int $timestamp The timestamp.
 */
function moon_phase( int $timestamp ): void {
	$julian_day =
		( $timestamp / 86400 ) // The number of days since January 1, 1970.
		+ 2440587.5; // The number of days before January 1, 1970.

	// The number of days since an arbitrary new moon cycle starts on January 6, 2000.
	$days_since_first_new_moon = $julian_day - 2451550.1;

	// The age of the current cycle.
	$moon_age = fmod( ( $days_since_first_new_moon + 29.53058853 ), 29.53058853 );

	switch ( $moon_age ) {
		case $moon_age < 1.84566:
			$phase = '🌑';
			break;
		case $moon_age < 5.53699:
			$phase = '🌒';
			break;
		case $moon_age < 9.22831:
			$phase = '🌓';
			break;
		case $moon_age < 12.91963:
			$phase = '🌔';
			break;
		case $moon_age < 16.61096:
			$phase = '🌕';
			break;
		case $moon_age < 20.30228:
			$phase = '🌖';
			break;
		case $moon_age < 23.99361:
			$phase = '🌗';
			break;
		case $moon_age < 27.68493:
			$phase = '🌘';
			break;
		default:
			$phase = '🌑';
			break;
	}

	echo $phase;
}

/**
 * Display a group of other notes to accompany the current note.
 *
 * The next note. The prior note. The most recent note. Two random notes.
 */
function other_notes(): void {
	global $wpdb;

	$next_note_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' AND ID > %d ORDER BY ID ASC LIMIT 1",
			Note\get_slug(),
			get_the_ID()
		)
	);
	$next_note_ids = wp_list_pluck( $next_note_ids, 'ID' );

	$prior_note_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' AND ID < %d ORDER BY ID DESC LIMIT 1",
			Note\get_slug(),
			get_the_ID()
		)
	);
	$prior_note_ids = wp_list_pluck( $prior_note_ids, 'ID' );

	$recent_note_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' ORDER BY ID DESC LIMIT 1",
			Note\get_slug()
		)
	);
	$recent_note_ids = wp_list_pluck( $recent_note_ids, 'ID' );

	$random_note_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' ORDER BY RAND() LIMIT 2",
			Note\get_slug()
		)
	);
	$random_note_ids = wp_list_pluck( $random_note_ids, 'ID' );

	$other_note_ids = array_merge( $next_note_ids, $prior_note_ids, $recent_note_ids, $random_note_ids );
	$other_note_ids = array_unique( $other_note_ids );
	$other_note_ids = array_diff( $other_note_ids, [ get_the_ID() ] );

	$other_notes = new \WP_Query(
		[
			'post_type'              => Note\get_slug(),
			'post__in'               => $other_note_ids,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		]
	);

	if ( $other_notes->have_posts() ) {
		?>
		<h2>Other notes</h2>
		<ul>
		<?php
		while ( $other_notes->have_posts() ) {
			$other_notes->the_post();
			?>
			<li><?php published( 'basic' ); ?> <?php echo str_replace( 'Note: ', '', get_the_title() ); ?></li>
			<?php
		}
		?>
		</ul>
		<?php
	}
	wp_reset_postdata();
}

/**
 * Display a group of other likes to accompany the current like.
 *
 * The next like. The prior like. The most recent like. Two random likes.
 */
function other_likes(): void {
	global $wpdb;

	$next_like_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' AND ID > %d ORDER BY ID ASC LIMIT 1",
			'like',
			get_the_ID()
		)
	);
	$next_like_ids = wp_list_pluck( $next_like_ids, 'ID' );

	$prior_like_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' AND ID < %d ORDER BY ID DESC LIMIT 1",
			'like',
			get_the_ID()
		)
	);
	$prior_like_ids = wp_list_pluck( $prior_like_ids, 'ID' );

	$recent_like_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' ORDER BY ID DESC LIMIT 1",
			'like'
		)
	);
	$recent_like_ids = wp_list_pluck( $recent_like_ids, 'ID' );

	$random_like_ids = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT ID FROM $wpdb->posts WHERE post_type = %s AND post_status = 'publish' ORDER BY RAND() LIMIT 2",
			'like'
		)
	);
	$random_like_ids = wp_list_pluck( $random_like_ids, 'ID' );

	$other_like_ids = array_merge( $next_like_ids, $prior_like_ids, $recent_like_ids, $random_like_ids );
	$other_like_ids = array_unique( $other_like_ids );
	$other_like_ids = array_diff( $other_like_ids, [ get_the_ID() ] );

	$other_likes = new \WP_Query(
		[
			'post_type'              => 'like',
			'post__in'               => $other_like_ids,
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false,
		]
	);

	if ( $other_likes->have_posts() ) {
		?>
		<h2>Other likes</h2>
		<ul>
		<?php
		while ( $other_likes->have_posts() ) {
			$other_likes->the_post();
			?>
			<li><?php published( 'basic' ); ?> <?php echo str_replace( 'like: ', '', get_the_title() ); ?></li>
			<?php
		}
		?>
		</ul>
		<?php
	}
	wp_reset_postdata();
}
