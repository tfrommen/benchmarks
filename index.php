<?php # -*- coding: utf-8 -*-

$index_file = basename( __FILE__ );

require_once __DIR__ . '/inc/functions.php';

print_header( 'Benchmarks' );

echo '<ul>';

foreach ( glob( '*.php' ) as $file ) {
	if ( $index_file === $file ) {
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
