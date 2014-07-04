<?php

require 'vendor/autoload.php';


$path = __DIR__ . '/example';

$config = [
	'ignore_files' => [
		'*._*',
	],
];

$gen = new RSully\Galgen\Generator($path, $config);

$result = $gen->generate();

print_r($result);
