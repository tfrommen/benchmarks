<?php # -*- coding: utf-8 -*- ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Benchmarks: array_intersect_key</title>

	<link href="assets/css/general.css" media="all" rel="stylesheet">
</head>
<body>
<header>
	<h1>Benchmarks: <code>array_intersect_key</code></h1>

	<h2>Filter All Array Elements Having a Key from a Predefined Set of Keys</h2>
</header>
<hr>
<h3>The Data Sets</h3>
All data sets consist of one array having a given number of elements, and another array having some random keys of the first array (as values). The data sets will be generated using the following functions:
<pre>
/**
 * Return an array with given number of elements, each having a random key and value.
 *
 * @param int $count Number of elements.
 *
 * @return array
 */
function get_keys_and_values( $count ) {

	$keys_and_values = array();

	while ( $count-- ) {
		$keys_and_values[ md5( rand() ) ] = md5( rand() );
	}

	return $keys_and_values;
}

/**
 * Return given number of random keys from given array.
 *
 * @param array $keys_and_values Array to get random keys from.
 * @param int   $count           Number of elements.
 *
 * @return array
 */
function get_some_of_the_keys( array $keys_and_values, $count ) {

	shuffle( $keys_and_values );

	return array_slice( array_keys( $keys_and_values ), 0, $count );
}
</pre>
<?php
$count = $factor = 8;
for ( $id = 1; $id <= 3; $id++, $count *= $factor ) {
	print_data_set_block( $id, $count );
}
?>
<hr>
<h3>The Algorithms</h3>
<h4>Algorithm 1</h4>
<pre>
/**
 * Loop through the full array, and check for each key if it exists in the key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_1( $keys_and_values, $some_of_the_keys ) {

	foreach ( $keys_and_values as $key => $value ) {
		if ( ! in_array( $key, $some_of_the_keys ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}
</pre>
<h4>Algorithm 2</h4>
<pre>
/**
 * Loop through the full array, and check for each key if the according element is set in the flipped key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_2( $keys_and_values, $some_of_the_keys ) {

	$some_of_the_keys = array_flip( $some_of_the_keys );
	foreach ( $keys_and_values as $key => $value ) {
		if ( ! isset( $some_of_the_keys[ $key ] ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}
</pre>
<h4>Algorithm 3</h4>
<pre>
/**
 * Loop through the keys of the full array, and check for each one if it exists in the key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_3( $keys_and_values, $some_of_the_keys ) {

	foreach ( array_keys( $keys_and_values ) as $key ) {
		if ( ! in_array( $key, $some_of_the_keys ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}
</pre>
<h4>Algorithm 4</h4>
<pre>
/**
 * Loop through the keys of the full array, and check for each one if the according element is set in the flipped key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_4( $keys_and_values, $some_of_the_keys ) {

	$some_of_the_keys = array_flip( $some_of_the_keys );
	foreach ( array_keys( $keys_and_values ) as $key ) {
		if ( ! isset( $some_of_the_keys[ $key ] ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}
</pre>
<h4>Algorithm 5</h4>
<pre>
/**
 * Set the full array to the intersection by key (!) of itself and the flipped key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_5( $keys_and_values, $some_of_the_keys ) {

	$keys_and_values = array_intersect_key( $keys_and_values, array_flip( $some_of_the_keys ) );

	return $keys_and_values;
}
</pre>
<?php
/**
 * Render the data set information for the given number of elements.
 *
 * @param int $id    Data set ID.
 * @param int $count Number of elements.
 *
 * @return void
 */
function print_data_set_block( $id, $count ) {

	?>
	<h4>Data Set <?php echo $id; ?></h4>
	<p>
		This data set consists of an array <em>A</em> with <?php echo $count; ?> elements, and an array
		<em>B</em> with <?php echo $count / 4; ?> random keys from <em>A</em> (as values).
	</p>
	<pre>
$count = <?php echo $count; ?>;
$keys_and_values = get_keys_and_values( $count );
$some_of_the_keys = get_some_of_the_keys( $keys_and_values, $count / 4 );
	</pre>
<?php
}

/**
 * Return an array with given number of elements, each having a random key and value.
 *
 * @param int $count Number of elements.
 *
 * @return array
 */
function get_keys_and_values( $count ) {

	$keys_and_values = array();

	while ( $count-- ) {
		$keys_and_values[ md5( rand() ) ] = md5( rand() );
	}

	return $keys_and_values;
}

/**
 * Return given number of random keys from given array.
 *
 * @param array $keys_and_values Array to get random keys from.
 * @param int   $count           Number of elements.
 *
 * @return array
 */
function get_some_of_the_keys( array $keys_and_values, $count ) {

	shuffle( $keys_and_values );

	return array_slice( array_keys( $keys_and_values ), 0, $count );
}

/**
 * Run algorithm with given ID, if it exists.
 *
 * @param int   $id               Algorithm ID.
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return bool
 */
function run_algorithm( $id, $keys_and_values, $some_of_the_keys ) {

	if ( ! function_exists( $algorithm = 'algorithm_' . $id ) ) {
		return FALSE;
	}

	call_user_func( $algorithm, $keys_and_values, $some_of_the_keys );

	return TRUE;
}

/**
 * Loop through the full array, and check for each key if it exists in the key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_1( $keys_and_values, $some_of_the_keys ) {

	foreach ( $keys_and_values as $key => $value ) {
		if ( ! in_array( $key, $some_of_the_keys ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}

/**
 * Loop through the full array, and check for each key if the according element is set in the flipped key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_2( $keys_and_values, $some_of_the_keys ) {

	$some_of_the_keys = array_flip( $some_of_the_keys );
	foreach ( $keys_and_values as $key => $value ) {
		if ( ! isset( $some_of_the_keys[ $key ] ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}

/**
 * Loop through the keys of the full array, and check for each one if it exists in the key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_3( $keys_and_values, $some_of_the_keys ) {

	foreach ( array_keys( $keys_and_values ) as $key ) {
		if ( ! in_array( $key, $some_of_the_keys ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}

/**
 * Loop through the keys of the full array, and check for each one if the according element is set in the flipped key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_4( $keys_and_values, $some_of_the_keys ) {

	$some_of_the_keys = array_flip( $some_of_the_keys );
	foreach ( array_keys( $keys_and_values ) as $key ) {
		if ( ! isset( $some_of_the_keys[ $key ] ) ) {
			unset( $keys_and_values[ $key ] );
		}
	}

	return $keys_and_values;
}

/**
 * Set the full array to the intersection by key (!) of itself and the flipped key array.
 *
 * @param array $keys_and_values  Source array.
 * @param array $some_of_the_keys Some random keys of the source array (as values).
 *
 * @return array
 */
function algorithm_5( $keys_and_values, $some_of_the_keys ) {

	$keys_and_values = array_intersect_key( $keys_and_values, array_flip( $some_of_the_keys ) );

	return $keys_and_values;
}

// Benchmark
$results = array();

$count = $factor = 8;
for ( $data_set = 1; $data_set <= 3; $data_set++, $count *= $factor ) {
	$keys_and_values = get_keys_and_values( $count );
	$some_of_the_keys = get_some_of_the_keys( $keys_and_values, $count / 4 );

	for ( $algorithm = 1; $algorithm <= 5; $algorithm++ ) {
		$start = microtime();
		run_algorithm( $algorithm, $keys_and_values, $some_of_the_keys );
		$results[ $data_set ][ $algorithm ] = number_format( microtime() - $start, 24 );
	}
}
?>
<hr>
<h3>The Results</h3>
<table id="results">
	<thead>
	<tr>
		<th></th>
		<?php foreach ( array_keys( reset( $results ) ) as $algorithm ) : ?>
			<th>Algorithm <?php echo $algorithm; ?></th>
		<?php endforeach; ?>
		<th>Difference</th>
		<th>Percent</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ( $results as $data_set => $algorithms ) : ?>
		<?php
		$min = min( $algorithms );
		$max = max( $algorithms );
		$diff = number_format( $max - $min, 24 );
		$percent = number_format( 100 / $min * $max, 2, '.', '' );
		?>
		<tr>
			<th>Data Set <?php echo $data_set; ?></th>
			<?php foreach ( $algorithms as $time ) : ?>
				<?php
				$class = '';
				$classes = array();
				if ( $time === $min ) {
					$classes[ ] = 'min';
				} elseif ( $time === $max ) {
					$classes[ ] = 'max';
				}
				if ( $classes ) {
					$class = ' class="' . implode( ' ', $classes ) . '"';
				}
				?>
				<td<?php echo $class; ?>><?php echo $time; ?></td>
			<?php endforeach; ?>
			<td>+<?php echo $diff; ?> ms</td>
			<td>+<?php echo $percent; ?> %</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<hr>
If you are interested in the source code, please have a look at the according <a
	href="https://github.com/tfrommen/benchmarks" rel="external">GitHub repository</a>.
</body>
</html>
