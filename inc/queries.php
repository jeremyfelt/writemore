<?php
/**
 * Filter queries.
 *
 * This should be moved somewhere else one day.
 *
 * @package writemore
 */

namespace Writemore\Queries;

add_action( 'pre_get_posts', __NAMESPACE__ . '\filter_queries', 11 );

/**
 * Filter queries.
 *
 * @param \WP_Query $query The query.
 */
function filter_queries( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( $query->is_search() || $query->is_archive() || $query->is_home() ) {
		$query->set( 'posts_per_page', 25 );
	}

	if ( $query->is_post_type_archive( 'like' ) ) {
		$query->set( 'posts_per_page', 50 );
	}
}
