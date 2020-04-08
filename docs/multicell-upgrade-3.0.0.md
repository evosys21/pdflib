# FPDF Advanced Multicell Upgrade to version 3.0.0

With the release of version 3.0.0 there are some functional changes to the Advanced Multicell class.

## Multicell `setStyle` function

With the implementation of **Style Inheritance**([#1931](https://tracker.interpid.eu/issues/1931)) 
the `$multicell->setStyle` method changed the order if it's parameters

```php

    //new 
    public function setStyle($tag, $fontSize = null, $fontStyle = null, $color = null, $fontFamily = null, $inherit = 'base'){
    }

    //old 
    public function setStyle($tagName, $fontFamily, $fontStyle, $fontSize, $color){
    }
```

The `$multicell->setStyleDep` method is provided for backward compatibility with the old `setStyle` method.

## Subscripts and superscripts

The `ypos` sub-superscript parameter is deprecated. Use `y` instead. `ypos` is still available; it can be removed in future releases.