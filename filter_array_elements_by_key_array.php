<?php # -*- coding: utf-8 -*-

require_once 'inc/functions.php';

print_header(
	'Benchmark',
	'filter_array_elements_by_key_array',
	'Filter All Array Elements Having a Key from a Predefined Set of Keys'
);
?>
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

<?php for ( $id = 1, $count = $factor = 8; $id <= 3; $id++, $count *= $factor ) : ?>
	<h4>Data Set <?php echo $id; ?></h4>
	<p>
		This data set consists of an array with <?php echo $count; ?> elements, and another array with <?php echo $count / 4; ?> random keys from the first array (as values).
	</p>
	<pre>
$count = <?php echo $count; ?>;
$keys_and_values = get_keys_and_values( $count );
$some_of_the_keys = get_some_of_the_keys( $keys_and_values, $count / 4 );
</pre>
<?php endfor; ?>

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

// Benchmark
$results = array();

for ( $data_set = 1, $count = $factor = 8; $data_set <= 3; $data_set++, $count *= $factor ) {
	$keys_and_values = get_keys_and_values( $count );
	$some_of_the_keys = get_some_of_the_keys( $keys_and_values, $count / 4 );

	for ( $algorithm = 1; $algorithm <= 5; $algorithm++ ) {
		flush();
		$start = microtime();
		call_user_func( 'algorithm_' . $algorithm, $keys_and_values, $some_of_the_keys );
		$results[ $data_set ][ $algorithm ] = microtime() - $start;
	}
}

print_results( $results );

print_footer();
