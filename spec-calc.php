<?php

    function specificity($selector) {

        // Pseudo classes
        $classes = array(":active", ":checked", ":default", ":dir()", ":disabled", ":empty", ":enabled", 
            ":first", ":first-child", ":first-of-type", ":fullscreen", ":focus", ":hover", ":indeterminate", 
            ":in-range", ":invalid", ":lang()", ":last-child", ":last-of-type", ":left", ":link", ":not()", 
            ":nth-child()", ":nth-last-child()", ":nth-last-of-type()", ":nth-of-type()", ":only-child", 
            ":only-of-type", ":optional", ":out-of-range", ":read-only", ":read-write", ":required", ":right", 
            ":root", ":scope", ":target", ":valid", ":visited");
        // Pseudo elements
        $elements = array(":before", ":after", ":first-line", ":first-letter", ":selection");
        // HTML tags
        $tags = array("a", "abbr", "address", "area", "article", "aside", "audio", "b", "base", "bdi", "bdo", 
            "blockquote", "body", "br", "button", "canvas", "caption", "cite", "code", "col", "colgroup", 
            "content", "data", "datalist", "dd", "decorator", "del", "details", "dfn", "dialog", "div", "dl", 
            "dt", "em", "embed", "fieldset", "figcaption", "figure", "footer", "form", "h1", "h2", "h3", "h4", 
            "h5", "h6", "head", "header", "hr", "html", "i", "iframe", "img", "input", "ins", "kbd", "keygen", 
            "label", "legend", "li", "link", "main", "map", "mark", "menu", "menuitem", "meta", "meter", "nav", 
            "noscript", "object", "ol", "optgroup", "option", "output", "p", "param", "picture", "pre", "progress", 
            "q", "rp", "rt", "ruby", "s", "samp", "script", "section", "select", "small", "source", "span", 
            "strong", "style", "sub", "summary", "sup", "table", "tbody", "td", "textarea", "tfoot", "th", "thead", 
            "time", "title", "tr", "track", "u", "ul", "var", "video", "wbr");

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