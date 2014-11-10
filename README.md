# CSS Specificity Graph

The objective of this project is to take provided CSS, analyze the selectors, and generate a specificity graph (based on [this post](http://csswizardry.com/2014/10/the-specificity-graph/)).

Just so we're all on the same page, I will misspell "specificity" often and, just as often, not correct it.

## Notes

1. Reading CSS from http://www.bewebmaster.com/228.php
2. Media Query block parsing from http://stackoverflow.com/questions/14145620/regular-expression-for-media-queries-in-css
	- **Change:** `while (($start = strpos($css_contents, "@media", $start)) !== false)` to `while (($start = strpos($css_contents, "@", $start)) !== false)` **Reason:** There's no need to include `@font-face` and animation blocks in the analysis, so making the loop look for `@` makes the script remove all unnecessary blocks.
	- **Change:** `$mediaBlocks[] = substr($css, $start, ($i + 1) - $start);` to `$mediaBlocks[] = substr($css, $start, ($i - $start);` **Reason:** The `$i + 1` was breaking selectors for the block following the current block in the loop.
3. CSS Specificity score calculation modeled on https://github.com/keeganstreet/specificity