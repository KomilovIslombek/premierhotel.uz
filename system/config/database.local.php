<?php
if ($_SERVER['HTTP_HOST'] == "premierhotel.uz" || $_SERVER['HTTP_HOST'] == "www.premierhotel.uz") {
	return array (
	  'pdo' => 
		array (
			'db_host' => 'localhost',
			'db_name' => 'premierhotel',
			'db_user' => 'premierhotel',
			'db_pass' => 'UaLA0VMZiSEydPxX',
		),
	);
} else {
	return array (
		'pdo' => 
		array (
			'db_host' => 'localhost',
			'db_name' => 'premierhotel',
			'db_user' => 'root',
			'db_pass' => '',
		),
	);
}