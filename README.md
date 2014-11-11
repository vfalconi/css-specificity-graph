# CSS Specificity Graph

The objective of this project is to take provided CSS, analyze the selectors, and generate a specificity graph (based on [this post](http://csswizardry.com/2014/10/the-specificity-graph/)).

Just so we're all on the same page, I will misspell "specificity" often and, just as often, not correct it.

Want a demo? [Here you go](https://vincefalconi.com/css-specificity-graph/).

## Requirements

1. PHP
2. Some CSS (minified or nah) that you want to analyze

## How To

1. Download and unzip this repo
2. Plug your CSS into styles.min.css
3. Open `index.html` in a browser

## Notes

1. Reading CSS from http://www.bewebmaster.com/228.php
2. Media Query block parsing from http://stackoverflow.com/questions/14145620/regular-expression-for-media-queries-in-css
3. CSS Specificity score calculation modeled on https://github.com/keeganstreet/specificity
4. D3.js is rad.