<?php

    function specificity($selector) {

        // Pseudo classes
        $classes = array(":link", ":visited", ":hover", ":active", ":focus", ":target", ":lang", ":enabled",
            ":disabled", ":checked", ":indeterminate", ":root", ":nth-child", ":nth-last-child",
            ":nth-of-type", ":nth-last-of-type", ":first-child", ":last-child", ":first-of-type",
            ":last-of-type", ":only-child", ":only-of-type", ":empty", ":contains", ":not");
        // Pseudo elements
        $elements = array(":before", ":after", ":first-line", ":first-letter", ":selection");
        // HTML tags
        $tags = array("a", "abbr", "acronym", "address", "applet", "area", "b", "base", "basefont", "bgsound",
            "bdo", "big", "blink", "blockquote", "body", "br", "button", "caption", "center", "cite",
            "code", "col", "colgroup", "comment", "dd", "del", "dfn", "dir", "div", "dl", "dt", "em",
            "embed", "fieldset", "font", "form", "frame", "frameset", "h", "h1", "h2", "h3", "h4", "h5",
            "h6", "head", "hr", "html", "i", "iframe", "img", "input", "ins", "isindex", "kbd", "label",
            "legend", "li", "link", "listing", "map", "marquee", "menu", "meta", "multicol", "nextid",
            "nobr", "noframes", "noscript", "object", "ol", "optgroup", "option", "p", "param", "plaintext",
            "pre", "q", "s", "samp", "script", "select", "server", "small", "sound", "spacer", "span",
            "strike", "strong", "style", "sub", "sup", "table", "tbody", "td", "textarea", "textflow",
            "tfoot", "th", "thead", "title", "tr", "tt", "u", "ul", "var", "wbr", "xmp");

        // Strip slashes
        $data = preg_replace("/\/\\*[\\s\\S]*?\\*\//", "", $selector);      // Strip comments
        $data = preg_replace("/\{(.*?)\}/s", ", ", $data);                  // Strip content and replace with delimiter
        $data = str_replace(" ,", ",", $data);                              // Strip spaces after selectors

        $tmp = explode(",", $data);                                         // Get rid of selector groupings
        array_walk($tmp, 'trim');                                        // Trim whitespace from end of selectors
        $score = 0;                                                         // Set the score to 0
        // Loop through the selector array
        foreach ($tmp as $var) {
            if (!empty($var)) {
                $score += substr_count($var, '#') * 100;                    // Count the IDs and multiple by 100 (i.e. #itemID)
                $score += substr_count($var, '.') * 10;                     // Count the classes and multiple by 10 (i.e. .classname)
                $score += substr_count($var, '[') * 10;                     // Count the attributes and multiple by 10 (i.e. input[type=text])

                foreach ($classes as $test) {                               // Count the pseudo-classes and multiple by 10
                    $score += substr_count($var, $test) * 10;
                }

                foreach ($elements as $test) {                              // Count the pseudo-elements;
                    $score += substr_count($var, $test);
                }

                $cleaned = str_replace(":link", " ", $var);                 // Remove the pseudo selectors that match HTML tags

                $cleaned = str_replace(":", " ", $cleaned);                 // Remove the pseudo selector
                $cleaned = str_replace("+", " ", $cleaned);                 // Remove the adjacent sibling selector
                $cleaned = str_replace(">", " ", $cleaned);                 // Remove the child selector
                $cleaned = str_replace("*", " ", $cleaned);                 // Remove the universal selector
                $cleaned = str_replace(".", " ", $cleaned);                 // Remove the class selector
                $cleaned = str_replace("#", " ", $cleaned);                 // Remove the ID selector

                $cleaned = explode(" ", $cleaned);                          // Explode on space
                foreach ($cleaned as $rubbish) {                            // Count the type selectors (i.e. HTML tags)
                    if (in_array(strtolower($rubbish), $tags)) {
                        $score++;
                    }
                }
            }
        }

        return $score;
    }
?>