The Relative Date plugin for Kirby CMS displays date and time to a human-readable relative format. It converts your absolute date (and time) in something relative and more readable, e.g.: 

> 2 months 3 days ago  
> 5 hours 47 minutes 18 seconds from now  

# Installation
1. [Download](https://github.com/distantnative/relative-date/archive/master.zip) the current release.
2. Copy everything to `site/plugins/relative-date/`.

To **update** to a higher version of this plugin, replace the files with the newer version.

# Usage
You can either use it as field method:
```php
<?php echo $page->published()->relative() ?>
```

Or as [Kirbytext](http://getkirby.com/docs/content/text) tag:
```
Published: (relativedate: 2015-02-15)
```

# Options

You can find the full information and documentation of all options over at the [Github repository](https://github.com/distantnative/relative-date).


# Languages supported

Arabic, Bulgarian, Catalan, Chinese, Chinese Taiwan, Czech, Danish, Dutch, English, Finnish, French, German, Italian, Japanese, Norwegian, Polish, Portuguese, Portuguese Brazilian, Romanian, Russian, Serbian, Spanish, Swedish, Thai, Turkish – [help with them is always appreciated](https://github.com/distantnative/relative-date/issues/32).
