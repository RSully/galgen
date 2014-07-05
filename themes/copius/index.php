<?php
function ea($a)
{
	return htmlspecialchars(urlencode($a));
}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>

	<link rel="stylesheet" type="text/css" href="static/reset.css">
	<script type="text/javascript" src="static/jquery-2.1.1.min.js"></script>


	<style type="text/css">
	.col {
		float: left;
	}
	/* Fix scroll issue */
	img {
		vertical-align: top;
	}
	</style>

	<script type="text/javascript">
	imagePrevious = <?=json_encode(isset($imagePrevious) ? $imagePrevious : null)?>;
	imageNext = <?=json_encode(isset($imageNext) ? $imageNext : null)?>;

	function resizeImage()
	{
		var img = $('#image img');
		var map = $('#image map[name=imageMap]');

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
		$('#image img').on('load', function()
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

		<div id="image">

			<img usemap="#imageMap" src="<?=ea($image)?>">

			<map name="imageMap">
				<area shape="rect" coords="0,0,0,0" data-coordsperc="0, 0, 1, .2" href="?">
				<?php if (isset($imagePrevious)): ?>
					<area shape="rect" coords="0,0,0,0" data-coordsperc="0, .2, 0.5, 1" href="?image=<?=ea($imagePrevious)?>">
				<?php endif; ?>
				<?php if (isset($imageNext)): ?>
					<area shape="rect" coords="0,0,0,0" data-coordsperc="0.5, .2, 1, 1" href="?image=<?=ea($imageNext)?>">
				<?php endif; ?>
			</map>

		</div>

	<?php else: ?>

		<div id="images" class="row">

			<?php foreach ($images as $image): ?>
				<div class="col">
					<a href="?image=<?=ea($image)?>">
						<img height="200" src="<?=ea($image)?>">
					</a>
				</div>
			<?php endforeach; ?>

		</div>

	<?php endif; ?>
</body>
</html>
