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
		var img = $('#image');
		var map = $('map[name=imageMap]');

		img.height($(window).height());

		var height = img.height();
		var width = img.width();

		map.children('area').each(function()
		{
			var coordsPerc = $(this).data('coordsperc').split(',');

			var coords = [
				coordsPerc[0] * width,
				coordsPerc[1] * height,
				coordsPerc[2] * width,
				coordsPerc[3] * height
			];

			$(this).attr('coords', coords.join(', '));
		});
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
		$('#image').on('load', function()
		{
			resizeImage();
		});
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
		<img id="image" usemap="#imageMap" src="<?=htmlspecialchars(urlencode($image))?>">

		<map name="imageMap">
			<?php if (isset($imagePrevious)): ?>
				<area shape="rect" coords="0,0,0,0" data-coordsperc="0, 0, 0.5, 1" href="?image=<?=htmlspecialchars(urlencode($imagePrevious))?>">
			<?php endif; ?>
			<?php if (isset($imageNext)): ?>
				<area shape="rect" coords="0,0,0,0" data-coordsperc="0.5, 0, 1, 1" href="?image=<?=htmlspecialchars(urlencode($imageNext))?>">
			<?php endif; ?>
		</map>
	<?php endif; ?>
</body>
</html>
