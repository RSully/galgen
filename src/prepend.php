<?php
$_gg_data_raw = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'data.json');
$_gg_data = json_decode($_gg_data_raw, true);

$images = $_gg_data['images'];
$title = $_gg_data['title'];

if (isset($_GET['image']) && in_array($_GET['image'], $images))
{
	$image = $_GET['image'];
}

if ($image)
{
	$imageIndex = array_search($image, $images);

	$imagePreviousIndex = $imageIndex - 1;
	$imageNextIndex = $imageIndex + 1;

	if (isset($images[$imagePreviousIndex]))
	{
		$imagePrevious = $images[$imagePreviousIndex];
	}
	if (isset($images[$imageNextIndex]))
	{
		$imageNext = $images[$imageNextIndex];
	}
}
?>
