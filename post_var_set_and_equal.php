<?php # -*- coding: utf-8 -*-

require_once 'inc/functions.php';

print_header(
	'Benchmark',
	'post_var_set_and_equal',
	'Check If a Specific Variable in the <code>$_POST</code> Superglobal is Set and Equal to a Specific Value'
);
?>
	<h3>The Data Sets</h3>
	Each data set consists of the <code>$_POST</code> superglobal having a specific state.

	<h4>Data Set 1</h4>
	<p>
		For this data set, the variable is both set and equal to the comparison value.
	</p>
	<pre>
$_POST[ $key ] = $value;
</pre>
	<h4>Data Set 2</h4>
	<p>
		For this data set, the variable is set but not equal to the comparison value.
	</p>
	<pre>
$_POST[ $key ] = $value . 's';
</pre>
	<h4>Data Set 3</h4>
	<p>
		For this data set, the variable is not set.
	</p>
	<pre>
unset( $_POST[ $key ] );
</pre>

	<h3>The Algorithms</h3>
	<h4>Algorithm 1</h4>
	<pre>
/**
 * Check for existence first, then for equality.
 *
 * @param string $key   Desired array key.
 * @param string $value Comparison value.
 *
 * @return bool
 */
function algorithm_1( $key, $value ) {

	return ( isset( $_POST[ $key ] ) && $_POST[ $key ] === $value );
}
</pre>
	<h4>Algorithm 2</h4>
	<pre>
/**
 * Directly check the filtered superglobal variable for equality.
 *
 * @param string $key   Desired array key.
 * @param string $value Comparison value.
 *
 * @return bool
 */
function algorithm_2( $key, $value ) {

	return ( filter_input( INPUT_POST, $key ) === $value );
}
</pre>
<?php
/**
 * Check for existence first, then for equality.
 *
 * @param string $key   Desired array key.
 * @param string $value Comparison value.
 *
 * @return bool
 */
function algorithm_1( $key, $value ) {

	return ( isset( $_POST[ $key ] ) && $_POST[ $key ] === $value );
}

/**
 * Directly check the filtered superglobal variable for equality.
 *
 * @param string $key   Desired array key.
 * @param string $value Comparison value.
 *
 * @return bool
 */
function algorithm_2( $key, $value ) {

	return ( filter_input( INPUT_POST, $key ) === $value );
}

// Benchmark
$results = array();

$key = 'foo';
$value = 'bar';

for ( $data_set = 1; $data_set <= 3; $data_set++ ) {
	switch ( $data_set ) {
		case 1:
			$_POST[ $key ] = $value;
			break;

		case 2:
			$_POST[ $key ] = $value . 's';
			break;

		case 3:
			unset( $_POST[ $key ] );
	}

	for ( $algorithm = 1; $algorithm <= 2; $algorithm++ ) {
		flush();
		$start = microtime();
		call_user_func( 'algorithm_' . $algorithm, $key, $value );
		$results[ $data_set ][ $algorithm ] = microtime() - $start;
	}
}

print_results( $results );

print_footer();
