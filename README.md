1. Reading CSS from http://www.bewebmaster.com/228.php
2. Media Query parsing from http://stackoverflow.com/questions/14145620/regular-expression-for-media-queries-in-css
	- changed `$mediaBlocks[] = substr($css, $start, ($i + 1) - $start);` to `$mediaBlocks[] = substr($css, $start, ($i - $start);` because it was borking minified CSS
3. CSS Specificity function from https://gist.github.com/absfarah/2774085