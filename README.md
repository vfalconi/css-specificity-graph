# CSS Specificity Graph

The objective of this project is to take provided CSS, analyze the selectors, and generate a specificity graph (based on [this post](http://csswizardry.com/2014/10/the-specificity-graph/)).

Just so we're all on the same page, I will misspell "specificity" often and, just as often, not correct it.

## Notes

1. Reading CSS from http://www.bewebmaster.com/228.php
2. Media Query parsing from http://stackoverflow.com/questions/14145620/regular-expression-for-media-queries-in-css
	- changed `$mediaBlocks[] = substr($css, $start, ($i + 1) - $start);` to `$mediaBlocks[] = substr($css, $start, ($i - $start);` because it was borking minified CSS
3. CSS Specificity function from https://gist.github.com/absfarah/2774085
	- updated selectors lists to include HTML5 elements and CSS3 pseudo-classes