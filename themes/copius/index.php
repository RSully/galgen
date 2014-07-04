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

</head>
<body>
	<?php if (isset($image)): ?>
		<img src="<?=$image?>">
	<?php endif; ?>
</body>
</html>
