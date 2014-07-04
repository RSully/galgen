<?php namespace RSully\Galgen;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use FilesystemIterator;
use SplFileInfo;

class Generator {

	protected $path;

	protected $directoryIterator;
	static protected $directoryIteratorOptions = FilesystemIterator::SKIP_DOTS;

	protected $iteratorIterator;

	public $config;

	public function __construct($path, $config = array())
	{
		$this->path = $path;

		$this->directoryIterator = new RecursiveDirectoryIterator($path, static::$directoryIteratorOptions);
		$this->iteratorIterator = new RecursiveIteratorIterator($this->directoryIterator);

		$this->config = $config;
	}

	public function config()
	{
		return array_merge([
			'ignored_files' => [],
			'theme' => 'copius',
			'output' => '_build',
		], $this->config);
	}

	public function isIgnoredFile(SplFileInfo $file)
	{
		foreach ($this->config()['ignore_files'] as $pattern)
		{
			if (fnmatch($pattern, $file->getPathname()))
			{
				return true;
			}
		}
		return false;
	}

	public function isValidImage(SplFileInfo $file)
	{
		if ($this->isIgnoredFile($file)) return false;
		if ($file->isDir()) return false;
		if ($file->getSize() < 1) return false;
		if ( ! $file->isReadable()) return false;
		if (@exif_imagetype($file) === false) return false;
		return true;
	}

	public function getPath()
	{
		return $this->path;
	}
	public function getOutputPath()
	{
		return $this->getPath() . DIRECTORY_SEPARATOR . $this->config()['output'];
	}

	public function images()
	{
		foreach ($this->iteratorIterator as $file)
		{
			/**
			 * Skip anything from a previous generation
			 */
			if (stripos($file->getPathname(), $this->getOutputPath()) !== false)
			{
				continue;
			}

			if ($this->isValidImage($file))
			{
				yield $file;
			}
		}
	}

	public function generate()
	{
		$images = iterator_to_array($this->images());

		$theme = $this->config()['theme'];
		$theme = realpath(__DIR__ . '/../themes/' . $theme);

		/**
		 * Copy assets
		 */
		$output = $this->getOutputPath();
		recursiveCopy($theme, $output);

		/**
		 * Write JSON data
		 */
		$imageData = array_map(function($image) use ($output)
		{
			return find_relative_path($output, $image->getPathname());
		}, $images);

		$data = json_encode([
			'images' => $imageData,
			'title' => basename($this->getPath()),
		]);
		file_put_contents($output . DIRECTORY_SEPARATOR . 'data.json', $data);

		/**
		 * Add setup code
		 */
		$file = $output . DIRECTORY_SEPARATOR . 'index.php';

		$contents = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'prepend.php') . PHP_EOL . file_get_contents($file);
		file_put_contents($file, $contents);
	}

}
