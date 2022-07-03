<?php

namespace Writemore\Navigation;

add_filter( 'navigation_markup_template', __NAMESPACE__ . '\filter_navigation_markup_template' );

function filter_navigation_markup_template() {
	$template = '
	<nav class="navigation %1$s" aria-label="%4$s">
		%3$s
	</nav>';

	return $template;
}
