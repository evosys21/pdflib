$env:XDEBUG_MODE = "coverage"
phpunit --coverage-html=.report/coverage-php $args
Start-Process "./.report/coverage-php/index.html"
