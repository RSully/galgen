<?php
if ( ! isset($image))
{
	header('Location: ?image=' . urlencode($images[0]));
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>

	<link rel="stylesheet" type="text/css" href="static/reset.css">
	<script type="text/javascript" src="static/jquery-2.1.1.min.js"></script>

	<script type="text/javascript">
	imagePrevious = <?=json_encode(isset($imagePrevious) ? $imagePrevious : null)?>;
	imageNext = <?=json_encode(isset($imageNext) ? $imageNext : null)?>;

	function resizeImage()
	{
		$('#image').height($(window).height());
	}

	function gotoImage(image)
	{
		if ( ! image) return;
		document.location = "?image=" + encodeURIComponent(image);
	}

	function preloadImage(url, callback) {
		var img = new Image();
		$(img).on('load', callback).attr('src', url);
	}

	$(document).ready(function()
	{
		// Handle resizing and making the image as big as possible
		resizeImage();
		$(window).on('resize', function()
		{
			resizeImage();
		});

		// Handle moving back/forth using keys
		$(document).on('keyup', function(event)
		{
			if (event.which == 37)
			{
				gotoImage(imagePrevious);
			}
			else if (event.which == 39)
			{
				gotoImage(imageNext);
			}
		});

		// Cache the surrounding images
		preloadImage(imageNext);
		preloadImage(imagePrevious);
	});
	</script>
</head>
<body>
	<?php if (isset($image)): ?>
		<img id="image" src="<?=$image?>">
	<?php endif; ?>
</body>
</html>
