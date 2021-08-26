# FPDF Advanced Multicell Upgrade Guide

{{>toc}}

# 3.0.0

With the release of version 3.0.0 there are some functional changes to the Advanced Multicell class.

## Multicell `setStyle` function

With the implementation of **Style Inheritance**([#1931](https://tracker.interpid.eu/issues/1931))
the `$multicell->setStyle` method arguments changed it's order.

```php

    //new implementation
    public function setStyle($tag, $fontSize = null, $fontStyle = null, $color = null, $fontFamily = null, $inherit = 'base'){
    }

    //old implementation
    public function setStyle($tagName, $fontFamily, $fontStyle, $fontSize, $color){
    }
```

### Backward compatibility

The `$multicell->setStyleDep` method is provided for backward compatibility with the old `setStyle` method, so in order
to keep the "old" version, please rename all your `->setStyle` to `->setStyleDep`.

```php
//from version 3.0.0
$multicell->setStyle('p', 11, '', '130,0,30', 'helvetica');
$multicell->setStyle('b', 11, 'B', '130,0,30', 'helvetica');
$multicell->setStyle('i', 11, 'I', '80,80,260', 'helvetica');

//backward compatibility
$multicell->setStyleDep("p", 'helvetica', "", 11, "130,0,30");
$multicell->setStyleDep("b", 'helvetica', "B", 11, "130,0,30");
$multicell->setStyleDep("i", 'helvetica', "I", 11, "80,80,260");
```

## Subscripts and superscripts

The `ypos` sub-superscript parameter is deprecated. Use `y` instead. `ypos` is still available; it can be removed in
future releases.
