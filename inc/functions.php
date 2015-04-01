<?php # -*- coding: utf-8 -*-

/**
 * Print the dynamic header section, with title and optional titles.
 *
 * @param string $title     Title.
 * @param string $benchmark Optional. Benchmark title. Defaults to ''.
 * @param string $subtitle  Optional. Subtitle. Defaults to ''.
 *
 * @return void
 */
function print_header( $title, $benchmark = '', $subtitle = '' ) {

	if ( $benchmark === '' ) {
		$h1 = $title;
	} else {
		$h1 = "$title: <code>$benchmark</code>";
		$title .= " $benchmark";
	}

	if ( $subtitle !== '' ) {
		$subtitle = "
<h2>$subtitle</h2>";
	}

	printf(
		'
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>%s</title>

	<link href="assets/css/general.css" media="all" rel="stylesheet">
</head>
<body>
<h1>%s</h1>%s
<hr>',
		$title,
		$h1,
		$subtitle
	);
}

/**
 * Print results section.
 *
 * @param array $results Results data.
 *
 * @return void
 */
function print_results( $results = array() ) {

	echo '
<hr>
<h3>The Results</h3>';

	if ( ! $results ) {
		return;
	}

	echo '
<table class="results">
	<thead>
	<tr>
		<th></th>';

	foreach ( array_keys( reset( $results ) ) as $algorithm ) {
		printf(
			'
		<th class="algorithm">Algorithm %d</th>',
			$algorithm
		);
	}

	echo '
		<th>Difference</th>
		<th>Percent</th>
	</tr>
	</thead>
	<tbody>';

	foreach ( $results as $data_set => $algorithms ) {
		$min = min( $algorithms );
		$max = max( $algorithms );

		printf(
			'
	<tr>
		<th>Data Set %d</th>',
			$data_set
		);

		foreach ( $algorithms as $time ) {
			$class = 'algorithm';
			if ( $time === $min ) {
				$class .= ' min';
			} elseif ( $time === $max ) {
				$class .= ' max';
			}

			$time = number_format( $time, 24 );

			printf(
				'
			<td class="%s">%s</td>',
				$class,
				$time
			);
		}

		$diff = number_format( $max - $min, 24 ) . ' ms';
		$percent = number_format( 100 * $max / $min - 100, 2, '.', '' ) . ' % ';

		printf(
			'
		<td>%s</td>
		<td>%s</td>
	</tr> ',
			$diff,
			$percent
		);
	}

	echo '
	</tbody>
</table>';
}

/**
 * Print the static footer section.
 *
 * @return void
 */
function print_footer() {

	echo '
<hr>
<p>
	This server is running <strong>PHP ' . phpversion() . '</strong>.
</p>
<p>
	If you are interested in the source code, please have a look at the according <a href="https://github.com/tfrommen/benchmarks" rel="external">GitHub repository</a>.
</p>
</body>
</html>';
}
