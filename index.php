<?php # -*- coding: utf-8 -*-

require_once 'inc/functions.php';

print_header( 'Benchmarks' );

echo '<ul>';

foreach ( glob( '*.php' ) as $file ) {
	if ( 'index.php' === $file ) {
		continue;
	}

	printf(
		'<li><a href="%s">%s</a></li>',
		$file,
		basename( $file, '.php' )
	);
}

echo '</ul>';

print_footer();
