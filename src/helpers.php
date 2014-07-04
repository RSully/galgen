<?php namespace RSully\Galgen;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

function recursiveCopy($source, $dest)
{
	$directoryIterator = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
	$iterator = new RecursiveIteratorIterator($directoryIterator, RecursiveIteratorIterator::SELF_FIRST);

	if (! file_exists($dest))
	{
		mkdir($dest);
	}

	foreach ($iterator as $item)
	{
		$location = $dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName();

		if ($item->isDir())
		{
			if (! file_exists($location))
			{
				mkdir($location);
			}
		}
		else
		{
			copy($item, $location);
		}
	}
}


/**
 * Thanks https://gist.github.com/ohaal/2936041
 *
 *
 * Find the relative file system path between two file system paths
 *
 * @param  string  $frompath  Path to start from
 * @param  string  $topath    Path we want to end up in
 * @return string             Path leading from $frompath to $topath
 */
function find_relative_path ( $frompath, $topath ) {
    $from = explode( DIRECTORY_SEPARATOR, $frompath ); // Folders/File
    $to = explode( DIRECTORY_SEPARATOR, $topath ); // Folders/File
    $relpath = '';
 
    $i = 0;
    // Find how far the path is the same
    while ( isset($from[$i]) && isset($to[$i]) ) {
        if ( $from[$i] != $to[$i] ) break;
        $i++;
    }
    $j = count( $from ) - 1;
    // Add '..' until the path is the same
    while ( $i <= $j ) {
        if ( !empty($from[$j]) ) $relpath .= '..'.DIRECTORY_SEPARATOR;
        $j--;
    }
    // Go to folder from where it starts differing
    while ( isset($to[$i]) ) {
        if ( !empty($to[$i]) ) $relpath .= $to[$i].DIRECTORY_SEPARATOR;
        $i++;
    }
    
    // Strip last separator
    return substr($relpath, 0, -1);
}
