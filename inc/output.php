<?php
/**
 * Output functions.
 *
 * @package writemore
 */

namespace Writemore\Output;

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
 * @param bool $microformat bool Whether to wrap with microformat data.
 * @return void
 */
function published( bool $microformat = true ): void {
	$now  = new \DateTime();
	$date = new \DateTime( get_the_time( 'c' ) );

	// Include the year for items published in previous years.
	if ( $now->format( 'Y' ) === $date->format( 'Y' ) ) {
		$format = 'l, M j';
	} else {
		$format = 'l, M j, Y ';
	}

	$post = get_post();
	$more = '';
	if ( str_contains( $post->post_content, ' snow' ) ) {
		$more .= '❄️';
	}

	if ( str_contains( $post->post_content, ' rain' ) ) {
		$more .= '🌧';
	}

	if ( str_contains( $post->post_content, ' sunny' ) ) {
		$more .= '☀️';
	}

	if ( false === $microformat ) {
		?>
		<div class="published-wrapper"><span class="screen-reader-text">Published </span>
			<time datetime="<?php echo esc_attr( $date->format( \DateTimeInterface::ATOM ) ); ?>"><?php echo esc_attr( $date->format( $format ) ); ?></time>
			<span class="moon-phase"><?php echo moon_phase( $date->getTimestamp() ); ?><?php echo $more; ?></span>
		</div>
		<?php
	} else {
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
