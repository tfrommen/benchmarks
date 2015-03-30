<?php # -*- coding: utf-8 -*- ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>Benchmarks</title>
</head>
<body>
<h1>Benchmarks</h1>
<ul>
	<?php
	foreach ( glob( '*.php' ) as $file ) {
		if ( 'index.php' !== $file ) {
			printf(
				'<li><a href="%s">%s</a></li>',
				$file,
				basename( $file, '.php' )
			);
		}
	}
	?>
</ul>
<hr>
If you are interested in the source code, please have a look at the according <a
	href="https://github.com/tfrommen/benchmarks" rel="external">GitHub repository</a>.
</body>
</html>
