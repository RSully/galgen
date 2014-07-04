<?php
$_gg_data = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data.json'), true);
$images = $_gg_data['images'];
$title = $_gg_data['title'];
$image = isset($_GET['image']) && in_array($_GET['image'], $images) ? $_GET['image'] : null;
?>
